<x-layouts title="Thông tin tài khoản">
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Thông tin cá nhân -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-person-circle" style="font-size: 4rem; color: var(--bs-primary);"></i>
                            </div>
                            <h4 class="fw-bold">{{ $user->name }}</h4>
                            <p class="text-muted mb-1"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</p>
                            <span
                                class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'subadmin' ? 'warning' : 'primary') }}">
                                {{ $user->role === 'admin' ? 'Quản trị viên' : ($user->role === 'subadmin' ? 'Phó quản trị' : 'Người dùng') }}
                            </span>
                            <hr>
                            <p class="text-muted small mb-1">Ngày tham gia</p>
                            <p class="fw-semibold">{{ $user->created_at }}</p>

                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 mt-2">
                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabs nội dung -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="registrations-tab" data-bs-toggle="tab"
                                        data-bs-target="#registrations" type="button" role="tab">
                                        <i class="bi bi-mortarboard me-1"></i>Khóa học đã đăng ký
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="bookings-tab" data-bs-toggle="tab"
                                        data-bs-target="#bookings" type="button" role="tab">
                                        <i class="bi bi-door-open me-1"></i>Đặt phòng
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                        data-bs-target="#settings" type="button" role="tab">
                                        <i class="bi bi-gear me-1"></i>Cài đặt
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content pt-3" id="profileTabContent">
                                <!-- Tab Khóa học đăng ký -->
                                <div class="tab-pane fade show active" id="registrations" role="tabpanel">
                                    @if ($registrations->isEmpty())
                                        <div class="text-center py-4">
                                            <i class="bi bi-mortarboard text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2">Bạn chưa đăng ký khóa học nào.</p>
                                            <a href="{{ route('courses.index') }}" class="btn btn-primary">
                                                Xem khóa học
                                            </a>
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Khóa học</th>
                                                        <th>Ngày ĐK</th>
                                                        <th>Trạng thái</th>
                                                        <th>Thanh toán</th>
                                                        <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($registrations as $reg)
                                                        <tr>
                                                            <td>{{ $reg->course->title ?? 'N/A' }}</td>
                                                            <td>{{ $reg->registration_date?->format('d/m/Y') }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-{{ match ($reg->status) {
                                                                        'pending' => 'warning',
                                                                        'confirmed' => 'success',
                                                                        'cancelled', 'canceled' => 'danger',
                                                                        'completed' => 'info',
                                                                        default => 'secondary',
                                                                    } }}">
                                                                    {{ match ($reg->status) {
                                                                        'pending' => 'Đang chờ',
                                                                        'confirmed' => 'Đã xác nhận',
                                                                        'cancelled', 'canceled' => 'Đã hủy',
                                                                        'completed' => 'Hoàn thành',
                                                                        default => $reg->status,
                                                                    } }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-{{ match ($reg->payment_status) {
                                                                        'paid' => 'success',
                                                                        'unpaid' => 'warning',
                                                                        'refunded' => 'danger',
                                                                        default => 'secondary',
                                                                    } }}">
                                                                    {{ match ($reg->payment_status) {
                                                                        'paid' => 'Đã TT',
                                                                        'unpaid' => 'Chưa TT',
                                                                        'refunded' => 'Hoàn tiền',
                                                                        default => $reg->payment_status,
                                                                    } }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if ($reg->status === 'pending')
                                                                    <form method="POST" action="{{ route('auth.registrations.cancel', $reg->registration_id) }}" style="display: inline;">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hủy đăng ký" onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký này?')">
                                                                            <i class="bi bi-x-circle me-1"></i>Hủy
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>

                                <!-- Tab Đặt phòng -->
                                <div class="tab-pane fade" id="bookings" role="tabpanel">
                                    @if ($bookings->isEmpty())
                                        <div class="text-center py-4">
                                            <i class="bi bi-door-open text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2">Bạn chưa đặt phòng nào.</p>
                                            <a href="{{ route('rooms.index') }}" class="btn btn-primary">
                                                Xem phòng học
                                            </a>
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Mã ĐP</th>
                                                        <th>Phòng</th>
                                                        <th>Ngày bắt đầu</th>
                                                        <th>Trạng thái</th>
                                                        <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bookings as $booking)
                                                        <tr>
                                                            <td>{{ $booking->booking_code ?? '-' }}</td>
                                                            <td>{{ $booking->room->name ?? 'N/A' }}</td>
                                                            <td>{{ $booking->start_date?->format('d/m/Y') }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-{{ match ($booking->status) {
                                                                        'pending' => 'warning',
                                                                        'approved' => 'success',
                                                                        'rejected' => 'danger',
                                                                        default => 'secondary',
                                                                    } }}">
                                                                    {{ match ($booking->status) {
                                                                        'pending' => 'Chờ duyệt',
                                                                        'approved' => 'Đã duyệt',
                                                                        'rejected' => 'Từ chối',
                                                                        'cancelled_by_customer' => 'Đã hủy',
                                                                        'cancelled_by_admin' => 'Đã bị hủy bởi QTV',
                                                                        default => $booking->status,
                                                                    } }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if ($booking->status === 'pending')
                                                                    <form method="POST" action="{{ route('auth.bookings.cancel', $booking->booking_id) }}" style="display: inline;">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hủy đặt phòng" onclick="return confirm('Bạn có chắc chắn muốn hủy yêu cầu này?')">
                                                                            <i class="bi bi-x-circle me-1"></i>Hủy
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Tab Cài đặt tài khoản -->
                        <div class="tab-pane fade" id="settings" role="tabpanel">
                            <div class="row">
                                <!-- Cập nhật thông tin cá nhân -->
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0">
                                                <i class="bi bi-person-circle me-2"></i>Thông tin cá nhân
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('auth.update-profile') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Họ và tên</label>
                                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" id="email" class="form-control" value="{{ $user->email }}" disabled>
                                                    <small class="text-muted">Email không thể thay đổi</small>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="bi bi-check-circle me-2"></i>Lưu thay đổi
                                                </button>
                                            </form>

                                            @if (session('profile_success'))
                                                <div class="alert alert-success mt-3 mb-0" role="alert">
                                                    <i class="bi bi-check-circle me-2"></i>{{ session('profile_success') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Đổi mật khẩu -->
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-secondary text-white">
                                            <h5 class="mb-0">
                                                <i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('auth.change-password') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                                    <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                                    @error('current_password')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                                                    <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                                                    @error('new_password')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                                                </div>
                                                <div class="alert alert-info alert-sm mb-3">
                                                    <small><i class="bi bi-info-circle me-1"></i>Sau khi đổi mật khẩu, bạn sẽ được đăng xuất tự động.</small>
                                                </div>
                                                <button type="submit" class="btn btn-secondary w-100">
                                                    <i class="bi bi-arrow-repeat me-2"></i>Đổi mật khẩu
                                                </button>
                                            </form>

                                            @if (session('password_success'))
                                                <div class="alert alert-success mt-3 mb-0" role="alert">
                                                    <i class="bi bi-check-circle me-2"></i>{{ session('password_success') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    </div>
                </div>
            </div>
    </section>
</x-layouts>
