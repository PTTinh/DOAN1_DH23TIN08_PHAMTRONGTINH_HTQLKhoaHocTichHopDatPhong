<x-layouts title="Tin Tức - {{ $news_item->title }}" ogTitle="{{ $news_item->seo_title }}"
    ogDescription="{{ $news_item->seo_description }}" ogImage="{{ $news_item->seo_image }}">

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Tin tức</a></li>
                            <li class="breadcrumb-item active">{{ Str::limit($news_item->title, 30) }}</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge bg-info">{{ $news_item->news_category->name ?? 'Tin tức' }}</span>
                    </div>
                    <h1>{{ $news_item->title }}</h1>
                    <div class="d-flex gap-4 flex-wrap mt-3">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-calendar-event"></i>
                            {{ $news_item->published_at->format('d/m/Y') }}
                        </span>
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-person"></i>
                            {{ $news_item->user->name }}
                        </span>
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-eye"></i>
                            {{ $news_item->view_count }} lượt xem
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="section bg-light-gray">
        <div class="container">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Featured Image -->
                    @if ($news_item->featured_image)
                        <div class="card overflow-hidden mb-4">
                            <img src="{{ Storage::url($news_item->featured_image) }}" 
                                class="card-img-top" alt="{{ $news_item->title }}"
                                style="height: 450px; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="card">
                        <div class="card-body p-4 p-lg-5">
                            <div class="content-body article-content">
                                {!! $news_item->content !!}
                            </div>
                            
                            <!-- Share buttons -->
                            <hr class="my-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div>
                                    <span class="text-muted me-2">Chia sẻ:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news_item->title) }}" 
                                       target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-twitter-x"></i>
                                    </a>
                                    <button onclick="navigator.clipboard.writeText('{{ request()->url() }}')" 
                                            class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-link-45deg"></i>
                                    </button>
                                </div>
                                <a href="{{ route('news.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left me-2"></i>Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Related News -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-link-45deg text-primary me-2"></i>Tin tức liên quan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                @forelse($relatedNews as $item)
                                    <a href="{{ route('news.show', $item->slug) }}" 
                                        class="text-decoration-none d-flex gap-3 p-2 rounded sidebar-item">
                                        <img src="{{ Storage::url($item->featured_image) }}" 
                                            alt="{{ $item->title }}"
                                            class="rounded" style="width: 80px; height: 80px; object-fit: cover; flex-shrink: 0;">
                                        <div class="flex-grow-1 min-w-0">
                                            <h6 class="mb-1 text-dark fw-semibold" style="line-height: 1.4;">
                                                {{ Str::limit($item->title, 50) }}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>{{ $item->published_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-muted small mb-0">Không có tin tức liên quan</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent News -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-clock-history text-primary me-2"></i>Tin tức mới nhất
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                @forelse($recentNews as $item)
                                    <a href="{{ route('news.show', $item->slug) }}" 
                                        class="text-decoration-none d-flex gap-3 p-2 rounded sidebar-item">
                                        <img src="{{ Storage::url($item->featured_image) }}" 
                                            alt="{{ $item->title }}"
                                            class="rounded" style="width: 80px; height: 80px; object-fit: cover; flex-shrink: 0;">
                                        <div class="flex-grow-1 min-w-0">
                                            <h6 class="mb-1 text-dark fw-semibold" style="line-height: 1.4;">
                                                {{ Str::limit($item->title, 50) }}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>{{ $item->published_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-muted small mb-0">Không có tin tức mới</p>
                                @endforelse
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
            <h3>Khám phá thêm tin tức</h3>
            <p class="mb-4">Cập nhật những thông tin mới nhất về khóa học và sự kiện.</p>
            <a href="{{ route('news.index') }}" class="btn btn-light btn-lg">
                <i class="bi bi-newspaper me-2"></i>Xem tất cả tin tức
            </a>
        </div>
    </section>
</x-layouts>
