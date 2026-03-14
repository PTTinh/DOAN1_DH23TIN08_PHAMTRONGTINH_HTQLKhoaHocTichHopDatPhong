<x-layouts title="Khóa học">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active">Khóa học</li>
                        </ol>
                    </nav>
                    @if (isset($category))
                        <h1>{{ $category->name }}</h1>
                        <p class="lead">{{ $category->description }}</p>
                    @else
                        <h1>Tất cả khóa học</h1>
                        <p class="lead">Khám phá các khóa học chất lượng cao, được thiết kế bởi đội ngũ giảng viên giàu kinh nghiệm.</p>
                    @endif
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="bi bi-mortarboard-fill hero-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Bar -->
    <section class="filter-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="text-muted">
                    <i class="bi bi-grid me-1"></i>
                    Hiển thị <strong class="text-dark">{{ $courses->count() }}</strong> khóa học
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    @php $categories = App\Models\Category::all(); @endphp
                    <a href="{{ route('courses.index') }}" class="filter-btn {{ !isset($category) ? 'active' : '' }}">
                        Tất cả
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('courses.category', $cat->slug) }}" 
                           class="filter-btn {{ isset($category) && $category->category_id === $cat->category_id ? 'active' : '' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="section bg-light-gray">
        <div class="container">
            @if ($courses->count() > 0)
                <div class="row g-4">
                    @foreach ($courses as $course)
                        <div class="col-md-6 col-lg-4">
                            <div class="card course-card h-100">
                                <div class="card-img-wrapper">
                                    <img src="{{ Storage::url($course->featured_image) }}" alt="{{ $course->title }}">
                                    <span class="badge bg-primary badge-category">{{ $course->category->name }}</span>
                                    @if($course->price)
                                        <span class="badge-price">{{ number_format($course->price, 0, ',', '.') }}đ</span>
                                    @else
                                        <span class="badge-price" style="background: #10b981;">Miễn phí</span>
                                    @endif
                                    @if ($course->start_date)
                                        <span class="badge bg-success badge-date">
                                            <i class="bi bi-calendar-event me-1"></i>{{ $course->start_date->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <a href="{{ route('courses.show', $course->slug) }}">
                                            {{ Str::limit($course->title, 55) }}
                                        </a>
                                    </h5>
                                    <p class="card-text small flex-grow-1">
                                        {{ Str::limit($course->short_description ?? $course->description, 90) }}
                                    </p>
                                    @if ($course->end_registration_date)
                                        <div class="alert alert-warning py-2 px-3 small mb-3">
                                            <i class="bi bi-hourglass-split me-1"></i>
                                            <strong>Hạn ĐK:</strong> {{ $course->end_registration_date->format('d/m/Y') }}
                                        </div>
                                    @endif
                                    <div class="course-footer">
                                        
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-sm btn-primary">
                                            Chi tiết <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (method_exists($courses, 'hasPages') && $courses->hasPages())
                    <nav class="mt-5 d-flex justify-content-center">
                        {{ $courses->links('pagination::bootstrap-5') }}
                    </nav>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 5rem;"></i>
                    <h4 class="text-muted mt-4 mb-3">Không có khóa học nào</h4>
                    <p class="text-muted mb-4">Vui lòng quay lại sau hoặc liên hệ với chúng tôi để biết thêm thông tin.</p>
                    <a href="{{ route('contacts') }}" class="btn btn-primary">
                        <i class="bi bi-telephone me-2"></i>Liên hệ tư vấn
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h3>Bạn cần tư vấn thêm về khóa học?</h3>
            <p class="mb-4">Đội ngũ tư vấn viên của chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-telephone me-2"></i>{{ App\Helpers\SettingHelper::get('phone', 'Liên hệ') }}
                </a>
                <a href="{{ route('contacts') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-envelope me-2"></i>Gửi yêu cầu tư vấn
                </a>
            </div>
        </div>
    </section>
</x-layouts>
