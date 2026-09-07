<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\UploadsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use UploadsImage;

    public function index(Request $request)
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        // Hanya admin yang dapat mengelola users
        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403, 'Akses terbatas untuk Administrator.');
        }

        $query = User::query();

        // Filter Role
        if ($request->filled('role')) {
            $roleFilter = $request->role;
            if ($roleFilter === 'staff' || $roleFilter === 'karyawan') {
                $query->whereIn('role', ['staff', 'karyawan']);
            } else {
                $query->where('role', $roleFilter);
            }
        }

        // Search Query
        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('role')->latest()->paginate(15)->withQueryString();

        $rolesCount = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'teacher' => User::where('role', 'teacher')->count(),
            'staff' => User::whereIn('role', ['staff', 'karyawan'])->count(),
        ];

        return view('admin.users.index', compact('users', 'rolesCount'));
    }

    public function store(Request $request)
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'role' => 'required|in:admin,teacher,staff,karyawan',
            'phone' => 'nullable|string|max:50',
            'password' => 'required|string|min:6',
            'is_active' => 'nullable|boolean',
        ]);

        $role = $validated['role'] === 'karyawan' ? 'staff' : $validated['role'];

        $createdUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $role,
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->has('is_active'),
            'password' => Hash::make($validated['password']),
        ]);

        $roleLabel = match($role) {
            'admin' => 'Administrator',
            'teacher' => 'Pengajar / Sensei',
            'staff' => 'Karyawan / Staf LPK',
            default => ucfirst($role)
        };

        \App\Models\AuditLog::record(
            'user.created',
            "Administrator membuat akun baru: {$createdUser->name} ({$roleLabel}) [{$createdUser->email}].",
            ['target_user_id' => $createdUser->id, 'role' => $role]
        );

        return back()->with('success', "Akun pengguna {$validated['name']} ({$roleLabel}) berhasil dibuat.");
    }

    public function update(Request $request, $id)
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403);
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,teacher,staff,karyawan',
            'phone' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6',
            'is_active' => 'nullable|boolean',
        ]);

        $role = $validated['role'] === 'karyawan' ? 'staff' : $validated['role'];

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $role,
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        \App\Models\AuditLog::record(
            'user.updated',
            "Administrator memperbarui data akun: {$user->name} ({$user->role_name}).",
            ['target_user_id' => $user->id, 'role' => $role]
        );

        return back()->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    public function toggleStatus($id)
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusMsg = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        \App\Models\AuditLog::record(
            'user.toggle_status',
            "Administrator {$statusMsg} akun: {$user->name} ({$user->role_name}).",
            ['target_user_id' => $user->id, 'is_active' => $user->is_active]
        );

        return back()->with('success', "Status akun {$user->name} berhasil {$statusMsg}.");
    }

    public function destroy($id)
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $userRole = $user->role_name;
        $user->delete();

        \App\Models\AuditLog::record(
            'user.deleted',
            "Administrator menghapus akun pengguna: {$userName} ({$userRole}).",
            ['deleted_user_name' => $userName]
        );

        return back()->with('success', "Pengguna {$userName} berhasil dihapus.");
    }
}
