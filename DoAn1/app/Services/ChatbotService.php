<?php

namespace App\Services;

use App\Helpers\SettingHelper;
use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Course;
use App\Models\News;
use App\Models\Room;
use App\Models\RoomBookingDetail;
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
    protected ?int $lastApiStatusCode = null;
    protected ?string $lastApiErrorBody = null;

    public function __construct()
    {
        $this->apiKey = env('AI_API_KEY', '');
        $this->apiUrl = env('AI_API_URL', 'https://api.openai.com/v1');
        $this->model = env('AI_MODEL', 'gpt-3.5-turbo');

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

    public function chat(string $message, Request $request): array
    {
        $userId = Auth::id();
        $sessionId = $request->session()->getId();
        $trackedSessionIds = $this->trackAndGetChatSessionIds($request, $userId, $sessionId);

        try {
            if ($userId) {
                $this->syncGuestSessionMessagesToUser($userId, $trackedSessionIds);
            }

            $this->saveMessage($message, 'user', $userId, $sessionId, $request);

            $availabilityResponse = $this->handleRoomAvailabilityQuery($message);
            if ($availabilityResponse !== null) {
                $this->saveMessage($availabilityResponse, 'assistant', $userId, $sessionId, $request);

                return $this->buildSuccessResponse($availabilityResponse, $userId);
            }

            $history = $this->getConversationContext($userId, $sessionId, 10, $trackedSessionIds);
            $aiResponse = $this->callAI($message, $history);

            $this->saveMessage($aiResponse, 'assistant', $userId, $sessionId, $request);

            return $this->buildSuccessResponse($aiResponse, $userId);
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());

            $fallbackMessage = 'Xin lỗi, tôi đang gặp sự cố. Vui lòng thử lại sau hoặc liên hệ hotline ' . $this->centerInfo['phone'] . ' để được hỗ trợ.';

            // Cố gắng lưu phản hồi lỗi để lịch sử hội thoại không bị đứt đoạn.
            try {
                $this->saveMessage($fallbackMessage, 'assistant', $userId, $sessionId, $request);
            } catch (\Exception $saveException) {
                Log::error('Chatbot fallback save error: ' . $saveException->getMessage());
            }

            return [
                'success' => true,
                'message' => $fallbackMessage,
                'error' => config('app.debug') ? $e->getMessage() : null,
                'is_authenticated' => (bool) $userId,
            ];
        }
    }

    protected function buildSuccessResponse(string $message, ?int $userId): array
    {
        return [
            'success' => true,
            'message' => $message,
            'is_authenticated' => (bool) $userId,
        ];
    }

    protected function buildSystemPrompt(): string
    {
        $categories = Category::query()
            ->select(['category_id', 'name'])
            ->withCount([
                'courses as open_courses_count' => fn($q) => $q->where('status', 'published')
            ])
            ->get();

        $courses = Course::query()
            ->select([
                'course_id',
                'category_id',
                'title',
                'slug',
                'price',
                'is_price_visible',
                'start_date',
                'status',
                'max_students',
                'allow_overflow'
            ])
            ->with('category:category_id,name')
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->map(fn($c) => [
                'title' => $c->title,
                'category' => $c->category?->name,
                'public_price' => $c->is_price_visible ? (int) $c->price : null,
                'start_date' => optional($c->start_date)->format('d/m/Y'),
                'registration_open' => $c->canAcceptNewRegistrations(),
                'available_slots' => $c->getAvailableSlots(), // chỉ số tổng
                'url' => url('/khoa-hoc/' . $c->slug),
            ]);

        $rooms = Room::query()
            ->select(['room_id', 'name', 'capacity', 'price', 'status'])
            ->with('equipment:equipment_id,name')
            ->where('status', 'available')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->map(fn($r) => [
                'name' => $r->name,
                'capacity' => (int) $r->capacity,
                'public_price' => (int) $r->price,
                'equipment' => $r->equipment->pluck('name')->values(),
                'url' => url('/phong-hoc/' . $r->room_id),
            ]);

        $news = News::query()
            ->select(['news_id', 'title', 'slug', 'published_at', 'is_published'])
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(5)
            ->get()
            ->map(fn($n) => [
                'title' => $n->title,
                'published_at' => optional($n->published_at)->format('d/m/Y'),
                'is_published' => (bool) $n->is_published,
                'url' => url('/tin-tuc/' . $n->slug),
            ]);
        // Lấy lịch bận theo từng ngày/khung giờ từ bảng chi tiết để chatbot tư vấn chính xác hơn.
        $upcomingBookings = RoomBookingDetail::query()
            ->select(['booking_detail_id', 'booking_id', 'booking_date', 'start_time', 'end_time'])
            ->with([
                'room_booking:booking_id,room_id',
                'room_booking.room:room_id,name',
            ])
            ->whereDate('booking_date', '>=', Carbon::today())
            ->whereHas('room_booking', fn($q) => $q->where('status', 'approved'))
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->limit(15)
            ->get();

        $categorySummary = collect($categories)
            ->map(fn($cat) => $cat->name . ' (' . $cat->open_courses_count . ')')
            ->implode(', ');

        $courseSummary = collect($courses)
            ->map(fn($c) => '- ' . $c['title']
                . ' (Mảng: ' . $c['category']
                . ', Giá: ' . ($c['public_price'] !== null ? $this->formatCurrency($c['public_price']) : 'Liên hệ')
                . ', Khai giảng: ' . ($c['start_date'] ?? 'Đang cập nhật')
                . ', Tình trạng: ' . ($c['registration_open'] ? 'Còn chỗ' : 'Hết chỗ')
                . ')')
            ->implode("\n");

        $roomSummary = collect($rooms)
            ->map(fn($r) => '- ' . $r['name']
                . ' (Sức chứa: ' . $r['capacity'] . ' người'
                . ', Giá: ' . $this->formatCurrency($r['public_price'])
                . ', Thiết bị: ' . ($r['equipment']->isNotEmpty() ? $r['equipment']->implode(', ') : 'Cơ bản')
                . ')')
            ->implode("\n");

        $newsSummary = collect($news)
            ->map(fn($n) => ' + ' . $n['title'])
            ->implode('; ');

        $bookingSummary = collect($upcomingBookings)
            ->map(fn($b) => (data_get($b, 'room_booking.room.name') ?? 'Phòng chưa xác định')
                . ' [' . optional($b->start_time)->format('H:i')
                . ' đến ' . optional($b->end_time)->format('H:i')
                . ', ngày ' . optional($b->booking_date)->format('d/m')
                . ']')
            ->implode(', ');

        return "Bạn là một trợ lý ảo chuyên nghiệp, tận tâm và vô cùng thân thiện của trung tâm đào tạo " . $this->centerInfo['name'] . ". " .
            "Nhiệm vụ của bạn là tư vấn cho khách hàng dựa trên dữ liệu thực tế dưới đây. " .
            "Hãy tuân thủ các nguyên tắc giao tiếp sau:\n" .
            "1. **Phong cách:** Trả lời tự nhiên như người thật. Sử dụng các từ ngữ lịch sự (Dạ, thưa, ạ, nhé, mình...). Tránh trả lời theo kiểu liệt kê robot trừ khi người dùng yêu cầu danh sách.\n" .
            "2. **Xử lý dữ liệu:** Sử dụng thông tin được cung cấp để tư vấn một cách thông minh. Ví dụ: Thay vì nói 'Giá: 500.000', hãy nói 'Khóa học này có mức phí rất ưu đãi, chỉ 500.000 VNĐ thôi ạ'.\n" .
            "3. **Định dạng giá:** Mọi giá tiền phải hiển thị theo chuẩn Việt Nam dạng 1.234.567 VNĐ, không để số trần khó đọc.\n" .
            "4. **Tính chủ động:** Sau khi trả lời xong câu hỏi chính, hãy gợi ý thêm các thông tin liên quan (ví dụ: tư vấn thêm về phòng học hoặc lịch khai giảng gần nhất).\n" .
            "5. **Giới hạn:** Nếu thông tin không có trong dữ liệu, hãy khéo léo xin lỗi và hướng dẫn khách hàng để lại thông tin hoặc liên hệ hotline " . $this->centerInfo['phone'] . " để được hỗ trợ chi tiết nhất.\n\n" .

            "--- THÔNG TIN TRUNG TÂM ---\n" .
            "- Hotline: " . $this->centerInfo['phone'] . "\n" .
            "- Email: " . $this->centerInfo['email'] . "\n" .
            "- Địa chỉ: " . $this->centerInfo['address'] . "\n" .
            "- Zalo: " . $this->centerInfo['zalo'] . "\n\n" .

            "--- DỮ LIỆU KHÓA HỌC & DỊCH VỤ ---\n" .
                "Danh mục hiện có: " . $categorySummary . ".\n" .
                "Chi tiết khóa học mới:\n" . $courseSummary . "\n\n" .

                "Thông tin phòng học:\n" . $roomSummary . "\n\n" .

                "Tin tức mới: " . $newsSummary . "\n\n" .

                "Lịch bận của phòng (không thể đặt): " . $bookingSummary . ".\n\n" .

            "Bây giờ, hãy bắt đầu hỗ trợ khách hàng với thái độ niềm nở nhất!, trả lời ngắn gọn, súc tích và dễ hiểu nhất có thể nhé!";
    }

    protected function handleRoomAvailabilityQuery(string $message): ?string
    {
        $normalizedMessage = Str::lower(trim($message));

        $isRoomQuery = Str::contains($normalizedMessage, 'phong') || Str::contains($normalizedMessage, 'phòng');
        $isAvailabilityQuery = Str::contains($normalizedMessage, 'trong')
            || Str::contains($normalizedMessage, 'trống')
            || Str::contains($normalizedMessage, 'con')
            || Str::contains($normalizedMessage, 'còn');

        if (!$isRoomQuery || !$isAvailabilityQuery) {
            return null;
        }

        $targetDateTime = $this->extractRequestedDateTime($message);
        if (!$targetDateTime) {
            return null;
        }

        $occupiedRoomIds = RoomBookingDetail::query()
            ->whereDate('booking_date', $targetDateTime->toDateString())
            ->whereTime('start_time', '<=', $targetDateTime->format('H:i:s'))
            ->whereTime('end_time', '>', $targetDateTime->format('H:i:s'))
            ->whereHas('room_booking', fn($q) => $q->where('status', 'approved'))
            ->with('room_booking:booking_id,room_id')
            ->get()
            ->pluck('room_booking.room_id')
            ->filter()
            ->unique()
            ->values();

        $availableRooms = Room::query()
            ->select(['room_id', 'name', 'capacity', 'price'])
            ->where('status', 'available')
            ->when($occupiedRoomIds->isNotEmpty(), fn($q) => $q->whereNotIn('room_id', $occupiedRoomIds->all()))
            ->orderBy('capacity')
            ->orderBy('name')
            ->limit(5)
            ->get();

        $timeLabel = $targetDateTime->format('H:i d/m/Y');

        if ($availableRooms->isEmpty()) {
            return "Dạ, tại thời điểm {$timeLabel} hiện chưa có phòng trống nào ạ. "
                . "Bạn có thể cho mình khung giờ khác gần đó để mình kiểm tra ngay giúp bạn nhé.";
        }

        $roomLines = $availableRooms
            ->map(fn($room) => "- {$room->name} (sức chứa {$room->capacity} người, giá {$this->formatCurrency($room->price)})")
            ->implode("\n");

        return "Dạ, lúc {$timeLabel} trung tâm còn " . $availableRooms->count() . " phòng đang trống ạ:\n"
            . $roomLines
            . "\nBạn cần mình gợi ý phòng theo số lượng người tham gia không ạ?";
    }

    protected function extractRequestedDateTime(string $message): ?Carbon
    {
        $raw = Str::lower($message);
        $targetDate = Carbon::today();

        if (Str::contains($raw, 'mai')) {
            $targetDate = Carbon::tomorrow();
        } elseif (preg_match('/ngay\s*(\d{1,2})\/(\d{1,2})(?:\/(\d{4}))?/u', $raw, $dateMatches)) {
            $day = (int) $dateMatches[1];
            $month = (int) $dateMatches[2];
            $year = isset($dateMatches[3]) ? (int) $dateMatches[3] : Carbon::now()->year;

            try {
                $targetDate = Carbon::create($year, $month, $day)->startOfDay();
            } catch (\Throwable $e) {
                return null;
            }
        }

        $hour = null;
        $minute = 0;

        if (preg_match('/(\d{1,2})\s*[:h\.](\d{1,2})/u', $raw, $timeMatches)) {
            $hour = (int) $timeMatches[1];
            $minute = (int) $timeMatches[2];
        } elseif (preg_match('/(\d{1,2})\s*gio(?:\s*(\d{1,2})\s*phut?)?/u', $raw, $timeMatches)) {
            $hour = (int) $timeMatches[1];
            $minute = isset($timeMatches[2]) ? (int) $timeMatches[2] : 0;
        } elseif (preg_match('/(\d{1,2})\s*giờ(?:\s*(\d{1,2})\s*phút?)?/u', $raw, $timeMatches)) {
            $hour = (int) $timeMatches[1];
            $minute = isset($timeMatches[2]) ? (int) $timeMatches[2] : 0;
        }

        if ($hour === null) {
            return null;
        }

        if ($hour >= 1 && $hour <= 11 && (Str::contains($raw, 'chieu') || Str::contains($raw, 'chiều') || Str::contains($raw, 'toi') || Str::contains($raw, 'tối'))) {
            $hour += 12;
        }

        if (($hour < 0 || $hour > 23) || ($minute < 0 || $minute > 59)) {
            return null;
        }

        return $targetDate->copy()->setTime($hour, $minute, 0);
    }

    protected function formatCurrency(int|float|string|null $amount): string
    {
        if ($amount === null || $amount === '') {
            return 'Liên hệ';
        }

        return number_format((float) $amount, 0, ',', '.') . ' VNĐ';
    }

    protected function callAI(string $message, array $history = []): string
    {
        $this->lastApiStatusCode = null;
        $this->lastApiErrorBody = null;

        $systemPrompt = $this->buildSystemPrompt();

        // Ưu tiên local model trước nếu được bật.
        if ($this->useLocalLLM) {
            $localResponse = $this->callApi(
                provider: 'openai',
                apiUrl: $this->localLLMUrl,
                model: $this->localLLMModel,
                apiKey: null,
                systemPrompt: $systemPrompt,
                message: $message,
                history: $history,
            );

            if ($localResponse) {
                return $localResponse;
            }
        }

        $provider = $this->isGeminiConfigured() ? 'gemini' : 'openai';
        $cloudResponse = $this->callApi(
            provider: $provider,
            apiUrl: $this->apiUrl,
            model: $this->model,
            apiKey: $this->apiKey,
            systemPrompt: $systemPrompt,
            message: $message,
            history: $history,
        );

        return $cloudResponse ?? $this->getAiUnavailableMessage();
    }

    protected function callApi(
        string $provider,
        string $apiUrl,
        string $model,
        ?string $apiKey,
        string $systemPrompt,
        string $message,
        array $history = []
    ): ?string {
        try {
            if ($provider === 'gemini') {
                $endpoint = $this->buildGeminiEndpoint($apiUrl, $model);
                $separator = Str::contains($endpoint, '?') ? '&' : '?';
                $endpointWithKey = $apiKey ? ($endpoint . $separator . 'key=' . $apiKey) : $endpoint;

                $contents = array_merge(
                    $this->mapHistoryToGeminiContents($history),
                    [[
                        'role' => 'user',
                        'parts' => [
                            ['text' => $message],
                        ],
                    ]]
                );

                $response = Http::timeout(45)->post($endpointWithKey, [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $systemPrompt],
                        ],
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 1000,
                    ],
                ]);

                if ($response->successful()) {
                    $parts = $response->json('candidates.0.content.parts', []);
                    $text = collect($parts)->pluck('text')->filter()->implode("\n");
                    return $text !== '' ? trim($text) : null;
                }

                $this->lastApiStatusCode = $response->status();
                $this->lastApiErrorBody = (string) $response->body();
                Log::error('Gemini API error: ' . $response->body());
                return null;
            }

            $request = Http::timeout(45);
            if (!empty($apiKey)) {
                $request = $request->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ]);
            }

            $response = $request->post(rtrim($apiUrl, '/') . '/chat/completions', [
                'model' => $model,
                'messages' => array_merge(
                    [['role' => 'system', 'content' => $systemPrompt]],
                    $history,
                    [['role' => 'user', 'content' => $message]]
                ),
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $content = trim((string) $response->json('choices.0.message.content', ''));
                return $content !== '' ? $content : null;
            }

            // Local Ollama cũ không hỗ trợ /v1/chat/completions, fallback sang /api/chat.
            if (empty($apiKey)
                && $response->status() === 404
                && Str::contains(rtrim($apiUrl, '/'), '11434')) {
                $ollamaResponse = Http::timeout(45)->post(rtrim($apiUrl, '/') . '/api/chat', [
                    'model' => $model,
                    'messages' => array_merge(
                        [['role' => 'system', 'content' => $systemPrompt]],
                        $history,
                        [['role' => 'user', 'content' => $message]]
                    ),
                    'stream' => false,
                ]);

                if ($ollamaResponse->successful()) {
                    $content = trim((string) $ollamaResponse->json('message.content', ''));
                    return $content !== '' ? $content : null;
                }

                $this->lastApiStatusCode = $ollamaResponse->status();
                $this->lastApiErrorBody = (string) $ollamaResponse->body();
                Log::error('Local LLM Ollama API error: ' . $ollamaResponse->body());
                return null;
            }

            $this->lastApiStatusCode = $response->status();
            $this->lastApiErrorBody = (string) $response->body();
            Log::error(($apiKey ? 'AI API' : 'Local LLM') . ' error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            $this->lastApiStatusCode = null;
            $this->lastApiErrorBody = $e->getMessage();
            Log::error(($provider === 'gemini' ? 'Gemini API' : (!empty($apiKey) ? 'AI API' : 'Local LLM')) . ' exception: ' . $e->getMessage());
            return null;
        }
    }

    protected function isGeminiConfigured(): bool
    {
        return Str::contains($this->apiUrl, 'generativelanguage.googleapis.com')
            || Str::startsWith($this->model, 'gemini');
    }

    protected function buildGeminiEndpoint(string $apiUrl, string $model): string
    {
        $baseUrl = rtrim($apiUrl, '/');

        if (Str::contains($baseUrl, ':generateContent')) {
            return $baseUrl;
        }

        if (Str::contains($baseUrl, '/v1beta/interactions')) {
            return str_replace('/v1beta/interactions', '/v1beta/models/' . $model . ':generateContent', $baseUrl);
        }

        if (Str::contains($baseUrl, '/v1beta/models/')) {
            return $baseUrl . ':generateContent';
        }

        if (Str::contains($baseUrl, 'generativelanguage.googleapis.com')) {
            return $baseUrl . '/models/' . $model . ':generateContent';
        }

        return $baseUrl;
    }

    protected function mapHistoryToGeminiContents(array $history): array
    {
        return collect($history)
            ->map(function ($msg) {
                $role = ($msg['role'] ?? 'user') === 'assistant' ? 'model' : 'user';
                $content = trim((string) ($msg['content'] ?? ''));

                if ($content === '') {
                    return null;
                }

                return [
                    'role' => $role,
                    'parts' => [
                        ['text' => $content],
                    ],
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }

    protected function getAiUnavailableMessage(): string
    {
        $errorBody = Str::lower((string) $this->lastApiErrorBody);

        if (Str::contains($errorBody, ['404 page not found', '/v1/chat/completions'])) {
            return 'Xin lỗi bạn, dịch vụ AI nội bộ chưa sẵn sàng (endpoint local chưa đúng hoặc model local chưa chạy). Vui lòng thử lại sau ít phút hoặc liên hệ hotline ' . $this->centerInfo['phone'] . ' để được hỗ trợ ngay.';
        }

        if ($this->lastApiStatusCode === 429 || Str::contains($errorBody, ['resource_exhausted', 'quota exceeded', 'rate limit'])) {
            return 'Xin lỗi bạn, hệ thống AI đang tạm hết lượt xử lý trong thời điểm này (quota/rate limit). Vui lòng thử lại sau ít phút hoặc liên hệ hotline ' . $this->centerInfo['phone'] . ' để được hỗ trợ ngay.';
        }

        return 'Xin lỗi, tôi đang gặp sự cố khi kết nối với dịch vụ AI. Vui lòng thử lại sau hoặc liên hệ hotline ' . $this->centerInfo['phone'] . ' để được hỗ trợ.';
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

    protected function getConversationContext(?int $userId, string $sessionId, int $limit = 10, array $sessionIds = []): array
    {
        $query = ChatMessage::query();

        if ($userId) {
            $query->where(function ($subQuery) use ($userId, $sessionIds) {
                $subQuery->where('user_id', $userId);

                if (!empty($sessionIds)) {
                    $subQuery->orWhereIn('session_id', $sessionIds);
                }
            });
        } else {
            $query->where('session_id', $sessionId);
        }

        return $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->reverse()
            ->map(fn($msg) => [
                'role' => $msg->role,
                'content' => $msg->message,
            ])
            ->toArray();
    }

    public function getHistory(Request $request, int $limit = 50): array
    {
        $userId = Auth::id();
        $sessionId = $request->session()->getId();
        $trackedSessionIds = $this->trackAndGetChatSessionIds($request, $userId, $sessionId);

        if ($userId) {
            $this->syncGuestSessionMessagesToUser($userId, $trackedSessionIds);
        }

        $query = ChatMessage::query();

        if ($userId) {
            $query->where(function ($subQuery) use ($userId, $trackedSessionIds) {
                $subQuery->where('user_id', $userId);

                if (!empty($trackedSessionIds)) {
                    $subQuery->orWhereIn('session_id', $trackedSessionIds);
                }
            });
        } else {
            $query->where('session_id', $sessionId);
        }

        // Với user đã đăng nhập, ưu tiên hiển thị đầy đủ lịch sử để không bị mất tin nhắn cũ.
        $historyLimit = $userId ? 5000 : $limit;

        $messages = $query->orderBy('created_at', 'asc')
            ->limit($historyLimit)
            ->get()
            ->map(fn($msg) => [
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
        $trackedSessionIds = $this->trackAndGetChatSessionIds($request, $userId, $sessionId);

        $query = ChatMessage::query();

        if ($userId) {
            $query->where(function ($subQuery) use ($userId, $trackedSessionIds) {
                $subQuery->where('user_id', $userId);

                if (!empty($trackedSessionIds)) {
                    $subQuery->orWhereIn('session_id', $trackedSessionIds);
                }
            });
        } else {
            $query->where('session_id', $sessionId);
        }

        $deleted = $query->delete();

        return [
            'success' => true,
            'deleted' => $deleted,
        ];
    }

    protected function syncGuestSessionMessagesToUser(int $userId, array $sessionIds): void
    {
        if (empty($sessionIds)) {
            return;
        }

        ChatMessage::query()
            ->whereNull('user_id')
            ->whereIn('session_id', $sessionIds)
            ->update([
                'user_id' => $userId,
                'session_id' => null,
            ]);
    }

    protected function trackAndGetChatSessionIds(Request $request, ?int $userId, string $sessionId): array
    {
        $key = 'chatbot_session_ids';
        $existing = $request->session()->get($key, []);

        if (!is_array($existing)) {
            $existing = [];
        }

        $ids = array_values(array_unique(array_filter(array_merge($existing, [$sessionId]))));
        $request->session()->put($key, $ids);

        // Sau khi đã đồng bộ vào tài khoản, chỉ cần giữ session hiện tại để tránh phình dữ liệu session.
        if ($userId) {
            $request->session()->put($key, [$sessionId]);
        }

        return $ids;
    }
}
