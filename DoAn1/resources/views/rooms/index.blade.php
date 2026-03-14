<x-layouts title="Phòng Học">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active">Phòng học</li>
                        </ol>
                    </nav>
                    <h1>Phòng học hiện đại</h1>
                    <p class="lead">Khám phá các phòng học được trang bị đầy đủ thiết bị hiện đại, mang đến trải nghiệm học tập tốt nhất.</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="bi bi-building hero-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Bar -->
    <section class="py-4 bg-white border-bottom">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-wifi text-primary fs-4"></i>
                        <span class="fw-medium">Wifi tốc độ cao</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-snow text-primary fs-4"></i>
                        <span class="fw-medium">Điều hòa mát mẻ</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-tv text-primary fs-4"></i>
                        <span class="fw-medium">Màn hình lớn</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-shield-check text-primary fs-4"></i>
                        <span class="fw-medium">An ninh 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Grid -->
    <section class="section bg-light-gray">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="text-muted mb-0">
                    <i class="bi bi-building me-1"></i>
                    Hiển thị <strong class="text-dark">{{ $rooms->count() }}</strong> phòng học
                </p>
            </div>

            @if ($rooms->count() > 0)
                <div class="row g-4">
                    @foreach ($rooms as $room)
                        <div class="col-md-6 col-lg-4">
                            <div class="card room-card h-100">
                                <div class="card-img-wrapper">
                                    <img src="{{ Storage::url($room->image) }}" alt="{{ $room->name }}">
                                    <div class="room-overlay">
                                        <a href="{{ route('rooms.show', $room->room_id) }}" class="btn btn-light btn-lg">
                                            <i class="bi bi-eye me-2"></i>Xem chi tiết
                                        </a>
                                    </div>
                                    <span class="capacity-badge">
                                        <i class="bi bi-people-fill text-primary me-1"></i>{{ $room->capacity }} chỗ
                                    </span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <a href="{{ route('rooms.show', $room->room_id) }}">{{ $room->name }}</a>
                                    </h5>
                                    
                                    <div class="equipment-list">
                                        @forelse ($room->equipment->take(4) as $equipment)
                                            <span class="equipment-badge">
                                                <i class="bi bi-check-circle-fill text-success me-1"></i>{{ $equipment->name }}
                                            </span>
                                        @empty
                                            <span class="text-muted small">Đang cập nhật...</span>
                                        @endforelse
                                        @if($room->equipment->count() > 4)
                                            <span class="badge bg-primary">+{{ $room->equipment->count() - 4 }}</span>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                                        <a href="{{ route('rooms.show', $room->room_id) }}" class="btn btn-sm btn-primary">
                                            Đặt phòng <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-building text-muted" style="font-size: 5rem;"></i>
                    <h4 class="text-muted mt-4 mb-3">Không có phòng học nào</h4>
                    <p class="text-muted mb-4">Vui lòng quay lại sau hoặc liên hệ với chúng tôi để biết thêm thông tin.</p>
                    <a href="{{ route('contacts') }}" class="btn btn-primary">
                        <i class="bi bi-telephone me-2"></i>Liên hệ
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3>Cần đặt phòng cho sự kiện, hội thảo?</h3>
                    <p class="mb-0">Liên hệ với chúng tôi để được tư vấn và hỗ trợ đặt phòng nhanh chóng.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="tel:{{ App\Helpers\SettingHelper::get('phone', '') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-telephone me-2"></i>{{ App\Helpers\SettingHelper::get('phone', 'Liên hệ') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts>
