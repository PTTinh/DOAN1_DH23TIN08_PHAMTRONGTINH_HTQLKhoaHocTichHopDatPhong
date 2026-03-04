<x-layouts title="Tin Tức">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active">Tin tức</li>
                        </ol>
                    </nav>
                    <h1>
                        @if (isset($newsCategory))
                            {{ $newsCategory->name }}
                        @else
                            Tin tức & Sự kiện
                        @endif
                    </h1>
                    <p class="lead">
                        @if (isset($newsCategory))
                            {{ $newsCategory->description }}
                        @else
                            Cập nhật những tin tức mới nhất, sự kiện nổi bật và các hoạt động từ trung tâm đào tạo.
                        @endif
                    </p>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="bi bi-newspaper hero-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Bar -->
    <section class="filter-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="text-muted">
                    <i class="bi bi-newspaper me-1"></i>
                    Hiển thị <strong class="text-dark">{{ $news->count() }}</strong> bài viết
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    @php $newsCategories = App\Models\NewsCategory::all(); @endphp
                    <a href="{{ route('news.index') }}" class="filter-btn {{ !isset($newsCategory) ? 'active' : '' }}">
                        Tất cả
                    </a>
                    @foreach($newsCategories as $cat)
                        <a href="{{ route('news.category', $cat->slug) }}" 
                           class="filter-btn {{ isset($newsCategory) && $newsCategory->id === $cat->id ? 'active' : '' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- News Grid -->
    <section class="section bg-light-gray">
        <div class="container">
            @if($news->count() > 0)
                <div class="row g-4">
                    @foreach ($news as $index => $item)
                        @if($index === 0)
                            <!-- Featured Article -->
                            <div class="col-12">
                                <div class="card overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="position-relative h-100" style="min-height: 350px;">
                                                <img src="{{ Storage::url($item->featured_image) }}" 
                                                    alt="{{ $item->title }}" 
                                                    class="w-100 h-100" style="object-fit: cover;">
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2">
                                                    <i class="bi bi-star-fill me-1"></i>Nổi bật
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card-body d-flex flex-column h-100 p-4 p-lg-5">
                                                <div class="d-flex align-items-center gap-3 mb-3">
                                                    <span class="badge bg-info">{{ $item->news_category->name }}</span>
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar-event me-1"></i>
                                                        {{ $item->published_at?->format('d/m/Y') ?? $item->created_at->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                                <h3 class="card-title fw-bold mb-3">
                                                    <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                                </h3>
                                                <p class="card-text text-muted flex-grow-1">
                                                    {{ Str::limit(strip_tags($item->summary ?? $item->content), 200) }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3">
                                                    <div class="d-flex align-items-center gap-3 text-muted small">
                                                        <span><i class="bi bi-eye me-1"></i>{{ $item->view_count ?? 0 }} lượt xem</span>
                                                        <span><i class="bi bi-person me-1"></i>{{ $item->user->name ?? 'Admin' }}</span>
                                                    </div>
                                                    <a href="{{ route('news.show', $item->slug) }}" class="btn btn-primary">
                                                        Đọc tiếp <i class="bi bi-arrow-right ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Regular Card -->
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
                                            <span><i class="bi bi-calendar me-1"></i>{{ $item->published_at?->format('d/m/Y') ?? $item->created_at->format('d/m/Y') }}</span>
                                            <span><i class="bi bi-eye me-1"></i>{{ $item->view_count ?? 0 }}</span>
                                        </div>
                                        <h5 class="card-title">
                                            <a href="{{ route('news.show', $item->slug) }}">
                                                {{ Str::limit($item->title, 70) }}
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
                        @endif
                    @endforeach
                </div>

                @if (method_exists($news, 'hasPages') && $news->hasPages())
                    <nav class="mt-5 d-flex justify-content-center">
                        {{ $news->links('pagination::bootstrap-5') }}
                    </nav>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-newspaper text-muted" style="font-size: 5rem;"></i>
                    <h4 class="text-muted mt-4 mb-3">Chưa có tin tức nào</h4>
                    <p class="text-muted mb-4">Vui lòng quay lại sau để cập nhật những tin tức mới nhất.</p>
                    <a href="/" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>Về trang chủ
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h3>Đăng ký nhận tin tức mới nhất</h3>
            <p class="mb-4">Cập nhật thông tin về khóa học, sự kiện và ưu đãi đặc biệt.</p>
            <a href="{{ route('contacts') }}" class="btn btn-light btn-lg">
                <i class="bi bi-envelope me-2"></i>Liên hệ với chúng tôi
            </a>
        </div>
    </section>
</x-layouts>
