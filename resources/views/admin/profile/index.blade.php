@extends('admin.layouts.admin')

@section('title', 'Profil & Keamanan Akun')
@section('page_title', 'Profil & Keamanan Akun')

@section('content')
<div class="space-y-6 max-w-6xl">

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 text-white shadow-md border border-slate-700/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <!-- Avatar Display -->
            <div class="relative group">
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-white/20 shadow-md">
                @else
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-japan-600 to-red-700 text-white flex items-center justify-center font-black text-2xl shadow-md border-2 border-white/20">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 border-2 border-slate-900 flex items-center justify-center" title="Akun Aktif">
                    <i data-lucide="check" class="w-3 h-3 text-white"></i>
                </span>
            </div>

            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-black text-white">{{ $user->name }}</h2>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $user->role_badge_class }}">
                        {{ $user->role_name }}
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-0.5">{{ $user->email }}</p>
                <div class="flex items-center gap-3 mt-2 text-[11px] text-slate-400">
                    <span class="flex items-center gap-1">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span>Status: Terverifikasi</span>
                    </span>
                    <span>&bull;</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Bergabung: {{ $user->created_at ? $user->created_at->format('d M Y') : '2026' }}</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-bold text-white transition flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Kolom Kiri: Form Informasi Akun (7 Kolom) -->
        <div class="lg:col-span-7 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                        <i data-lucide="user-pen" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Informasi Biodata & Kontak</h3>
                        <p class="text-xs text-slate-400">Perbarui identitas profil dan kontak nomor WhatsApp Anda</p>
                    </div>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Foto Avatar -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Foto Profil (Avatar)</label>
                        <div class="flex items-center gap-4">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" id="avatarPreview" alt="{{ $user->name }}" class="w-14 h-14 rounded-2xl object-cover border border-slate-200 shadow-xs">
                            @else
                                <div id="avatarFallback" class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center font-black text-xl border border-slate-200 shadow-xs">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="space-y-1">
                                <input 
                                    type="file" 
                                    name="avatar_file" 
                                    id="avatarInput" 
                                    accept="image/png,image/jpeg,image/webp" 
                                    class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-japan-600 hover:file:bg-red-100 cursor-pointer"
                                    onchange="previewProfileAvatar(this)"
                                >
                                <p class="text-[10px] text-slate-400">Format: JPG, PNG, WEBP. Maksimal 3MB (Otomatis dikompresi jernih).</p>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Lengkap</label>
                        <div class="relative">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                required 
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:outline-none focus:border-japan-600 transition"
                            >
                        </div>
                    </div>

                    <!-- Email Login -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Alamat Email Login</label>
                        <div class="relative">
                            <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}" 
                                required 
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-900 focus:outline-none focus:border-japan-600 transition"
                            >
                        </div>
                    </div>

                    <!-- Nomor Telepon / WA -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nomor WhatsApp / Kontak</label>
                        <div class="relative">
                            <i data-lucide="phone" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input 
                                type="text" 
                                name="phone" 
                                value="{{ old('phone', $user->phone) }}" 
                                placeholder="08xxxxxxxxxx" 
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-900 focus:outline-none focus:border-japan-600 transition"
                            >
                        </div>
                    </div>

                    <!-- Peran / Hak Akses (Readonly) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tingkat Hak Akses (Peran)</label>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            <div class="flex items-center gap-2">
                                <i data-lucide="shield" class="w-4 h-4 text-slate-500"></i>
                                <span class="font-bold text-slate-800">{{ $user->role_name }}</span>
                            </div>
                            <span class="text-[10px] text-slate-400">Dikelola oleh Administrator</span>
                        </div>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span>Simpan Perubahan Profil</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Kolom Kanan: Ganti Password Mandiri & Keamanan (5 Kolom) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Ganti Kata Sandi</h3>
                        <p class="text-xs text-slate-400">Pastikan menggunakan sandi kombinasi yang kuat</p>
                    </div>
                </div>

                <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Kata Sandi Saat Ini -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <i data-lucide="key-round" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input 
                                type="password" 
                                name="current_password" 
                                id="currentPasswordInput"
                                required 
                                placeholder="••••••••" 
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 transition"
                            >
                            <button type="button" onclick="togglePassVisibility('currentPasswordInput', this)" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Kata Sandi Baru -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi Baru</label>
                        <div class="relative">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input 
                                type="password" 
                                name="password" 
                                id="newPasswordInput"
                                required 
                                minlength="6"
                                placeholder="Minimal 6 karakter" 
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 transition"
                            >
                            <button type="button" onclick="togglePassVisibility('newPasswordInput', this)" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Konfirmasi Kata Sandi Baru -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Ulangi Kata Sandi Baru</label>
                        <div class="relative">
                            <i data-lucide="check-check" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="confirmPasswordInput"
                                required 
                                minlength="6"
                                placeholder="Ulangi kata sandi baru" 
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 transition"
                            >
                            <button type="button" onclick="togglePassVisibility('confirmPasswordInput', this)" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tips Keamanan -->
                    <div class="p-3.5 rounded-2xl bg-amber-50/60 border border-amber-200/70 text-xs text-amber-900 space-y-1">
                        <p class="font-bold flex items-center gap-1.5 text-amber-800">
                            <i data-lucide="info" class="w-3.5 h-3.5"></i>
                            <span>Pedoman Keamanan Sandi</span>
                        </p>
                        <p class="text-[11px] text-amber-700 leading-relaxed">
                            Gunakan kombinasi minimal 6 karakter dengan variasi huruf besar, kecil, angka, atau simbol. Jangan gunakan kata sandi yang mudah ditebak.
                        </p>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full btn-red-primary py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center justify-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            <span>Perbarui Kata Sandi Saya</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>

<script>
    function togglePassVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<i data-lucide="eye-off" class="w-4 h-4"></i>';
        } else {
            input.type = 'password';
            btn.innerHTML = '<i data-lucide="eye" class="w-4 h-4"></i>';
        }
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function previewProfileAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let preview = document.getElementById('avatarPreview');
                let fallback = document.getElementById('avatarFallback');
                if (!preview && fallback) {
                    preview = document.createElement('img');
                    preview.id = 'avatarPreview';
                    preview.className = 'w-14 h-14 rounded-2xl object-cover border border-slate-200 shadow-xs';
                    fallback.parentNode.replaceChild(preview, fallback);
                }
                if (preview) {
                    preview.src = e.target.result;
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
