@extends('admin.layouts.admin')

@section('title', 'Profil & Keamanan Akun')
@section('page_title', 'Pengaturan Akun Administrator')

@section('content')
<div class="max-w-4xl space-y-8">
    
    <!-- 1. Update Profile Info -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Informasi Akun Admin</h3>
                <p class="text-xs text-slate-500">Nama tampilan dan alamat email login</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4 max-w-lg">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Lengkap Administrator</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Alamat Email Login</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-medium">
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Perubahan Profil</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 2. Update Password -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
        <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="lock" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Ganti Kata Sandi (Password)</h3>
                <p class="text-xs text-slate-500">Pastikan menggunakan kombinasi kata sandi yang aman</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-4 max-w-lg">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kata Sandi Baru (Min. 6 Karakter)</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="key" class="w-4 h-4"></i>
                    <span>Perbarui Kata Sandi</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
