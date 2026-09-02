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

    public function index()
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        // Hanya admin yang dapat mengelola users
        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403, 'Akses terbatas untuk Administrator.');
        }

        $users = User::orderBy('role')->latest()->paginate(15);
        $rolesCount = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'teacher' => User::where('role', 'teacher')->count(),
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
            'role' => 'required|in:admin,teacher,staff',
            'phone' => 'nullable|string|max:50',
            'password' => 'required|string|min:6',
            'is_active' => 'nullable|boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->has('is_active'),
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', "Akun pengguna {$validated['name']} ({$validated['role']}) berhasil dibuat.");
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
            'role' => 'required|in:admin,teacher,staff',
            'phone' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return back()->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
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
        $user->delete();

        return back()->with('success', "Pengguna {$userName} berhasil dihapus.");
    }
}
