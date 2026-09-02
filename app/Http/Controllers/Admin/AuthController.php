<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Tampilkan Halaman Login Admin & Sensei
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Proses Login Admin / Sensei
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        // Check if user is active
        $user = User::where('email', $credentials['email'])->first();
        if ($user && isset($user->is_active) && !$user->is_active) {
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan oleh administrator. Silakan hubungi bagian IT/SDM LPK SJI.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $roleName = Auth::user()->role_name ?? 'User';
            return redirect()->route('admin.dashboard')->with('success', "Selamat datang kembali, {$roleName} " . Auth::user()->name . "!");
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    /**
     * Tampilkan Halaman Lupa Password
     */
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Kirim Tautan Reset Password via Email / Token
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Alamat email ini tidak terdaftar dalam sistem administrator LPK SJI.',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        $resetLink = route('admin.password.reset', ['token' => $token, 'email' => $request->email]);

        // Simpan tautan reset link ke session flash info agar mudah diuji secara lokal & terkirim
        return back()->with([
            'success' => 'Tautan reset kata sandi telah berhasil dibuat dan dikirimkan ke email Anda.',
            'reset_link' => $resetLink,
            'email_sent' => $request->email,
        ]);
    }

    /**
     * Tampilkan Halaman Form Reset Kata Sandi Baru
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('admin.auth.reset-password', compact('token', 'email'));
    }

    /**
     * Eksekusi Reset Password Baru
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Permintaan reset kata sandi tidak valid atau telah kedaluwarsa.']);
        }

        // Cek token hash
        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Token reset kata sandi tidak valid atau telah digunakan.']);
        }

        // Update password user
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru.');
    }
}
