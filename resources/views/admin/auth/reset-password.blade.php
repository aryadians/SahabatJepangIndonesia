<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - LPK Sahabat Jepang Indonesia</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='48' fill='%23DC2626'/><circle cx='50' cy='50' r='38' fill='white'/><text x='50' y='66' font-size='46' font-weight='900' font-family='sans-serif' text-anchor='middle' fill='%23DC2626'>友</text></svg>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        japan: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                            950: '#4c0519',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        japanese: ['"Noto Sans JP"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden font-sans select-none">
    
    <!-- Canvas & Ambient Glow -->
    <div class="absolute -top-40 -left-40 w-[30rem] h-[30rem] rounded-full bg-red-600/20 blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-[30rem] h-[30rem] rounded-full bg-rose-600/15 blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 my-8">
        
        <!-- Header -->
        <div class="text-center mb-6 space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black text-2xl mx-auto shadow-2xl shadow-red-600/50 ring-4 ring-white/10">
                友
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Atur Kata Sandi Baru</h1>
            <p class="text-xs text-red-300/80 font-bold">LPK Sahabat Jepang Indonesia</p>
        </div>

        <!-- Card -->
        <div class="glass-card text-slate-800 rounded-3xl p-7 sm:p-9 shadow-2xl border border-white/40 relative">
            
            <div class="mb-5">
                <h2 class="text-lg font-black text-slate-900 tracking-tight">Buat Kata Sandi Baru</h2>
                <p class="text-xs text-slate-400 mt-0.5">Masukkan kata sandi baru untuk akun administrator / pengajar Anda</p>
            </div>

            @if($errors->any())
                <div class="mb-4 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1 shadow-sm">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 flex-shrink-0"></i>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email (Readonly) -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Email Akun</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $email) }}" 
                            required 
                            readonly
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 bg-slate-100 cursor-not-allowed"
                        >
                    </div>
                </div>

                <!-- Password Baru -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi Baru *</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="password" 
                            id="resetPassword"
                            name="password" 
                            required 
                            minlength="6"
                            placeholder="Minimal 6 karakter"
                            class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600 transition"
                        >
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility('resetPassword', 'eyeIcon1')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 p-1"
                        >
                            <i id="eyeIcon1" data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Konfirmasi Kata Sandi Baru *</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="password" 
                            id="resetPasswordConfirm"
                            name="password_confirmation" 
                            required 
                            minlength="6"
                            placeholder="Ulangi kata sandi baru"
                            class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600 transition"
                        >
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility('resetPasswordConfirm', 'eyeIcon2')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 p-1"
                        >
                            <i id="eyeIcon2" data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-extrabold text-xs sm:text-sm shadow-xl shadow-red-600/30 transition flex items-center justify-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Simpan Kata Sandi Baru</span>
                    </button>
                </div>

            </form>

            <div class="mt-5 pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('admin.login') }}" class="text-xs text-slate-500 hover:text-japan-600 font-bold inline-flex items-center gap-1.5">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke Halaman Login</span>
                </a>
            </div>

        </div>

    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        lucide.createIcons();
    </script>
</body>
</html>
