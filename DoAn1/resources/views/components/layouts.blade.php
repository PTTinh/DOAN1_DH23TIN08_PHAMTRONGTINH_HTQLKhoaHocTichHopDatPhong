<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ $attributes['title'] ? $attributes['title'] . ' - ' : '' }}{{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}
    </title>
    <link rel="icon" href="{{ asset('storage/' . App\Helpers\SettingHelper::get('logo')) }}" type="image/png">
    <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
 
    <link rel="stylesheet" href="{{ asset('css/bootstrap-custom.css') }}">
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 d-none d-md-block">
                    <div class="d-flex gap-4">
                        <a href="mailto:{{ App\Helpers\SettingHelper::get('email', '') }}" class="top-bar-link">
                            <i class="bi bi-envelope-fill me-2"></i>{{ App\Helpers\SettingHelper::get('email', 'Chưa cập nhật') }}
                        </a>
                        <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}" class="top-bar-link">
                            <i class="bi bi-telephone-fill me-2"></i>{{ App\Helpers\SettingHelper::get('phone', 'Chưa cập nhật') }}
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-center justify-content-md-end align-items-center gap-3">
                        <span class="d-none d-sm-inline text-white-50 small">Theo dõi chúng tôi:</span>
                        <div class="social-links">
                            <a href="{{ App\Helpers\SettingHelper::get('facebook_fanpage', '#') }}" class="social-link" title="Facebook" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="main-header">
        <nav class="navbar navbar-expand-xxl">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('storage/' . App\Helpers\SettingHelper::get('logo')) }}"
                        alt="{{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}"
                        class="header-logo">
                </a>

                <!-- Mobile Actions -->
                <div class="d-xxl-none d-flex align-items-center gap-2">
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
                                @foreach (App\Models\Category::all() as $Category)
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
                                @foreach (App\Models\NewsCategory::all() as $newsCategory)
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
                    </ul>

                    <!-- Search & CTA (Desktop) -->
                    <div class="d-none d-xxl-flex align-items-center gap-3">
                        <form action="{{ route('search') }}" method="GET" class="header-search" role="search">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control"
                                    placeholder="Tìm kiếm..." aria-label="Tìm kiếm">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1" title="{{ Auth::user()->name }}"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    @if (Route::has('auth.profile'))
                                        <li>
                                            <a class="dropdown-item" href="{{ route('auth.profile') }}">
                                                <i class="bi bi-person me-2"></i>Tài khoản
                                            </a>
                                        </li>
                                    @endif
                                    @if(in_array(Auth::user()->role ?? '', ['admin', 'subadmin']))
                                        <li>
                                            <a class="dropdown-item" href="{{ url('/admin') }}">
                                                <i class="bi bi-gear me-2"></i>Quản trị
                                            </a>
                                        </li>
                                    @endif
                                    @if (Route::has('auth.logout') || Route::has('filament.admin.auth.logout'))
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ Route::has('auth.logout') ? route('auth.logout') : route('filament.admin.auth.logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @else
                            @if (Route::has('auth.login'))
                                <a href="{{ route('auth.login') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                                </a>
                            @elseif (Route::has('filament.admin.auth.login'))
                                <a href="{{ route('filament.admin.auth.login') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập quản trị
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="d-xxl-none pt-3 border-top mt-3">
                        @auth
                            <div class="d-flex gap-2">
                                @if (Route::has('auth.profile'))
                                    <a href="{{ route('auth.profile') }}" class="btn btn-outline-primary flex-grow-1">
                                        <i class="bi bi-person me-1"></i>Tài khoản
                                    </a>
                                @endif
                                @if (Route::has('auth.logout') || Route::has('filament.admin.auth.logout'))
                                    <form method="POST" action="{{ Route::has('auth.logout') ? route('auth.logout') : route('filament.admin.auth.logout') }}" class="flex-grow-1">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            @if (Route::has('auth.login'))
                                <a href="{{ route('auth.login') }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                                </a>
                            @elseif (Route::has('filament.admin.auth.login'))
                                <a href="{{ route('filament.admin.auth.login') }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập quản trị
                                </a>
                            @endif
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
                            <img src="{{ asset('storage/' . App\Helpers\SettingHelper::get('logo')) }}" 
                                 alt="{{ App\Helpers\SettingHelper::get('center_name') }}"
                                 class="footer-logo mb-3">
                            <h5 class="text-white fw-bold">{{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}</h5>
                        </div>
                        <p class="text-white-50 mb-4">
                            Trung tâm đào tạo chất lượng cao với đội ngũ giảng viên giàu kinh nghiệm và cơ sở vật chất hiện đại.
                        </p>
                        <div class="footer-social">
                            <a href="{{ App\Helpers\SettingHelper::get('facebook_fanpage', '#') }}" class="footer-social-link" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-6 col-lg-2">
                        <h6 class="footer-title">Khóa học</h6>
                        <ul class="footer-links">
                            <li><a href="{{ route('courses.index') }}">Tất cả khóa học</a></li>
                            @foreach (App\Models\Category::take(4)->get() as $Category)
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
                                <span>{{ App\Helpers\SettingHelper::get('address', 'Chưa cập nhật') }}</span>
                            </li>
                            <li>
                                <i class="bi bi-telephone-fill"></i>
                                <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}">
                                    {{ App\Helpers\SettingHelper::get('phone', 'Chưa cập nhật') }}
                                </a>
                            </li>
                            <li>
                                <i class="bi bi-envelope-fill"></i>
                                <a href="mailto:{{ App\Helpers\SettingHelper::get('email', '') }}">
                                    {{ App\Helpers\SettingHelper::get('email', 'Chưa cập nhật') }}
                                </a>
                            </li>
                            <li>
                                <i class="bi bi-clock-fill"></i>
                                <span>T2 - T7: 8:00 - 21:00</span>
                            </li>
                        </ul>
                        
                        <!-- Mini Map -->
                        <div class="footer-map mt-3">
                            {!! App\Helpers\SettingHelper::get('google_map', '') !!}
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
                            &copy; {{ date('Y') }} <strong>{{ App\Helpers\SettingHelper::get('center_name', 'Trung tâm đào tạo') }}</strong>. 
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


    @include('chatbot.widget')

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
                            @foreach (App\Models\Category::take(3)->get() as $cat)
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
    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    
    <script>
        // Back to top button
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Navbar scroll effect
        const header = document.querySelector('.main-header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
    
    @if(App\Helpers\SettingHelper::get('ga_body'))
        {!! App\Helpers\SettingHelper::get('ga_body') !!}
    @endif
    @if (App\Helpers\SettingHelper::get('custom_js'))
        <script>
            {!! App\Helpers\SettingHelper::get('custom_js') !!}
        </script>
    @endif
</body>

</html>