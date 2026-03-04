<x-layouts title="Khóa Học - {{ $course->title }}" ogTitle="{{ $course->seo_title }}"
    ogDescription="{{ $course->seo_description }}" ogImage="{{ $course->seo_image }}">

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Khóa học</a></li>
                            <li class="breadcrumb-item active">{{ Str::limit($course->title, 30) }}</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge bg-info">{{ $course->category->name }}</span>
                        @php
                            $statusText = match ($course->status) {
                                'published' => 'Đang mở',
                                'draft' => 'Sắp mở',
                                default => 'Đã đóng',
                            };
                            $statusColor = match ($course->status) {
                                'published' => 'success',
                                'draft' => 'warning',
                                default => 'danger',
                            };
                        @endphp
                        <span class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                    </div>
                    <h1>{{ $course->title }}</h1>
                    <p class="lead mb-0">{{ $course->description ?? 'Khám phá khóa học chất lượng cao tại ' . App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="bi bi-mortarboard hero-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Detail Content -->
    <section class="section bg-light-gray">
        <div class="container">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Course Image -->
                    <div class="card overflow-hidden mb-4">
                        <img src="{{ Storage::url($course->featured_image) }}" class="card-img-top" alt="{{ $course->title }}"
                            style="height: 400px; object-fit: cover;">
                    </div>

                    <!-- Course Info Cards -->
                    <div class="row g-3 mb-4">
                        @if ($course->start_date)
                            <div class="col-sm-6 col-lg-3">
                                <div class="card h-100 text-center">
                                    <div class="card-body py-3">
                                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                            <i class="bi bi-calendar-check text-primary fs-5"></i>
                                        </div>
                                        <p class="small text-muted mb-1">Khai giảng</p>
                                        <p class="fw-bold mb-0">{{ $course->start_date->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($course->registration_deadline)
                            <div class="col-sm-6 col-lg-3">
                                <div class="card h-100 text-center">
                                    <div class="card-body py-3">
                                        <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                            <i class="bi bi-hourglass-split text-warning fs-5"></i>
                                        </div>
                                        <p class="small text-muted mb-1">Hạn đăng ký</p>
                                        <p class="fw-bold mb-0">{{ $course->registration_deadline->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-6 col-lg-3">
                            <div class="card h-100 text-center">
                                <div class="card-body py-3">
                                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                        <i class="bi bi-people text-success fs-5"></i>
                                    </div>
                                    <p class="small text-muted mb-1">Sức chứa</p>
                                    <p class="fw-bold mb-0">{{ $course->max_students }} người</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card h-100 text-center">
                                <div class="card-body py-3">
                                    <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                        <i class="bi bi-cash-coin text-info fs-5"></i>
                                    </div>
                                    <p class="small text-muted mb-1">Học phí</p>
                                    @if ($course->is_price_visible)
                                        <p class="fw-bold text-primary mb-0">{{ number_format($course->price, 0, ',', '.') }}đ</p>
                                    @else
                                        <p class="fw-bold mb-0">Liên hệ</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Content -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-journal-text text-primary me-2"></i>Nội dung khóa học
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="content-body article-content">
                                {!! $course->content !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Registration Form -->
                <div class="col-lg-4">
                    <div class="card position-sticky" style="top: 100px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-pencil-square me-2"></i>Đăng ký tư vấn
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <!-- Price Display -->
                            <div class="text-center mb-4 pb-4 border-bottom">
                                @if ($course->is_price_visible)
                                    <p class="small text-muted mb-1">Học phí</p>
                                    <p class="h3 text-primary fw-bold mb-0">{{ number_format($course->price, 0, ',', '.') }} VNĐ</p>
                                    <small class="text-muted">/{{ App\Helpers\SettingHelper::get('course_rental_unit', 'khóa') }}</small>
                                @else
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-telephone me-2"></i>Liên hệ để biết thêm chi tiết giá
                                    </p>
                                @endif
                            </div>

                            <form action="{{ route('courses.registration') }}" method="POST" class="needs-validation">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <x-app-input 
                                    name="name" 
                                    label="Họ và tên" 
                                    placeholder="Nhập họ và tên" 
                                    required 
                                />
                                <x-app-input 
                                    type="email"
                                    name="email" 
                                    label="Email" 
                                    placeholder="Nhập email" 
                                    required 
                                />
                                <x-app-input 
                                    type="tel"
                                    name="phone" 
                                    label="Số điện thoại" 
                                    placeholder="Nhập số điện thoại" 
                                    required 
                                />
                                <!-- reCAPTCHA -->
                                @if (config('services.recaptcha.enabled', false))
                                    <x-recaptcha form-type="course-registration" />
                                @endif

                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                                    <i class="bi bi-check-circle me-2"></i>Đăng ký tư vấn
                                </button>
                            </form>

                            <hr class="my-4">
                            <div class="text-center">
                                <p class="small text-muted mb-2">Hoặc liên hệ trực tiếp</p>
                                <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}" class="btn btn-outline-success w-100">
                                    <i class="bi bi-telephone me-2"></i>{{ App\Helpers\SettingHelper::get('phone', 'Hotline') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h3>Khám phá thêm khóa học</h3>
            <p class="mb-4">Xem tất cả các khóa học chất lượng tại trung tâm.</p>
            <a href="{{ route('courses.index') }}" class="btn btn-light btn-lg">
                <i class="bi bi-mortarboard me-2"></i>Xem tất cả khóa học
            </a>
        </div>
    </section>

    <x-slot:scripts>
        @if (config('services.recaptcha.enabled', false))
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endif
    </x-slot:scripts>
</x-layouts>
