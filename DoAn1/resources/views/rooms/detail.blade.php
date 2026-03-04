<x-layouts title="Phòng Học - {{ $room->name }}" ogTitle="{{ $room->seo_title }}"
    ogDescription="{{ $room->seo_description }}" ogImage="{{ $room->seo_image }}">

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item"><a href="/"><i class="bi bi-house"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Phòng học</a></li>
                            <li class="breadcrumb-item active">{{ $room->name }}</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @php
                            $statusText = match ($room->status) {
                                'available' => 'Có sẵn',
                                'maintenance' => 'Bảo trì',
                                default => 'Không có sẵn',
                            };
                            $statusColor = match ($room->status) {
                                'available' => 'success',
                                'maintenance' => 'warning',
                                default => 'danger',
                            };
                        @endphp
                        <span class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-people me-1"></i>{{ $room->capacity }} người
                        </span>
                    </div>
                    <h1>{{ $room->name }}</h1>
                    <p class="lead mb-0">
                        <i class="bi bi-geo-alt me-2"></i>{{ $room->location }}
                    </p>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="bi bi-door-open hero-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Room Detail -->
    <section class="section bg-light-gray">
        <div class="container">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Room Image -->
                    <div class="card overflow-hidden mb-4">
                        <img src="{{ Storage::url($room->image) }}" class="card-img-top" alt="{{ $room->name }}"
                            style="height: 450px; object-fit: cover;">
                    </div>

                    <!-- Room Info Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card h-100 text-center">
                                <div class="card-body py-4">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="bi bi-people text-primary fs-4"></i>
                                    </div>
                                    <p class="small text-muted mb-1">Sức chứa</p>
                                    <p class="h5 fw-bold mb-0">{{ $room->capacity }} người</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card h-100 text-center">
                                <div class="card-body py-4">
                                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="bi bi-geo-alt text-success fs-4"></i>
                                    </div>
                                    <p class="small text-muted mb-1">Vị trí</p>
                                    <p class="h6 fw-bold mb-0">{{ $room->location }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div class="card h-100 text-center bg-primary text-white">
                                <div class="card-body py-4">
                                    <div class="rounded-circle bg-white bg-opacity-25 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="bi bi-cash-coin text-white fs-4"></i>
                                    </div>
                                    <p class="small mb-1 opacity-75">Giá thuê</p>
                                    <p class="h5 fw-bold mb-0">{{ number_format($room->price, 0, ',', '.') }}đ<small class="fw-normal">/{{ App\Helpers\SettingHelper::get('room_rental_unit') }}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Description -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-info-circle text-primary me-2"></i>Mô tả phòng học
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="content-body article-content">
                                {!! $room->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Booking Form -->
                <div class="col-lg-4">
                    <div class="card position-sticky" style="top: 100px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-calendar-check me-2"></i>Đặt phòng học
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('rooms.bookings') }}" method="POST" class="needs-validation">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <x-app-input 
                                    name="name" 
                                    label="Họ và tên" 
                                    type="text" 
                                    :value="old('name')" 
                                    required 
                                />
                                <x-app-input 
                                    name="email" 
                                    label="Email" 
                                    type="email" 
                                    :value="old('email')" 
                                    required 
                                />
                                <x-app-input 
                                    name="phone" 
                                    label="Số điện thoại" 
                                    type="tel" 
                                    :value="old('phone')" 
                                    required 
                                />
                                <x-app-input 
                                    name="participants_count" 
                                    label="Số người tham gia" 
                                    type="number" 
                                    :value="old('participants_count', 5)" 
                                    required 
                                />
                                <x-app-input 
                                    name="reason" 
                                    label="Lý do đặt phòng" 
                                    type="text" 
                                    :value="old('reason')" 
                                    required 
                                />
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Ghi chú (không bắt buộc)</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="room_type" class="form-label">Loại đặt phòng</label>
                                    <select class="form-select @error('room_type') is-invalid @enderror" id="room_type" name="room_type" onchange="toggleRecurrence(this.value)">
                                        <option value="none" {{ old('room_type') == 'none' ? 'selected' : '' }}>Đặt theo ngày</option>
                                        <option value="weekly" {{ old('room_type') == 'weekly' ? 'selected' : '' }}>Đặt theo tuần</option>
                                    </select>
                                    @error('room_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="recurrence-days" class="mb-3" style="display: {{ old('room_type') == 'weekly' ? 'block' : 'none' }};">
                                    <label class="form-label">Chọn ngày trong tuần</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @php
                                            $daysOfWeek = [
                                                'monday' => 'T2',
                                                'tuesday' => 'T3',
                                                'wednesday' => 'T4',
                                                'thursday' => 'T5',
                                                'friday' => 'T6',
                                                'saturday' => 'T7',
                                                'sunday' => 'CN',
                                            ];
                                        @endphp
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="all-days" name="all_days" value="all" {{ old('all_days') ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="all-days">Tất cả</label>
                                        </div>
                                        @foreach ($daysOfWeek as $key => $day)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="{{ $key }}" 
                                                    name="repeat_days[]" value="{{ $key }}" {{ in_array($key, old('repeat_days', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="{{ $key }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <x-app-input 
                                            name="start_date" 
                                            label="Ngày bắt đầu" 
                                            type="date" 
                                            :value="old('start_date')" 
                                            required 
                                        />
                                    </div>
                                    <div class="col-6">
                                        <x-app-input 
                                            name="end_date" 
                                            label="Ngày kết thúc" 
                                            type="date" 
                                            :value="old('end_date')" 
                                            required 
                                        />
                                    </div>
                                    <div class="col-6">
                                        <x-app-input 
                                            name="start_time" 
                                            label="Giờ bắt đầu" 
                                            type="time" 
                                            :value="old('start_time')" 
                                            required 
                                        />
                                    </div>
                                    <div class="col-6">
                                        <x-app-input 
                                            name="end_time" 
                                            label="Giờ kết thúc" 
                                            type="time" 
                                            :value="old('end_time')" 
                                            required 
                                        />
                                    </div>
                                </div>

                                <!-- reCAPTCHA -->
                                @if (config('services.recaptcha.enabled', false))
                                    <x-recaptcha form-type="room-booking" />
                                @endif

                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold mt-3">
                                    <i class="bi bi-check-circle me-2"></i>Đặt phòng ngay
                                </button>
                            </form>

                            <hr class="my-4">
                            <div class="text-center">
                                <p class="small text-muted mb-2">Cần hỗ trợ?</p>
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
            <h3>Xem thêm phòng học khác</h3>
            <p class="mb-4">Khám phá các phòng học hiện đại với đầy đủ tiện nghi.</p>
            <a href="{{ route('rooms.index') }}" class="btn btn-light btn-lg">
                <i class="bi bi-door-open me-2"></i>Xem tất cả phòng học
            </a>
        </div>
    </section>

    <x-slot:scripts>
        @if (config('services.recaptcha.enabled', false))
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endif

        <script>
            function toggleRecurrence(type) {
                const recurrenceDays = document.getElementById('recurrence-days');
                recurrenceDays.style.display = type === 'weekly' ? 'block' : 'none';
                const checkboxes = recurrenceDays.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.disabled = type !== 'weekly';
                    if (type !== 'weekly') checkbox.checked = false;
                });
            }

            const allDaysCheckbox = document.getElementById('all-days');
            allDaysCheckbox?.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('#recurrence-days input[type="checkbox"]:not(#all-days)');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            const roomType = document.getElementById('room_type');

            startDate?.addEventListener('change', function() {
                if (roomType.value === 'none') {
                    endDate.value = startDate.value;
                }
            });
        </script>
    </x-slot:scripts>
</x-layouts>
