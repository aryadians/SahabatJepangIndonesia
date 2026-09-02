<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - LPK Sahabat Jepang Indonesia</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Zen+Maru+Gothic:wght@500;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        japan: {
                            50: '#FEF2F2',
                            100: '#FEE2E2',
                            600: '#DC2626',
                            700: '#B91C1C',
                            800: '#991B1B',
                            900: '#7F1D1D',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        japanese: ['"Zen Maru Gothic"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-950 to-japan-950 text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-red-600/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-red-600/15 blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        
        <!-- Logo & Header Card -->
        <div class="text-center mb-8 space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black text-2xl mx-auto shadow-xl shadow-red-600/30 ring-4 ring-white/10">
                友
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Admin Portal</h1>
            <p class="text-xs text-slate-400 font-medium">LPK Sahabat Jepang Indonesia (SJI)</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white text-slate-800 rounded-3xl p-8 sm:p-10 shadow-2xl border border-white/20 relative">
            
            <div class="mb-6">
                <h2 class="text-lg font-extrabold text-slate-900">Masuk ke Akun Admin</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola leads pendaftar & konten website</p>
            </div>

            @if(session('success'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold space-y-1">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-red-600 flex-shrink-0"></i>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Email Administrator</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', 'admin@sahabatjepangindonesia.com') }}" 
                            required 
                            placeholder="admin@sahabatjepangindonesia.com"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 focus:ring-2 focus:ring-red-500/20"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi (Password)</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="password" 
                            name="password" 
                            value="admin123" 
                            required 
                            placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 focus:ring-2 focus:ring-red-500/20"
                        >
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-japan-600 focus:ring-red-500" checked>
                        <span class="text-slate-600 font-medium">Ingat Sesi Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-3">
                    <button 
                        type="submit" 
                        class="w-full py-3.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-bold text-sm shadow-lg shadow-red-600/30 transition flex items-center justify-center gap-2"
                    >
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Masuk ke Dashboard</span>
                    </button>
                </div>

            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-japan-600 font-semibold inline-flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke Website Utama</span>
                </a>
            </div>

        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
