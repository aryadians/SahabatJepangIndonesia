<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Login Admin & Pengajar - LPK Sahabat Jepang Indonesia</title>
    
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
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-floating {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden font-sans select-none">
    
    <!-- 3D Sakura Canvas Animation Background -->
    <canvas id="loginCanvas" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

    <!-- Japanese Pattern Accents & Radial Glow -->
    <div class="absolute -top-40 -left-40 w-[30rem] h-[30rem] rounded-full bg-red-600/20 blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-[30rem] h-[30rem] rounded-full bg-rose-600/15 blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 my-8">
        
        <!-- Header Brand Badge -->
        <div class="text-center mb-6 space-y-2">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-japan-700 via-japan-600 to-rose-500 text-white flex items-center justify-center font-japanese font-black text-2xl mx-auto shadow-2xl shadow-red-600/50 ring-4 ring-white/10 animate-floating">
                友
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                LPK SAHABAT JEPANG
            </h1>
            <p class="text-xs text-red-300/80 font-bold font-japanese tracking-wide">
                友好日本インドネシア • Portal Admin & Pengajar
            </p>
        </div>

        <!-- Glassmorphism Login Card -->
        <div class="glass-card text-slate-800 rounded-3xl p-7 sm:p-9 shadow-2xl border border-white/40 relative">
            
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-slate-900 tracking-tight">Masuk ke Sistem</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Pilih role atau masukkan kredensial akun Anda</p>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-red-50 text-japan-700 font-bold text-[10px] border border-red-100">
                    Keamanan SSL
                </span>
            </div>

            <!-- Quick Demo Credentials Switcher -->
            <div class="mb-5 p-2 rounded-2xl bg-slate-100/90 border border-slate-200/80 grid grid-cols-2 gap-1.5 text-xs font-bold">
                <button 
                    type="button" 
                    onclick="fillCredentials('admin@sahabatjepangindonesia.com', 'admin123', 'admin')" 
                    id="btnRoleAdmin" 
                    class="py-1.5 px-2.5 rounded-xl bg-white text-slate-900 shadow-sm flex items-center justify-center gap-1.5 transition text-[11px]"
                >
                    <i data-lucide="shield" class="w-3.5 h-3.5 text-japan-600"></i>
                    <span>Administrator</span>
                </button>
                <button 
                    type="button" 
                    onclick="fillCredentials('sensei@sahabatjepangindonesia.com', 'admin123', 'sensei')" 
                    id="btnRoleSensei" 
                    class="py-1.5 px-2.5 rounded-xl text-slate-600 hover:text-slate-900 flex items-center justify-center gap-1.5 transition text-[11px]"
                >
                    <i data-lucide="user-check" class="w-3.5 h-3.5 text-blue-600"></i>
                    <span>Sensei / Guru</span>
                </button>
            </div>

            <!-- Alerts & Flash Messages -->
            @if(session('success'))
                <div class="mb-4 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-sm animate-pulse">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold text-base">&times;</button>
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

            <!-- Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Alamat Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="email" 
                            id="loginEmail"
                            name="email" 
                            value="{{ old('email', 'admin@sahabatjepangindonesia.com') }}" 
                            required 
                            placeholder="nama@sahabatjepangindonesia.com"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600 transition"
                        >
                    </div>
                </div>

                <!-- Password Input with Show/Hide Eye Toggle -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                        <a href="{{ route('admin.password.request') }}" class="text-[11px] font-bold text-japan-600 hover:underline">
                            Lupa Password?
                        </a>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="password" 
                            id="loginPassword"
                            name="password" 
                            value="admin123" 
                            required 
                            placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 bg-slate-50 focus:bg-white focus:outline-none focus:border-japan-600 transition"
                        >
                        <!-- Eye Show / Hide Toggle Button -->
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility('loginPassword', 'eyeIcon')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 p-1 focus:outline-none"
                            title="Tampilkan / Sembunyikan Kata Sandi"
                        >
                            <i id="eyeIcon" data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs pt-0.5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-japan-600 focus:ring-red-500" checked>
                        <span class="text-slate-600 font-semibold text-[11px]">Ingat Sesi Login</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-japan-600 via-red-600 to-rose-700 hover:from-japan-700 hover:to-rose-800 text-white font-extrabold text-xs sm:text-sm shadow-xl shadow-red-600/30 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Masuk ke Dashboard</span>
                    </button>
                </div>

            </form>

            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-japan-600 font-bold inline-flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke Beranda</span>
                </a>
                <span class="font-japanese text-[10px]">友好日本</span>
            </div>

        </div>

    </div>

    <!-- 3D Sakura Canvas JavaScript -->
    <script>
        // Toggle Password Show/Hide
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

        // Quick Role Switcher
        function fillCredentials(email, pwd, role) {
            document.getElementById('loginEmail').value = email;
            document.getElementById('loginPassword').value = pwd;

            const btnAdmin = document.getElementById('btnRoleAdmin');
            const btnSensei = document.getElementById('btnRoleSensei');

            if (role === 'admin') {
                btnAdmin.className = 'py-1.5 px-2.5 rounded-xl bg-white text-slate-900 shadow-sm flex items-center justify-center gap-1.5 transition text-[11px]';
                btnSensei.className = 'py-1.5 px-2.5 rounded-xl text-slate-600 hover:text-slate-900 flex items-center justify-center gap-1.5 transition text-[11px]';
            } else {
                btnSensei.className = 'py-1.5 px-2.5 rounded-xl bg-white text-slate-900 shadow-sm flex items-center justify-center gap-1.5 transition text-[11px]';
                btnAdmin.className = 'py-1.5 px-2.5 rounded-xl text-slate-600 hover:text-slate-900 flex items-center justify-center gap-1.5 transition text-[11px]';
            }
        }

        // Sakura Canvas Simulation
        (function initCanvas() {
            const canvas = document.getElementById('loginCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let width = (canvas.width = window.innerWidth);
            let height = (canvas.height = window.innerHeight);

            window.addEventListener('resize', () => {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            });

            const petalCount = 40;
            const petals = [];

            class Petal {
                constructor() {
                    this.reset(true);
                }
                reset(init = false) {
                    this.x = Math.random() * width;
                    this.y = init ? Math.random() * height : -20;
                    this.size = Math.random() * 8 + 6;
                    this.speedX = Math.random() * 1.5 - 0.5;
                    this.speedY = Math.random() * 1.2 + 0.8;
                    this.rotation = Math.random() * 360;
                    this.rotationSpeed = Math.random() * 2 - 1;
                    this.opacity = Math.random() * 0.5 + 0.3;
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    this.rotation += this.rotationSpeed;
                    if (this.y > height + 20 || this.x > width + 20 || this.x < -20) {
                        this.reset();
                    }
                }
                draw() {
                    ctx.save();
                    ctx.translate(this.x, this.y);
                    ctx.rotate((this.rotation * Math.PI) / 180);
                    ctx.globalAlpha = this.opacity;
                    ctx.beginPath();
                    ctx.moveTo(0, 0);
                    ctx.bezierCurveTo(-this.size / 2, -this.size, -this.size, -this.size / 3, 0, this.size);
                    ctx.bezierCurveTo(this.size, -this.size / 3, this.size / 2, -this.size, 0, 0);
                    ctx.fillStyle = '#ff758f';
                    ctx.fill();
                    ctx.restore();
                }
            }

            for (let i = 0; i < petalCount; i++) {
                petals.push(new Petal());
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);
                petals.forEach((p) => {
                    p.update();
                    p.draw();
                });
                requestAnimationFrame(animate);
            }
            animate();
        })();

        lucide.createIcons();
    </script>
</body>
</html>
