<?php

namespace App\Services;

use App\Helpers\SettingHelper;
use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\News;
use App\Models\Room;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatbotService
{
    protected string $apiKey;
    protected string $apiUrl;
    protected string $model;
    protected array $centerInfo;
    protected bool $useLocalLLM;
    protected string $localLLMUrl;
    protected string $localLLMModel;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key', env('MEGALLM_API_KEY', ''));
        $this->apiUrl = config('services.openai.api_url', 'https://ai.megallm.io/v1');
        $this->model = config('services.openai.model', 'deepseek-ai/deepseek-v3.1');

        $this->useLocalLLM = filter_var(env('USE_LOCAL_LLM', true), FILTER_VALIDATE_BOOL);
        $this->localLLMUrl = env('LOCAL_LLM_URL', 'http://localhost:11434');
        $this->localLLMModel = env('LOCAL_LLM_MODEL', 'qwen2.5:7b');

        $this->centerInfo = [
            'name' => SettingHelper::get('center_name', 'Trung tâm đào tạo'),
            'phone' => SettingHelper::get('phone', ''),
            'email' => SettingHelper::get('email', ''),
            'address' => SettingHelper::get('address', ''),
            'zalo' => SettingHelper::get('zalo', ''),
        ];
    }

    protected function buildSystemPrompt(): array
    {
        $centerName = $this->centerInfo['name'];
        $phone = $this->centerInfo['phone'];
        $email = $this->centerInfo['email'];
        $address = $this->centerInfo['address'];

        $coursesData = $this->getCoursesInfo();
        $roomsData = $this->getRoomsInfo();
        $categoriesData = $this->getCategoriesInfo();
        $statsData = $this->getStatistics();
        $latestNews = $this->getLatestNews();

        $systemContent = <<<PROMPT
# VAI TRÒ
Bạn là Trợ lý AI chuyên nghiệp của {$centerName} - một trung tâm đào tạo uy tín.

# THÔNG TIN LIÊN HỆ
- Hotline: {$phone}
- Email: {$email}
- Địa chỉ: {$address}
- Zalo: {$this->centerInfo['zalo']}

# THỐNG KÊ TRUNG TÂM
{$statsData}

# DANH MỤC KHÓA HỌC
{$categoriesData}

# DANH SÁCH KHÓA HỌC HIỆN CÓ
{$coursesData}

# PHÒNG HỌC
{$roomsData}

# TIN TỨC MỚI NHẤT
{$latestNews}

# NHIỆM VỤ CỦA BẠN
1. Tư vấn khóa học phù hợp nhu cầu người dùng, gồm học phí, thời gian, lịch khai giảng.
2. Hướng dẫn đăng ký khóa học trực tuyến hoặc trực tiếp.
3. Cung cấp thông tin phòng học, thiết bị, sức chứa.
4. Trả lời câu hỏi về chính sách, ưu đãi, lịch học.
5. Hướng dẫn quy trình đặt phòng học cho cá nhân hoặc tổ chức.

# QUY TẮC TRẢ LỜI
- Trả lời bằng tiếng Việt, thân thiện, chuyên nghiệp.
- Dùng markdown rõ ràng, dễ đọc.
- Giới thiệu thông tin cụ thể: tên khóa học, giá, thời gian.
- Nếu thiếu dữ liệu, đề nghị liên hệ hotline {$phone}.
- Trả lời ngắn gọn, dưới 200 từ.
- Khi người dùng muốn đăng ký, gợi ý trang khóa học phù hợp.

# LƯU Ý
- Chỉ dùng dữ liệu đã có, không bịa đặt thông tin.
- Luôn khuyến khích khách hàng liên hệ trực tiếp để tư vấn chi tiết.
PROMPT;

        return [
            'role' => 'system',
            'content' => $systemContent,
        ];
    }

    protected function getCoursesInfo(): string
    {
        try {
            $courses = Course::with('category')
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->take(20)
                ->get();

            if ($courses->isEmpty()) {
                return 'Chưa có khóa học nào.';
            }

            $info = '';
            foreach ($courses as $course) {
                $price = $course->price > 0 ? number_format((int) $course->price) . 'đ' : 'Miễn phí';
                $category = $course->category ? $course->category->name : 'Chung';
                $startDate = $course->start_date ? Carbon::parse($course->start_date)->format('d/m/Y') : 'Liên hệ';

                $info .= "- {$course->title} ({$category})\n";
                $info .= "  + Học phí: {$price}\n";
                $info .= "  + Khai giảng: {$startDate}\n";
                $info .= "  + Link: /khoa-hoc/{$course->slug}\n\n";
            }

            return $info;
        } catch (\Exception $e) {
            Log::error('getCoursesInfo error: ' . $e->getMessage());
            return 'Chưa có khóa học nào.';
        }
    }

    protected function getRoomsInfo(): string
    {
        try {
            $rooms = Room::with('equipment')->where('status', 'available')->get();

            if ($rooms->isEmpty()) {
                return 'Chưa có thông tin phòng học.';
            }

            $info = '';
            foreach ($rooms as $room) {
                $roomId = $room->getKey();
                $price = $room->price > 0 ? number_format((int) $room->price) . 'đ/giờ' : 'Miễn phí';
                $equipmentList = $room->equipment && $room->equipment->isNotEmpty()
                    ? $room->equipment->pluck('name')->implode(', ')
                    : 'Đầy đủ thiết bị';

                $todayBookings = RoomBooking::where('room_id', $roomId)
                    ->where('status', 'approved')
                    ->where('start_date', '<=', now()->toDateString())
                    ->where('end_date', '>=', now()->toDateString())
                    ->count();

                $availability = $todayBookings > 0 ? 'Đang có lịch' : 'Trống';

                $info .= "- {$room->name}\n";
                $info .= "  + Sức chứa: {$room->capacity} người\n";
                $info .= "  + Giá thuê: {$price}\n";
                $info .= "  + Thiết bị: {$equipmentList}\n";
                $info .= "  + Tình trạng hôm nay: {$availability}\n";
                $info .= "  + Link: /phong-hoc/{$roomId}\n\n";
            }

            return $info;
        } catch (\Exception $e) {
            Log::error('getRoomsInfo error: ' . $e->getMessage());
            return 'Chưa có thông tin phòng học.';
        }
    }

    protected function getCategoriesInfo(): string
    {
        try {
            $categories = Category::withCount('courses')->get();

            if ($categories->isEmpty()) {
                return 'Chưa có danh mục.';
            }

            $info = '';
            foreach ($categories as $cat) {
                $info .= "- {$cat->name}: {$cat->courses_count} khóa học\n";
            }

            return $info;
        } catch (\Exception) {
            return 'Chưa có danh mục.';
        }
    }

    protected function getStatistics(): string
    {
        try {
            $totalCourses = Course::where('status', 'published')->count();
            $totalRooms = Room::where('status', 'available')->count();
            $totalCategories = Category::count();
            $totalStudents = CourseRegistration::whereNotNull('student_email')
                ->distinct('student_email')
                ->count('student_email');

            return "- Tổng số khóa học: {$totalCourses}\n- Số phòng học: {$totalRooms}\n- Số danh mục: {$totalCategories}\n- Số học viên đã đăng ký: {$totalStudents}";
        } catch (\Exception) {
            return '- Thông tin đang cập nhật';
        }
    }

    protected function getLatestNews(): string
    {
        try {
            $news = News::where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->take(5)
                ->get();

            if ($news->isEmpty()) {
                return 'Chưa có tin tức mới.';
            }

            $info = '';
            foreach ($news as $item) {
                $date = $item->published_at ? Carbon::parse($item->published_at)->format('d/m/Y') : '';
                $info .= "- [{$date}] {$item->title}\n";
            }

            return $info;
        } catch (\Exception) {
            return 'Chưa có tin tức mới.';
        }
    }

    protected function analyzeIntent(string $message): array
    {
        $message = mb_strtolower($message);

        $intents = [
            'greeting' => ['xin chào', 'xin chao', 'hello', 'hi ', 'chào bạn', 'chao ban', ' chào ', 'hey ', 'alo', '^chao$', '^hi$'],
            'course_inquiry' => ['khóa học', 'khoá học', 'khoa hoc', 'học gì', 'đào tạo', 'lớp học', 'course', 'có những', 'danh sách khóa'],
            'price_inquiry' => ['giá', 'học phí', 'hoc phi', 'phi', 'bao nhiêu tiền', 'chi phí', 'tiền học', 'bảng giá', 'bang gia'],
            'registration' => ['đăng ký', 'đăng kí', 'dang ky', 'ghi danh', 'tham gia', 'register', 'muốn học', 'cách đăng ký'],
            'schedule' => ['lịch học', 'lich hoc', 'thời gian học', 'khi nào', 'bao giờ', 'khai giảng', 'khai giang', 'mở lớp', 'lịch khai giảng'],
            'room_inquiry' => ['phòng học', 'phong hoc', 'room', 'cơ sở', 'địa điểm học', 'thuê phòng', 'thue phong', 'phòng máy'],
            'contact' => ['liên hệ', 'lien he', 'hotline', 'điện thoại', 'dien thoai', 'email', 'địa chỉ', 'contact', 'số điện thoại'],
            'thanks' => ['cảm ơn', 'cam on', 'thanks', 'thank you', 'tks', 'cám ơn'],
            'goodbye' => ['tạm biệt', 'tam biet', 'bye', 'goodbye', 'hẹn gặp lại', 'chào tạm biệt'],
            'promotion' => ['khuyến mãi', 'khuyen mai', 'ưu đãi', 'uu dai', 'giảm giá', 'sale', 'discount', 'giảm học phí'],
            'news' => ['tin tức', 'tin tuc', 'tin mới', 'news', 'thông báo', 'có gì mới'],
            'help' => ['giúp tôi', 'hỗ trợ', 'ho tro', 'help', 'support', 'trợ giúp', 'làm gì được'],
        ];

        $detectedIntents = [];
        foreach ($intents as $intent => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_starts_with($keyword, '^')) {
                    if (preg_match('/' . $keyword . '/u', $message)) {
                        $detectedIntents[] = $intent;
                        break;
                    }
                } elseif (str_contains($message, $keyword)) {
                    $detectedIntents[] = $intent;
                    break;
                }
            }
        }

        if (empty($detectedIntents)) {
            if (preg_match('/\b(khóa|khoá|khoa|học|hoc|lớp)\b/u', $message)) {
                $detectedIntents[] = 'course_inquiry';
            }
            if (preg_match('/\b(phí|phi|tiền|tien|giá|gia)\b/u', $message)) {
                $detectedIntents[] = 'price_inquiry';
            }
        }

        return array_unique($detectedIntents);
    }

    protected function searchCourse(string $query): ?Course
    {
        try {
            return Course::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%");
                })
                ->first();
        } catch (\Exception) {
            return null;
        }
    }

    protected function getContextualData(string $message): string
    {
        $context = '';

        $course = $this->searchCourse($message);
        if ($course) {
            $price = $course->price > 0 ? number_format((int) $course->price) . 'đ' : 'Miễn phí';
            $context .= "\n[KHÓA HỌC TÌM THẤY]\n";
            $context .= "Tên: {$course->title}\n";
            $context .= "Học phí: {$price}\n";
            $context .= 'Mô tả: ' . Str::limit(strip_tags($course->description ?? ''), 200) . "\n";
            $context .= "Link đăng ký: /khoa-hoc/{$course->slug}\n";
        }

        if (Auth::check()) {
            $user = Auth::user();
            $context .= "\n[THÔNG TIN NGƯỜI DÙNG]\n";
            $context .= "Tên: {$user->name}\n";
            $context .= "Email: {$user->email}\n";
            $context .= "(Người dùng đã đăng nhập - có thể gọi tên họ)\n";
        }

        return $context;
    }

    public function chat(string $message, Request $request): array
    {
        try {
            $userId = Auth::id();
            $sessionId = $request->session()->getId();

            $this->saveMessage($message, 'user', $userId, $sessionId, $request);

            $history = $this->getConversationContext($userId, $sessionId);
            $aiResponse = $this->callAI($message, $history);

            $this->saveMessage($aiResponse, 'assistant', $userId, $sessionId, $request);

            return [
                'success' => true,
                'message' => $aiResponse,
                'is_authenticated' => (bool) $userId,
            ];
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Xin lỗi, tôi đang gặp sự cố. Vui lòng thử lại sau hoặc liên hệ hotline ' . $this->centerInfo['phone'] . ' để được hỗ trợ.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ];
        }
    }

    protected function callAI(string $message, array $history = []): string
    {
        $systemPrompt = $this->buildSystemPrompt();

        $contextualData = $this->getContextualData($message);
        $enhancedMessage = $message;
        if ($contextualData) {
            $enhancedMessage .= "\n\n---\n[DỮ LIỆU BỔ SUNG]{$contextualData}";
        }

        if ($this->useLocalLLM) {
            try {
                $result = $this->callLocalLLM($systemPrompt['content'], $enhancedMessage, $history);
                if ($result) {
                    return $result;
                }
            } catch (\Exception $e) {
                Log::warning('Local LLM failed, trying remote: ' . $e->getMessage());
            }
        }

        if (empty($this->apiKey)) {
            return $this->getIntelligentResponse($message);
        }

        $messages = [$systemPrompt];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'],
                'content' => $msg['message'],
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $enhancedMessage,
        ];

        try {
            $apiEndpoint = rtrim($this->apiUrl, '/') . '/chat/completions';

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($apiEndpoint, [
                'model' => $this->model,
                'messages' => $messages,
                'max_tokens' => 800,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? $this->getIntelligentResponse($message);
            }

            Log::error('AI API Error: ' . $response->body());
            return $this->getIntelligentResponse($message);
        } catch (\Exception $e) {
            Log::error('AI API Exception: ' . $e->getMessage());
            return $this->getIntelligentResponse($message);
        }
    }

    protected function callLocalLLM(string $systemPrompt, string $userMessage, array $history = []): ?string
    {
        $apiUrl = rtrim($this->localLLMUrl, '/') . '/api/chat';

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'assistant' ? 'assistant' : 'user',
                'content' => $msg['message'],
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        $response = Http::timeout(180)->post($apiUrl, [
            'model' => $this->localLLMModel,
            'messages' => $messages,
            'stream' => false,
            'options' => [
                'temperature' => 0.7,
                'num_predict' => 800,
            ],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $content = $data['message']['content'] ?? null;
            if ($content) {
                Log::info('Local LLM response received successfully');
                return $content;
            }
        }

        Log::error('Local LLM Error: ' . $response->body());
        return null;
    }

    protected function formatList(array $items): string
    {
        return implode("\n", array_map(fn ($item) => "- {$item}", $items));
    }

    protected function formatResponse(string $title, array $items = [], array $actions = []): string
    {
        $sections = [$title];

        if (!empty($items)) {
            $sections[] = $this->formatList($items);
        }

        if (!empty($actions)) {
            $sections[] = "Bạn có thể tiếp tục:\n" . $this->formatList($actions);
        }

        return implode("\n\n", $sections);
    }

    protected function getIntelligentResponse(string $message): string
    {
        $message = mb_strtolower($message);
        $centerName = $this->centerInfo['name'];
        $phone = $this->centerInfo['phone'];
        $email = $this->centerInfo['email'];
        $intents = $this->analyzeIntent($message);

        if (in_array('course_inquiry', $intents, true) || in_array('price_inquiry', $intents, true)) {
            try {
                $courses = Course::where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

                if ($courses->isNotEmpty()) {
                    $courseLines = [];
                    foreach ($courses as $course) {
                        $price = $course->price > 0 ? number_format((int) $course->price) . 'đ' : 'Miễn phí';
                        $startDate = $course->start_date ? Carbon::parse($course->start_date)->format('d/m/Y') : 'Liên hệ';
                        $courseLines[] = "{$course->title} | Học phí: {$price} | Khai giảng: {$startDate}";
                    }

                    return $this->formatResponse(
                        "Danh sách khóa học nổi bật tại {$centerName}",
                        $courseLines,
                        [
                            'Xem đầy đủ tại /khoa-hoc',
                            "Liên hệ tư vấn nhanh: {$phone}",
                        ]
                    );
                }

                return $this->formatResponse(
                    "Thông tin học phí tại {$centerName}",
                    ['Hiện tại hệ thống đang cập nhật danh sách khóa học mới.'],
                    [
                        "Gọi hotline: {$phone}",
                        "Gửi email: {$email}",
                    ]
                );
            } catch (\Exception $e) {
                Log::error('Chatbot course query error: ' . $e->getMessage());
                return $this->formatResponse(
                    'Hiện chưa thể truy xuất dữ liệu học phí lúc này.',
                    [],
                    [
                        "Liên hệ hotline: {$phone}",
                        "Email hỗ trợ: {$email}",
                    ]
                );
            }
        }

        if (in_array('schedule', $intents, true)) {
            try {
                $upcomingCourses = Course::where('status', 'published')
                    ->whereNotNull('start_date')
                    ->where('start_date', '>=', now())
                    ->orderBy('start_date')
                    ->take(3)
                    ->get();

                if ($upcomingCourses->isNotEmpty()) {
                    $scheduleLines = [];

                    foreach ($upcomingCourses as $course) {
                        $date = Carbon::parse($course->start_date)->format('d/m/Y');
                        $scheduleLines[] = "{$course->title}: {$date}";
                    }

                    return $this->formatResponse(
                        'Lịch khai giảng sắp tới',
                        $scheduleLines,
                        ["Đăng ký ngay qua hotline: {$phone}"]
                    );
                }
            } catch (\Exception) {
            }

            return $this->formatResponse(
                'Lịch học linh hoạt theo ca',
                [
                    'Ca sáng: 8:00 - 11:30',
                    'Ca chiều: 14:00 - 17:30',
                    'Ca tối: 18:00 - 21:00',
                ],
                ["Liên hệ {$phone} để được tư vấn ca học phù hợp"]
            );
        }

        if (in_array('room_inquiry', $intents, true)) {
            try {
                $rooms = Room::with('equipment')->where('status', 'available')->take(5)->get();

                if ($rooms->isNotEmpty()) {
                    $roomLines = [];

                    foreach ($rooms as $room) {
                        $roomId = $room->getKey();
                        $price = $room->price > 0 ? number_format((int) $room->price) . 'đ/giờ' : 'Miễn phí';

                        $todayBookings = RoomBooking::where('room_id', $roomId)
                            ->where('status', 'approved')
                            ->where('start_date', '<=', now()->toDateString())
                            ->where('end_date', '>=', now()->toDateString())
                            ->count();

                        $availability = $todayBookings > 0 ? '(Đang có lịch)' : '(Trống)';
                        $roomLines[] = "{$room->name}: {$room->capacity} người | {$price} {$availability}";
                    }

                    return $this->formatResponse(
                        "Danh sách phòng học tại {$centerName}",
                        $roomLines,
                        ['Xem chi tiết và đặt phòng tại /phong-hoc']
                    );
                }
            } catch (\Exception $e) {
                Log::error('Room inquiry error: ' . $e->getMessage());
            }
        }

        if (in_array('registration', $intents, true)) {
            return $this->formatResponse(
                'Hướng dẫn đăng ký khóa học',
                [
                    'Đăng ký online: Truy cập /khoa-hoc, chọn khóa phù hợp và nhấn Đăng ký ngay',
                    "Đăng ký trực tiếp: Gọi {$phone} hoặc đến {$this->centerInfo['address']}",
                ],
                ['Đăng ký sớm để nhận ưu đãi học phí']
            );
        }

        if (in_array('contact', $intents, true)) {
            return $this->formatResponse(
                "Thông tin liên hệ {$centerName}",
                [
                    "Hotline: {$phone}",
                    "Email: {$email}",
                    "Địa chỉ: {$this->centerInfo['address']}",
                    "Zalo: {$this->centerInfo['zalo']}",
                    'Thời gian làm việc: 8:00 - 21:00 (T2 - T7)',
                ]
            );
        }

        if (in_array('promotion', $intents, true)) {
            return $this->formatResponse(
                'Ưu đãi hiện có',
                [
                    'Giảm 10% khi đăng ký nhóm từ 3 người',
                    'Giảm 5% khi thanh toán 100% học phí',
                    'Miễn phí tài liệu học tập',
                ],
                ["Liên hệ {$phone} để được áp dụng ưu đãi"]
            );
        }

        if (in_array('news', $intents, true)) {
            try {
                $news = News::where('is_published', true)
                    ->orderBy('published_at', 'desc')
                    ->take(3)
                    ->get();

                if ($news->isNotEmpty()) {
                    $newsLines = [];
                    foreach ($news as $item) {
                        $newsLines[] = (string) $item->title;
                    }

                    return $this->formatResponse(
                        'Tin tức mới nhất',
                        $newsLines,
                        ['Xem thêm tại /tin-tuc']
                    );
                }
            } catch (\Exception) {
            }
        }

        if (in_array('thanks', $intents, true)) {
            return 'Không có gì ạ. Rất vui được hỗ trợ bạn. Nếu cần thêm thông tin, đừng ngại hỏi tôi nhé.';
        }

        if (in_array('goodbye', $intents, true)) {
            return 'Tạm biệt bạn. Chúc bạn một ngày tốt lành và hẹn gặp lại.';
        }

        if (in_array('help', $intents, true)) {
            return $this->formatResponse(
                'Tôi có thể hỗ trợ bạn các nội dung sau',
                [
                    'Tư vấn khóa học phù hợp mục tiêu',
                    'Thông tin học phí và ưu đãi',
                    'Lịch khai giảng và lịch học',
                    'Hướng dẫn đăng ký khóa học',
                    'Thông tin phòng học và đặt phòng',
                    'Thông tin liên hệ tư vấn trực tiếp',
                ],
                ['Bạn chỉ cần nhắn nội dung cần hỗ trợ để mình xử lý ngay']
            );
        }

        if (in_array('greeting', $intents, true)) {
            $greeting = Auth::check() ? 'Xin chào ' . Auth::user()->name . '!' : 'Xin chào bạn!';
            return $this->formatResponse(
                $greeting,
                [
                    "Mình là trợ lý AI của {$centerName}",
                    'Mình hỗ trợ tư vấn khóa học, học phí, lịch khai giảng và thông tin phòng học',
                ],
                ['Bạn cần mình hỗ trợ nội dung nào trước?']
            );
        }

        return $this->formatResponse(
            "Cảm ơn bạn đã liên hệ {$centerName}",
            [
                'Mình có thể hỗ trợ: tư vấn khóa học, học phí, lịch khai giảng, đặt phòng học',
            ],
            [
                'Nhắn nội dung bạn đang quan tâm để mình tư vấn chi tiết',
                "Hoặc gọi hotline: {$phone}",
            ]
        );
    }

    protected function saveMessage(string $message, string $role, ?int $userId, string $sessionId, Request $request): ChatMessage
    {
        return ChatMessage::create([
            'user_id' => $userId,
            'session_id' => $userId ? null : $sessionId,
            'role' => $role,
            'message' => $message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    protected function getConversationContext(?int $userId, string $sessionId, int $limit = 10): array
    {
        $query = ChatMessage::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        return $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->reverse()
            ->map(fn ($msg) => [
                'role' => $msg->role,
                'message' => $msg->message,
            ])
            ->toArray();
    }

    public function getHistory(Request $request, int $limit = 50): array
    {
        $userId = Auth::id();
        $sessionId = $request->session()->getId();

        $query = ChatMessage::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        $messages = $query->orderBy('created_at', 'asc')
            ->limit($limit)
            ->get()
            ->map(fn ($msg) => [
                'chat_message_id' => $msg->chat_message_id,
                'role' => $msg->role,
                'message' => $msg->message,
                'created_at' => $msg->created_at->format('H:i d/m/Y'),
            ])
            ->toArray();

        return [
            'success' => true,
            'messages' => $messages,
            'is_authenticated' => (bool) $userId,
        ];
    }

    public function clearHistory(Request $request): array
    {
        $userId = Auth::id();
        $sessionId = $request->session()->getId();

        $query = ChatMessage::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        $deleted = $query->delete();

        return [
            'success' => true,
            'deleted' => $deleted,
        ];
    }
}
