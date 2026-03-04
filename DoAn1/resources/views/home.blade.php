<x-layouts>
    <!-- Welcome Banner -->
    <div class="top-bar text-center py-2" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
        <div class="container">
            <div class="text-nowrap overflow-hidden">
                <span class="d-inline-block animation-scroll text-white">
                    <i class="bi bi-megaphone-fill me-2"></i>
                    {!! App\Helpers\SettingHelper::get(
                        'welcome_message',
                        'Chào mừng bạn đến với ' .
                            App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') .
                            ' - Nơi học tập và phát triển bản thân!',
                    ) !!}
                </span>
            </div>
        </div>
    </div>

    <!-- Hero Carousel -->
    <section id="heroCarousel" class="carousel slide carousel-hero" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach ($slides as $index => $slide)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
                    class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach ($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-url="{{ $slide->link_url }}" style="cursor: pointer;">
                    <img src="{{ Storage::url($slide->image_url) }}" class="d-block w-100" alt="{{ $slide->title }}">
                    <div class="carousel-caption">
                        <div class="container">
                            <h2 class="animate-fade-in-up">{{ $slide->title }}</h2>
                            <p class="animate-fade-in-up" style="animation-delay: 0.1s;">{{ $slide->description }}</p>
                            @if($slide->link_url)
                                <a href="{{ $slide->link_url }}" class="btn btn-accent btn-lg mt-3 animate-fade-in-up" style="animation-delay: 0.2s;">
                                    <i class="bi bi-arrow-right-circle me-2"></i>Khám phá ngay
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </section>

    <!-- Stats Section -->
    <section class="section bg-light-gray">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-lg-3">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="stats-number text-primary">8+</div>
                        <div class="stats-label">Năm kinh nghiệm</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="bi bi-patch-check"></i>
                        </div>
                        <div class="stats-number text-success">100%</div>
                        <div class="stats-label">Giảng viên chứng chỉ quốc tế</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stats-number" style="color: #f59e0b;">1000+</div>
                        <div class="stats-label">Học viên tin tưởng</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div class="stats-number text-danger">100%</div>
                        <div class="stats-label">Đạt mục tiêu đề ra</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section" id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2">
                        <i class="bi bi-info-circle me-1"></i> Về chúng tôi
                    </span>
                    <h2 class="section-title text-primary">
                        {{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}
                    </h2>
                    <div class="section-divider"></div>
                    <div class="text-muted lh-lg mt-4 mb-4">
                        {!! App\Helpers\SettingHelper::get('description', 'Chưa cập nhật') !!}
                    </div>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-book me-2"></i>Xem khóa học
                        </a>
                        <a href="{{ route('contacts') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-telephone me-2"></i>Liên hệ tư vấn
                        </a>
                    </div>
                </div>
                @if (App\Helpers\SettingHelper::get('youtube_embed'))
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <div class="ratio ratio-16x9 rounded-2xl overflow-hidden shadow-lg">
                                <iframe src="{{ App\Helpers\SettingHelper::get('youtube_embed') }}" 
                                    title="YouTube video" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Latest Courses Section -->
    @if ($courses->count() > 0)
        <section class="section bg-light-gray">
            <div class="container">
                <div class="section-header text-center">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2">
                        <i class="bi bi-mortarboard me-1"></i> Học tập
                    </span>
                    <h2 class="section-title">Khóa học nổi bật</h2>
                    <p class="section-subtitle">Khám phá các khóa học chất lượng cao, được thiết kế bởi đội ngũ giảng viên giàu kinh nghiệm</p>
                    <div class="section-divider"></div>
                </div>
                
                <div class="row g-4">
                    @foreach ($courses->take(6) as $course)
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
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <a href="{{ route('courses.show', $course->slug) }}">
                                            {{ Str::limit($course->title, 50) }}
                                        </a>
                                    </h5>
                                    <p class="card-text small flex-grow-1">
                                        {{ Str::limit($course->short_description ?? $course->description, 80) }}
                                    </p>
                                    <div class="course-footer">
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-sm btn-primary">
                                            Chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($courses->count() > 6)
                    <div class="text-center mt-5">
                        <a href="{{ route('courses.index') }}" class="btn btn-accent btn-lg">
                            <i class="bi bi-grid me-2"></i>Xem tất cả khóa học
                        </a>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Latest News Section -->
    @if ($news->count() > 0)
        <section class="section">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5">
                    <div>
                        <span class="badge bg-info bg-opacity-10 text-info mb-2 px-3 py-2">
                            <i class="bi bi-newspaper me-1"></i> Tin tức
                        </span>
                        <h2 class="section-title mb-0">Tin tức mới nhất</h2>
                        <div class="section-divider"></div>
                    </div>
                    <a href="{{ route('news.index') }}" class="btn btn-outline-primary">
                        Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-4">
                    @foreach ($news as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="card news-card h-100">
                                <div class="card-img-wrapper">
                                    <img src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->title }}">
                                    <span class="badge bg-info position-absolute top-0 start-0 m-3">
                                        {{ $item->news_category->name }}
                                    </span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="news-meta">
                                        <span><i class="bi bi-calendar me-1"></i>{{ $item->published_at?->format('d/m/Y') }}</span>
                                        <span><i class="bi bi-eye me-1"></i>{{ $item->view_count }}</span>
                                    </div>
                                    <h5 class="card-title">
                                        <a href="{{ route('news.show', $item->slug) }}">
                                            {{ Str::limit($item->title, 60) }}
                                        </a>
                                    </h5>
                                    <p class="card-text small flex-grow-1">
                                        {{ Str::limit(strip_tags($item->summary ?? $item->content), 100) }}
                                    </p>
                                    <a href="{{ route('news.show', $item->slug) }}" class="btn btn-sm btn-outline-primary mt-auto">
                                        Đọc tiếp <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h3>Bạn cần tư vấn thêm về khóa học?</h3>
            <p class="mb-4">Đội ngũ tư vấn viên của chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-telephone me-2"></i>{{ App\Helpers\SettingHelper::get('phone', 'Liên hệ') }}
                </a>
                <a href="{{ route('contacts') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-envelope me-2"></i>Gửi yêu cầu
                </a>
            </div>
        </div>
    </section>

    <x-slot:scripts>
        <script>
            document.querySelectorAll('.carousel-item').forEach(item => {
                item.addEventListener('click', function() {
                    const url = this.dataset.url;
                    if (url) window.open(url, '_blank');
                });
            });
        </script>
    </x-slot:scripts>
</x-layouts>
