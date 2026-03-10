{{-- filepath: resources/views/search_results.blade.php --}}
@php
    $query = request('q', $query ?? '');
    $safeQuery = e($query);
    $sections = [
        'courses' => $courses ?? collect(),
        'news' => $news ?? collect(),
    ];
    $total = $sections['courses']->count() + $sections['news']->count();

    function highlight_fragment($text, $q) {
        if (!$q) return e($text);
        return preg_replace('/(' . preg_quote($q, '/') . ')/iu', '<mark>$1</mark>', e($text));
    }
@endphp

<x-layouts title="Kết quả tìm kiếm cho '{{ $safeQuery }}'">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active">Kết quả tìm kiếm</li>
                        </ol>
                    </nav>
                    <h1>Kết quả tìm kiếm</h1>
                    <p class="lead mb-4">
                        Từ khóa: <strong>"{{ $safeQuery }}"</strong>
                        @if($query)
                            <span class="badge bg-light text-dark ms-2">{{ $total }} kết quả</span>
                        @endif
                    </p>

                    <!-- Search Form -->
                    <form action="{{ route('search') }}" method="GET" role="search">
                        <div class="input-group input-group-lg">
                            <input type="text" name="q" value="{{ $query }}" class="form-control bg-white bg-opacity-25 border-0 text-white" 
                                   placeholder="Nhập từ khóa khác..." aria-label="Từ khóa">
                            <button class="btn btn-light fw-semibold" type="submit">
                                <i class="bi bi-search me-2"></i>Tìm
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="bi bi-search hero-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Bar -->
    <section class="filter-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="text-muted">
                    <i class="bi bi-funnel me-1"></i>
                    Lọc theo danh mục
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="filter-btn active" data-target="all">
                        Tất cả <span class="badge bg-primary ms-1">{{ $total }}</span>
                    </button>
                    <button class="filter-btn" data-target="courses">
                        <i class="bi bi-book me-1"></i>Khóa học <span class="badge bg-primary ms-1">{{ $sections['courses']->count() }}</span>
                    </button>
                    <button class="filter-btn" data-target="news">
                        <i class="bi bi-newspaper me-1"></i>Tin tức <span class="badge bg-primary ms-1">{{ $sections['news']->count() }}</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="section bg-light-gray">
        <div class="container">
            @if($total === 0)
                <div class="text-center py-5">
                    <i class="bi bi-search text-muted" style="font-size: 5rem;"></i>
                    <h4 class="text-muted mt-4 mb-3">Không có kết quả phù hợp</h4>
                    <p class="text-muted mb-4">Gợi ý: Thử rút ngắn hoặc thay đổi từ khóa, kiểm tra chính tả.</p>
                    <a href="/" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>Về trang chủ
                    </a>
                </div>
            @endif

            <!-- Courses Section -->
            @if($sections['courses']->count())
                <div class="result-group mb-5" data-group="courses">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-book text-primary fs-5"></i>
                        </div>
                        <div>
                            <h2 class="h4 fw-bold mb-0">Khóa học</h2>
                            <p class="text-muted mb-0 small">Tìm thấy {{ $sections['courses']->count() }} khóa học phù hợp</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach($sections['courses'] as $course)
                            <div class="col-md-6 col-lg-4">
                                <div class="card course-card h-100">
                                    <div class="card-img-wrapper">
                                        <img src="{{ Storage::url($course->featured_image) }}" alt="{{ $course->title }}">
                                        <span class="badge bg-primary position-absolute top-0 start-0 m-3">
                                            {{ $course->category->name }}
                                        </span>
                                        @if ($course->is_price_visible)
                                            <span class="price-badge">{{ number_format($course->price, 0, ',', '.') }}đ</span>
                                        @endif
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            <a href="{{ route('courses.show', $course->slug) }}">
                                                {!! highlight_fragment($course->title, $query) !!}
                                            </a>
                                        </h5>
                                        <p class="card-text small flex-grow-1">
                                            {{ Str::limit($course->short_description ?? $course->description, 80) }}
                                        </p>
                                        <div class="course-meta mt-auto mb-3">
                                            @if ($course->start_date)
                                                <span><i class="bi bi-calendar me-1"></i>{{ $course->start_date->format('d/m/Y') }}</span>
                                            @endif
                                            <span><i class="bi bi-people me-1"></i>{{ $course->max_students ?? 0 }}</span>
                                        </div>
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary w-100">
                                            Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- News Section -->
            @if($sections['news']->count())
                <div class="result-group" data-group="news">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-newspaper text-success fs-5"></i>
                        </div>
                        <div>
                            <h2 class="h4 fw-bold mb-0">Tin tức</h2>
                            <p class="text-muted mb-0 small">Tìm thấy {{ $sections['news']->count() }} bài viết phù hợp</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach($sections['news'] as $item)
                            <div class="col-md-6 col-lg-4">
                                <div class="card news-card h-100">
                                    <div class="card-img-wrapper">
                                        <img src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->title }}">
                                        <span class="badge bg-success position-absolute top-0 start-0 m-3">
                                            {{ $item->news_category->name }}
                                        </span>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="news-meta">
                                            <span><i class="bi bi-calendar me-1"></i>{{ $item->published_at?->format('d/m/Y') }}</span>
                                            <span><i class="bi bi-eye me-1"></i>{{ $item->view_count ?? 0 }}</span>
                                        </div>
                                        <h5 class="card-title">
                                            <a href="{{ route('news.show', $item->slug) }}">
                                                {!! highlight_fragment($item->title, $query) !!}
                                            </a>
                                        </h5>
                                        <p class="card-text small flex-grow-1">
                                            {{ Str::limit(strip_tags($item->summary ?? $item->content), 80) }}
                                        </p>
                                        <a href="{{ route('news.show', $item->slug) }}" class="btn btn-outline-primary mt-auto">
                                            Đọc tiếp <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h3>Không tìm thấy điều bạn cần?</h3>
            <p class="mb-4">Hãy liên hệ với chúng tôi để được tư vấn và hỗ trợ.</p>
            <a href="{{ route('contacts') }}" class="btn btn-light btn-lg">
                <i class="bi bi-envelope me-2"></i>Liên hệ ngay
            </a>
        </div>
    </section>

    <x-slot:scripts>
        <script>
            document.querySelectorAll(".filter-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    document.querySelectorAll(".filter-btn").forEach(b => b.classList.remove("active"));
                    this.classList.add("active");
                    
                    const target = this.dataset.target;
                    document.querySelectorAll(".result-group").forEach(group => {
                        group.style.display = (target === "all" || group.dataset.group === target) ? "block" : "none";
                    });
                });
            });
        </script>
    </x-slot:scripts>
</x-layouts>