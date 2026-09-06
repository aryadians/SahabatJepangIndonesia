<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request for Role-Based Access Control (RBAC).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Cek apakah akun aktif
        if (isset($user->is_active) && !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Akun Anda dinonaktifkan oleh administrator. Silakan hubungi bagian IT/SDM LPK SJI.',
            ]);
        }

        // Jika tidak ada peran spesifik yang ditentukan, izinkan
        if (empty($roles)) {
            return $next($request);
        }

        // Administrator selalu memiliki hak akses penuh ke seluruh modul
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Cek apakah peran user cocok dengan salah satu peran yang diizinkan
        // (dukung alias: staff / karyawan)
        $userRole = $user->role;
        $matched = in_array($userRole, $roles, true);

        if (!$matched && ($userRole === 'staff' || $userRole === 'karyawan')) {
            $matched = in_array('staff', $roles, true) || in_array('karyawan', $roles, true);
        }

        if (!$matched) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak: Anda tidak memiliki izin untuk tindakan ini.',
                ], 403);
            }

            $userRoleLabel = $user->role_name ?? ucfirst($userRole);
            abort(403, "Akses Ditolak: Peran akun Anda ({$userRoleLabel}) tidak memiliki otorisasi untuk mengakses halaman ini.");
        }

        return $next($request);
    }
}
