<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use App\Traits\UploadsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan Halaman Pengaturan Profil & Kata Sandi (Admin, Sensei, Karyawan)
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update Nama, Email, Telepon, dan Avatar Profil Pengguna
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:50',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        // Handle Avatar Upload jika ada
        if ($request->hasFile('avatar_file')) {
            $data['avatar'] = $this->handleImageUpload($request, 'avatar_file', 'avatar', $user->avatar);
        } elseif ($request->boolean('remove_avatar')) {
            $data['avatar'] = null;
        }

        $user->update($data);

        AuditLog::record(
            'profile.updated',
            "Pengguna {$user->name} ({$user->role_name}) memperbarui profil akun.",
            ['user_id' => $user->id, 'email' => $user->email],
            $user
        );

        return back()->with('success', 'Profil akun Anda berhasil diperbarui.');
    }

    /**
     * Update Kata Sandi (Password) Mandiri
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi baru minimal harus 6 karakter.',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        AuditLog::record(
            'profile.password_changed',
            "Pengguna {$user->name} ({$user->role_name}) berhasil mengganti kata sandi akunnya.",
            ['user_id' => $user->id],
            $user
        );

        return back()->with('success', 'Kata sandi akun Anda berhasil diperbarui.');
    }
}
