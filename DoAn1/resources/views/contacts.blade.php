<x-layouts title="Liên hệ">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active">Liên hệ</li>
                        </ol>
                    </nav>
                    <h1>Liên hệ với chúng tôi</h1>
                    <p class="lead">Hãy liên hệ để được tư vấn và hỗ trợ tốt nhất về các dịch vụ đào tạo và học tập.</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="bi bi-headset hero-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Cards -->
    <section class="section bg-light-gray">
        <div class="container">
            <div class="row g-4">
                <!-- Address Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card contact-card h-100 text-center">
                        <div class="card-body py-5">
                            <div class="contact-icon bg-primary bg-opacity-10 mx-auto mb-4">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Địa chỉ</h5>
                            <p class="card-text text-muted mb-0">
                                {{ App\Helpers\SettingHelper::get('address', 'Chưa cập nhật') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card contact-card h-100 text-center">
                        <div class="card-body py-5">
                            <div class="contact-icon bg-success bg-opacity-10 mx-auto mb-4">
                                <i class="bi bi-telephone text-success"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Điện thoại</h5>
                            <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}"
                                class="btn btn-outline-success">
                                <i class="bi bi-telephone-fill me-2"></i>{{ App\Helpers\SettingHelper::get('phone', 'Chưa cập nhật') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card contact-card h-100 text-center">
                        <div class="card-body py-5">
                            <div class="contact-icon bg-danger bg-opacity-10 mx-auto mb-4">
                                <i class="bi bi-envelope text-danger"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Email</h5>
                            <a href="mailto:{{ App\Helpers\SettingHelper::get('email', '') }}"
                                class="btn btn-outline-danger">
                                <i class="bi bi-envelope-fill me-2"></i>Gửi email
                            </a>
                            <p class="small text-muted mt-2 mb-0">{{ App\Helpers\SettingHelper::get('email', 'Chưa cập nhật') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Working Hours Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card contact-card h-100 text-center">
                        <div class="card-body py-5">
                            <div class="contact-icon bg-warning bg-opacity-10 mx-auto mb-4">
                                <i class="bi bi-clock text-warning"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Giờ làm việc</h5>
                            <div class="text-muted small">
                                <p class="mb-1"><strong>Thứ 2 - Thứ 7</strong></p>
                                <p class="mb-1">Sáng: 8:00 - 11:30</p>
                                <p class="mb-1">Tối: 18:00 - 21:00</p>
                                <p class="mb-0"><strong>Chủ nhật:</strong> Nghỉ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media & Quick Actions -->
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-4 p-lg-5 text-center">
                            <h4 class="fw-bold mb-4">Kết nối với chúng tôi</h4>
                            <p class="text-muted mb-4">Theo dõi chúng tôi trên mạng xã hội để cập nhật thông tin mới nhất</p>
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ App\Helpers\SettingHelper::get('facebook_fanpage', '#') }}" 
                                   class="btn btn-lg btn-primary" target="_blank">
                                    <i class="bi bi-facebook me-2"></i>Facebook
                                </a>
                                <a href="https://youtube.com" class="btn btn-lg btn-danger" target="_blank">
                                    <i class="bi bi-youtube me-2"></i>YouTube
                                </a>
                                <a href="https://zalo.me/{{ App\Helpers\SettingHelper::get('zalo', '') }}" 
                                   class="btn btn-lg btn-info text-white" target="_blank">
                                    <i class="bi bi-chat-dots me-2"></i>Zalo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Map Section -->
    <section class="section bg-light-gray">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary mb-3">VỊ TRÍ</span>
                <h2 class="fw-bold">Bản đồ trung tâm</h2>
                <p class="text-muted">Tìm đường đến trung tâm của chúng tôi</p>
            </div>
            <div class="card overflow-hidden">
                <div class="ratio ratio-21x9">
                    <iframe src="{{ App\Helpers\SettingHelper::get('google_map', '') }}"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h3>Bạn có câu hỏi?</h3>
            <p class="mb-4">Hãy gọi cho chúng tôi ngay để được tư vấn miễn phí.</p>
            <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}" class="btn btn-light btn-lg">
                <i class="bi bi-telephone me-2"></i>Gọi ngay: {{ App\Helpers\SettingHelper::get('phone', 'Hotline') }}
            </a>
        </div>
    </section>
</x-layouts>
