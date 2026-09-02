<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - LPK Sahabat Jepang Indonesia</title>
    
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
            <h1 class="text-2xl font-black text-white tracking-tight">Pemulihan Akun</h1>
            <p class="text-xs text-red-300/80 font-bold">LPK Sahabat Jepang Indonesia</p>
        </div>

        <!-- Card -->
        <div class="glass-card text-slate-800 rounded-3xl p-7 sm:p-9 shadow-2xl border border-white/40 relative">
            
            <div class="mb-5">
                <h2 class="text-lg font-black text-slate-900 tracking-tight">Lupa Kata Sandi?</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Masukkan alamat email terdaftar Anda. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                </p>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mb-5 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs space-y-2 shadow-sm">
                    <div class="flex items-center gap-2 font-bold text-emerald-800">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @if(session('reset_link'))
                        <div class="p-2.5 rounded-xl bg-white border border-emerald-200 text-[11px] space-y-1">
                            <span class="text-slate-500 font-bold block">Tautan Reset Password:</span>
                            <a href="{{ session('reset_link') }}" class="font-mono text-blue-600 hover:underline break-all font-semibold block">
                                {{ session('reset_link') }}
                            </a>
                            <span class="text-[10px] text-emerald-700 font-bold block pt-1">
                                &rarr; Klik tautan di atas untuk langsung mengatur kata sandi baru.
                            </span>
                        </div>
                    @endif
                </div>
            @endif

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

            <form action="{{ route('admin.password.email') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Email Terdaftar</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', 'admin@sahabatjepangindonesia.com') }}" 
                            required 
                            placeholder="nama@sahabatjepangindonesia.com"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600 transition"
                        >
                    </div>
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-extrabold text-xs sm:text-sm shadow-xl shadow-red-600/30 transition flex items-center justify-center gap-2"
                    >
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span>Kirim Link Reset Password</span>
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
        lucide.createIcons();
    </script>
</body>
</html>
