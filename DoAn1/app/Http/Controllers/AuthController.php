<?php

namespace App\Http\Controllers;

use App\Mail\EmailChangeNotification;
use App\Mail\EmailVerificationCodeMail;
use App\Models\CourseRegistration;
use App\Models\RoomBooking;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])
                ->onlyInput('email');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])
                ->onlyInput('email');
        }

        Auth::login($user, (bool) ($credentials['remember'] ?? false));
        $request->session()->regenerate();

        return redirect()->intended(route('auth.profile'));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
            'status' => 'active',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('auth.profile')
            ->with('success', 'Đăng ký tài khoản thành công.');
    }

    public function profile(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $registrations = CourseRegistration::with('course')
            ->where(function ($query) use ($user) {
                $query->where('created_by', $user->id)
                    ->orWhere('student_email', $user->email);
            })
            ->latest('registration_date')
            ->latest('created_at')
            ->get();

        $bookings = RoomBooking::with('room')
            ->where(function ($query) use ($user) {
                $query->where('created_by', $user->id)
                    ->orWhere('customer_email', $user->email);
            })
            ->latest('start_date')
            ->latest('created_at')
            ->get();

        return view('auth.profile', compact('user', 'registrations', 'bookings'));
    }

    public function cancelRegistration(Request $request, int $registrationId): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $registration = CourseRegistration::where('registration_id', $registrationId)
            ->where(function ($query) use ($user) {
                $query->where('created_by', $user->id)
                    ->orWhere('student_email', $user->email);
            })
            ->first();

        if (!$registration) {
            return back()->with('error', 'Không tìm thấy đăng ký để hủy.');
        }

        if ($registration->status !== 'pending') {
            return back()->with('warning', 'Chỉ có thể hủy đăng ký khi đang chờ duyệt.');
        }

        $registration->status = 'cancelled';
        $registration->save();

        return back()->with('success', 'Đã hủy đăng ký khóa học thành công.');
    }

    public function cancelBooking(Request $request, int $bookingId): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $booking = RoomBooking::where('booking_id', $bookingId)
            ->where(function ($query) use ($user) {
                $query->where('created_by', $user->id)
                    ->orWhere('customer_email', $user->email);
            })
            ->first();

        if (!$booking) {
            return back()->with('error', 'Không tìm thấy yêu cầu đặt phòng để hủy.');
        }

        if ($booking->status !== 'pending') {
            return back()->with('warning', 'Chỉ có thể hủy đặt phòng khi đang chờ duyệt.');
        }

        $booking->status = 'cancelled_by_customer';
        $booking->cancelled_by = $user->id;
        $booking->save();

        $booking->room_booking_details()
            ->where('status', 'pending')
            ->update([
                'status' => 'cancelled',
                'cancelled_by_customer' => true,
                'cancelled_by' => $user->id,
            ]);

        return back()->with('success', 'Đã hủy yêu cầu đặt phòng thành công.');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->name = $data['name'];
        $user->save();

        return back()->with('success', 'Cập nhật thông tin tài khoản thành công.');
    }

    public function changePassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        if (Hash::check($data['new_password'], $user->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới phải khác mật khẩu hiện tại.']);
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công.');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Bạn đã đăng xuất thành công.');
    }
}
