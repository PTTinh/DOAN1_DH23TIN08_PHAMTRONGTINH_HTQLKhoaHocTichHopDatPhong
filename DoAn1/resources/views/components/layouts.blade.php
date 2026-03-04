<!DOCTYPE html>
<html lang="vi">

@php
    // Batch-load tất cả settings 1 lần duy nhất thay vì 30+ queries riêng lẻ
    $settings = App\Helpers\SettingHelper::all();
    $s = fn(string $key, mixed $default = '') => $settings[$key] ?? $default;

    // Cache categories & news categories - chỉ query 1 lần
    $navCategories = App\Models\Category::select('id', 'name', 'slug')->get();
    $navNewsCategories = App\Models\NewsCategory::select('id', 'name', 'slug')->get();
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ $attributes['title'] ? $attributes['title'] . ' - ' : '' }}{{ $s('center_name', 'Trung tâm đào tạo') }}
    </title>

    <x-seo ogTitle="{{ $attributes['ogTitle'] ?? $s('seo_title', 'Chưa cập nhật') }}"
        ogDescription="{{ $attributes['ogDescription'] ?? $s('seo_description', 'Chưa cập nhật') }}"
        ogImage="{{ $attributes['ogImage'] ?? asset('storage/' . $s('seo_image')) }}" />
    <link rel="icon" href="{{ asset('storage/' . $s('logo')) }}" type="image/png">

    {{-- Preconnect sớm cho fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Critical CSS: Bootstrap --}}
    <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">

    {{-- Non-blocking: Bootstrap Icons (tải async vì nặng ~200KB) --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}"></noscript>

    {{-- Google Fonts với font-display=swap để tránh FOIT --}}
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-custom.css') }}">
    @if ($s('custom_css'))
        <style>
            {!! $s('custom_css') !!}
        </style>
    @endif
    @if ($s('ga_head'))
        {!! $s('ga_head') !!}
    @endif
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 d-none d-md-block">
                    <div class="d-flex gap-4">
                        <a href="mailto:{{ $s('email') }}" class="top-bar-link">
                            <i class="bi bi-envelope-fill me-2"></i>{{ $s('email', 'Chưa cập nhật') }}
                        </a>
                        <a href="tel:{{ $s('phone') }}" class="top-bar-link">
                            <i class="bi bi-telephone-fill me-2"></i>{{ $s('phone', 'Chưa cập nhật') }}
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-center justify-content-md-end align-items-center gap-3">
                        <span class="d-none d-sm-inline text-white-50 small">Theo dõi chúng tôi:</span>
                        <div class="social-links">
                            <a href="{{ $s('facebook_fanpage', '#') }}" class="social-link" title="Facebook" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://youtube.com" class="social-link" title="YouTube" target="_blank">
                                <i class="bi bi-youtube"></i>
                            </a>
                            <a href="https://zalo.me/{{ $s('zalo') }}" class="social-link" title="Zalo" target="_blank">
                                <i class="bi bi-chat-dots-fill"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="main-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('storage/' . $s('logo')) }}"
                        alt="{{ $s('center_name', 'Trung tâm đào tạo') }}"
                        class="header-logo" width="auto" height="50">
                </a>

                <!-- Mobile Actions -->
                <div class="d-lg-none d-flex align-items-center gap-2">
                    <button class="btn btn-link p-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="bi bi-search text-dark fs-5"></i>
                    </button>
                    <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                </div>

                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                                <i class="bi bi-house-door me-1"></i>Trang chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#about">
                                <i class="bi bi-info-circle me-1"></i>Giới thiệu
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('courses.index') || request()->routeIs('courses.category') || request()->routeIs('courses.show') ? 'active' : '' }}"
                                href="{{ route('courses.index') }}" id="coursesDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-mortarboard me-1"></i>Khóa học
                            </a>
                            <ul class="dropdown-menu dropdown-menu-animated" aria-labelledby="coursesDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('courses.index') ? 'active' : '' }}"
                                        href="{{ route('courses.index') }}">
                                        <i class="bi bi-grid me-2"></i>Tất cả khóa học
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @foreach ($navCategories as $Category)
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('courses.category') && request()->route('slug') == $Category->slug ? 'active' : '' }}"
                                            href="{{ route('courses.category', $Category->slug) }}">
                                            <i class="bi bi-bookmark me-2"></i>{{ $Category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('rooms.index') || request()->routeIs('rooms.show') ? 'active' : '' }}"
                                href="{{ route('rooms.index') }}">
                                <i class="bi bi-door-open me-1"></i>Phòng học
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('news.index') || request()->routeIs('news.category') || request()->routeIs('news.show') ? 'active' : '' }}"
                                href="{{ route('news.index') }}" id="newsDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-newspaper me-1"></i>Tin tức
                            </a>
                            <ul class="dropdown-menu dropdown-menu-animated" aria-labelledby="newsDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('news.index') ? 'active' : '' }}"
                                        href="{{ route('news.index') }}">
                                        <i class="bi bi-grid me-2"></i>Tất cả tin tức
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @foreach ($navNewsCategories as $newsCategory)
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('news.category') && request()->route('slug') == $newsCategory->slug ? 'active' : '' }}"
                                            href="{{ route('news.category', $newsCategory->slug) }}">
                                            <i class="bi bi-tag me-2"></i>{{ $newsCategory->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}"
                                href="{{ route('contacts') }}">
                                <i class="bi bi-envelope me-1"></i>Liên hệ
                            </a>
                        </li>
                         <form action="{{ route('search') }}" method="GET" class="header-search" role="search">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control"
                                    placeholder="Tìm kiếm..." aria-label="Tìm kiếm">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </ul>

                    <!-- Search & CTA (Desktop) -->
                    <div class="d-none d-lg-flex align-items-center gap-3">
                        @auth
                            {{-- User Dropdown (Logged in) --}}
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i>
                                    <span class="d-none d-xl-inline">{{ Str::limit(Auth::user()->name, 15) }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animated">
                                    <li class="dropdown-header">
                                        <strong>{{ Auth::user()->name }}</strong><br>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Tổng quan</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="bi bi-person me-2"></i>Thông tin cá nhân</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.course-history') }}"><i class="bi bi-person-lines-fill me-2"></i>Đăng ký tư vấn</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.booking-history') }}"><i class="bi bi-calendar-check me-2"></i>Lịch sử đặt phòng</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            {{-- Login/Register Buttons (Guest) --}}
                            <a href="{{ route('login') }}" class="btn btn-outline-primary text-nowrap">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary text-nowrap">
                                <i class="bi bi-person-plus me-1"></i>Đăng ký
                            </a>
                        @endauth
                    </div>

                    {{-- Mobile Auth Links --}}
                    <div class="d-lg-none border-top mt-3 pt-3">
                        @auth
                            <div class="d-flex flex-column gap-2 mb-2">
                                <a href="{{ route('user.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Tài khoản của tôi</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link text-danger border-0 bg-transparent p-0"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                                </form>
                            </div>
                        @else
                            <div class="d-flex gap-2">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm flex-fill">
                                    <i class="bi bi-person-plus me-1"></i>Đăng ký
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @include('includes._notify')
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-top">
            <div class="container">
                <div class="row g-4 g-lg-5">
                    <!-- About -->
                    <div class="col-lg-4">
                        <div class="footer-brand mb-4">
                            <img src="{{ asset('storage/' . $s('logo')) }}" 
                                 alt="{{ $s('center_name') }}"
                                 class="footer-logo mb-3" width="auto" height="50" loading="lazy">
                            <h5 class="text-white fw-bold">{{ $s('center_name', 'Trung tâm đào tạo') }}</h5>
                        </div>
                        <p class="text-white-50 mb-4">
                            Trung tâm đào tạo chất lượng cao với đội ngũ giảng viên giàu kinh nghiệm và cơ sở vật chất hiện đại.
                        </p>
                        <div class="footer-social">
                            <a href="{{ $s('facebook_fanpage', '#') }}" class="footer-social-link" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://youtube.com" class="footer-social-link" target="_blank">
                                <i class="bi bi-youtube"></i>
                            </a>
                            <a href="https://zalo.me/{{ $s('zalo') }}" class="footer-social-link" target="_blank">
                                <i class="bi bi-chat-dots-fill"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-6 col-lg-2">
                        <h6 class="footer-title">Khóa học</h6>
                        <ul class="footer-links">
                            <li><a href="{{ route('courses.index') }}">Tất cả khóa học</a></li>
                            @foreach ($navCategories->take(4) as $Category)
                                <li><a href="{{ route('courses.category', $Category->slug) }}">{{ $Category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Quick Links 2 -->
                    <div class="col-6 col-lg-2">
                        <h6 class="footer-title">Liên kết</h6>
                        <ul class="footer-links">
                            <li><a href="/">Trang chủ</a></li>
                            <li><a href="/#about">Giới thiệu</a></li>
                            <li><a href="{{ route('rooms.index') }}">Phòng học</a></li>
                            <li><a href="{{ route('news.index') }}">Tin tức</a></li>
                            <li><a href="{{ route('contacts') }}">Liên hệ</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-4">
                        <h6 class="footer-title">Thông tin liên hệ</h6>
                        <ul class="footer-contact">
                            <li>
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>{{ $s('address', 'Chưa cập nhật') }}</span>
                            </li>
                            <li>
                                <i class="bi bi-telephone-fill"></i>
                                <a href="tel:{{ $s('phone') }}">
                                    {{ $s('phone', 'Chưa cập nhật') }}
                                </a>
                            </li>
                            <li>
                                <i class="bi bi-envelope-fill"></i>
                                <a href="mailto:{{ $s('email') }}">
                                    {{ $s('email', 'Chưa cập nhật') }}
                                </a>
                            </li>
                            <li>
                                <i class="bi bi-clock-fill"></i>
                                <span>T2 - T7: 8:00 - 21:00</span>
                            </li>
                        </ul>
                        
                        <!-- Mini Map (lazy-loaded với IntersectionObserver) -->
                        <div class="footer-map mt-3">
                            <iframe data-src="{{ $s('google_map') }}"
                                style="border:0; border-radius: 8px;" allowfullscreen=""
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="mb-0">
                            &copy; {{ date('Y') }} <strong>{{ $s('center_name', 'Trung tâm đào tạo') }}</strong>. 
                            All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-bottom-links">
                            <a href="#">Chính sách bảo mật</a>
                            <span class="mx-2">|</span>
                            <a href="#">Điều khoản sử dụng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Contact Buttons -->
    <div class="floating-contact">
        <a href="tel:{{ $s('phone') }}" class="floating-btn phone-btn" title="Gọi điện">
            <i class="bi bi-telephone-fill"></i>
        </a>
        <a href="https://zalo.me/{{ $s('zalo') }}" target="_blank" class="floating-btn zalo-btn" title="Chat Zalo">
            <i class="bi bi-chat-dots-fill"></i>
        </a>
        <a href="{{ $s('facebook_fanpage', '#') }}" target="_blank" class="floating-btn fb-btn" title="Facebook">
            <i class="bi bi-messenger"></i>
        </a>
    </div>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" title="Lên đầu trang">
        <i class="bi bi-chevron-up"></i>
    </button>

    <!-- Mobile Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="searchModalLabel">
                        <i class="bi bi-search me-2"></i>Tìm kiếm
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="input-group input-group-lg">
                            <input type="text" name="q" class="form-control"
                                placeholder="Nhập từ khóa tìm kiếm..." autofocus>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                    <div class="mt-4">
                        <p class="text-muted small mb-2">Gợi ý tìm kiếm:</p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($navCategories->take(3) as $cat)
                                <a href="{{ route('courses.category', $cat->slug) }}" class="badge bg-light text-dark text-decoration-none">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ $scripts ?? '' }}
    
    {{-- Bootstrap 5 JS Bundle (includes Popper) --}}
    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}" defer></script>
    
    <script>
        // ==============================================
        // Combined scroll handler (1 listener thay vì 2)
        // Debounced với requestAnimationFrame để tránh layout thrashing
        // ==============================================
        (function() {
            var backToTop = document.getElementById('backToTop');
            var header = document.querySelector('.main-header');
            var ticking = false;

            function onScroll() {
                var y = window.scrollY;
                // Back to top
                if (y > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
                // Navbar shrink
                if (y > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                ticking = false;
            }

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(onScroll);
                    ticking = true;
                }
            }, { passive: true });

            backToTop.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Lazy-load Google Maps iframe khi vào viewport
            var mapIframe = document.querySelector('.footer-map iframe[data-src]');
            if (mapIframe && 'IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.src = entry.target.dataset.src;
                            observer.unobserve(entry.target);
                        }
                    });
                }, { rootMargin: '200px' });
                observer.observe(mapIframe);
            } else if (mapIframe) {
                mapIframe.src = mapIframe.dataset.src;
            }
        })();
    </script>
    
    @if($s('ga_body'))
        {!! $s('ga_body') !!}
    @endif
    @if ($s('custom_js'))
        <script>
            {!! $s('custom_js') !!}
        </script>
    @endif
</body>

</html>