<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Show the forgot password request form.
     */
    public function showForgotPasswordForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.forgot-password');
    }

    /**
     * Send a password reset link to the submitted email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_THROTTLED) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Vui lòng chờ trước khi gửi lại yêu cầu khôi phục mật khẩu.']);
        }

        return back()
            ->withInput($request->only('email'))
            ->with('status', 'Nếu email tồn tại trong hệ thống, chúng tôi đã gửi link khôi phục mật khẩu.');
    }

    /**
     * Show the password reset form for a valid reset link.
     */
    public function showResetPasswordForm(Request $request, string $token)
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.reset-password', [
            'email' => $request->query('email', ''),
            'token' => $token,
        ]);
    }

    /**
     * Reset the user's password with a broker token.
     */
    public function resetPassword(Request $request, string $token)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $token,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('status', 'Đổi mật khẩu thành công. Bạn có thể đăng nhập bằng mật khẩu mới.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Token không hợp lệ hoặc đã hết hạn.']);
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        if (! $request->filled('email') && ! $request->filled('password')) {
            return back()
                ->withInput()
                ->with('login_error', 'Điền đầy đủ tài khoản và mật khẩu.');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Tài khoản không được để trống.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Mật khẩu không được để trống.',
        ]);

        $remember = $request->has('remember');

        // Simple auth attempt. In a real app, you might want to check if the user is_admin
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Kiểm tra tài khoản có bị khóa không
            if ($user->is_locked) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
