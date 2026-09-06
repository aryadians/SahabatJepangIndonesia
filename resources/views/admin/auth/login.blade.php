<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Login Admin & Sensei - LPK Sahabat Jepang Indonesia</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='48' fill='%23DC2626'/><circle cx='50' cy='50' r='38' fill='white'/><text x='50' y='66' font-size='46' font-weight='900' font-family='sans-serif' text-anchor='middle' fill='%23DC2626'>友</text></svg>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
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
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                            950: '#450a0a',
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
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(2deg); }
        }
        .animate-floating {
            animation: float 5s ease-in-out infinite;
        }
        .bg-grid-pattern {
            background-size: 32px 32px;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-10 relative overflow-hidden font-sans">
    
    <!-- 3D Sakura Canvas Animation Background -->
    <canvas id="loginCanvas" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

    <!-- Japanese Ambient Glow Lights -->
    <div class="absolute -top-32 -left-32 w-[35rem] h-[35rem] rounded-full bg-red-600/20 blur-[130px] pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-[35rem] h-[35rem] rounded-full bg-rose-600/15 blur-[130px] pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[45rem] h-[45rem] rounded-full bg-indigo-900/10 blur-[150px] pointer-events-none"></div>

    <!-- Main Split-Screen Luxury Login Card Container -->
    <div class="w-full max-w-4xl bg-white/95 backdrop-blur-2xl rounded-3xl sm:rounded-[2.5rem] shadow-2xl shadow-red-950/50 border border-white/50 overflow-hidden grid grid-cols-1 lg:grid-cols-12 relative z-10 my-4">
        
        <!-- LEFT SIDE: Japanese Cultural Showcase & Credentials HUD (5 Cols on LG) -->
        <div class="lg:col-span-5 bg-gradient-to-br from-slate-950 via-slate-900 to-japan-950 text-white p-7 sm:p-9 flex flex-col justify-between relative overflow-hidden border-b lg:border-b-0 lg:border-r border-slate-800">
            
            <!-- Grid Pattern Overlay -->
            <div class="absolute inset-0 bg-grid-pattern opacity-60 pointer-events-none"></div>
            
            <!-- Watermark Kanji Background -->
            <div class="absolute -right-6 -bottom-10 font-japanese font-black text-9xl text-white/[0.03] select-none pointer-events-none leading-none">
                友好
            </div>

            <!-- Top Header & Crest -->
            <div class="relative z-10 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-japan-700 via-japan-600 to-rose-500 text-white flex items-center justify-center font-japanese font-black text-xl shadow-lg shadow-red-600/40 ring-4 ring-white/10 animate-floating flex-shrink-0">
                        友
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-red-400 block font-japanese">
                            送出機関 • SO KEMENAKER RI
                        </span>
                        <h2 class="text-base sm:text-lg font-black tracking-tight text-white leading-tight">
                            LPK SAHABAT JEPANG
                        </h2>
                    </div>
                </div>

                <p class="text-xs text-slate-300 leading-relaxed font-medium">
                    Pusat kendali operasional, pemantauan kesiswaan, jadwal interview kaisha, dan tata kelola keuangan resmi.
                </p>

                <!-- Dual Operational Live Clocks: Jakarta (WIB) & Tokyo (JST) -->
                <div class="p-3 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md space-y-2">
                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-400">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-japan-400"></i>
                            <span>Jam Operasional</span>
                        </span>
                        <span class="text-[9px] px-1.5 py-0.2 rounded bg-emerald-500/20 text-emerald-300 font-mono">Live Synchronized</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-xs font-mono">
                        <!-- Jakarta -->
                        <div class="p-2 rounded-xl bg-slate-900/70 border border-white/5">
                            <div class="flex items-center justify-between text-[10px] text-slate-400 font-sans">
                                <span>🇮🇩 JKT (WIB)</span>
                            </div>
                            <div class="text-sm font-black text-white mt-0.5 tracking-tight" id="clockWibSide">--:--:--</div>
                        </div>

                        <!-- Tokyo -->
                        <div class="p-2 rounded-xl bg-slate-900/70 border border-white/5">
                            <div class="flex items-center justify-between text-[10px] text-red-300 font-sans">
                                <span>🇯🇵 TYO (JST)</span>
                                <span class="text-[8px] px-1 rounded bg-red-500/20 text-red-300 font-extrabold">+2h</span>
                            </div>
                            <div class="text-sm font-black text-red-300 mt-0.5 tracking-tight" id="clockJstSide">--:--:--</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Badges & Legal Seal -->
            <div class="relative z-10 pt-6 mt-6 border-t border-white/10 space-y-2.5">
                <div class="flex items-center gap-2 text-[11px] text-slate-300">
                    <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="font-medium">Izin SO: <strong>KEP.224/LATTAS/XII/2023</strong></span>
                </div>
                <div class="flex items-center gap-2 text-[11px] text-slate-300">
                    <div class="w-5 h-5 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="font-medium">Enkripsi Sesi: <strong>TLS 1.3 / SSL 256-Bit</strong></span>
                </div>
                <div class="pt-1 text-[10px] text-slate-400 font-japanese italic">
                    「一期一会 • 初心を忘るべからず」
                </div>
            </div>

        </div>

        <!-- RIGHT SIDE: Polished Form Container (7 Cols on LG) -->
        <div class="lg:col-span-7 p-7 sm:p-10 flex flex-col justify-between bg-white text-slate-800">
            
            <div>
                <!-- Form Header -->
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                            Masuk ke Dashboard
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5 font-medium">
                            Pilih role instan atau ketik kredensial resmi Anda
                        </p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-red-50 text-japan-700 font-extrabold text-[10px] border border-red-200">
                        v2.6 Secure
                    </span>
                </div>

                <!-- Role Shortcut Switcher (Pill Selector) -->
                <div class="mb-5 p-1.5 rounded-2xl bg-slate-100 border border-slate-200 grid grid-cols-3 gap-1 text-xs font-bold">
                    <button 
                        type="button" 
                        onclick="fillCredentials('admin@sahabatjepangindonesia.com', 'admin123', 'admin')" 
                        id="btnRoleAdmin" 
                        class="py-2 px-2 rounded-xl bg-white text-slate-900 shadow-sm flex items-center justify-center gap-1.5 transition text-[11px] font-black border border-slate-200/80"
                    >
                        <i data-lucide="shield" class="w-3.5 h-3.5 text-japan-600"></i>
                        <span class="truncate">Admin</span>
                    </button>
                    
                    <button 
                        type="button" 
                        onclick="fillCredentials('sensei@sahabatjepangindonesia.com', 'admin123', 'sensei')" 
                        id="btnRoleSensei" 
                        class="py-2 px-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-white/60 flex items-center justify-center gap-1.5 transition text-[11px] font-bold"
                    >
                        <i data-lucide="user-check" class="w-3.5 h-3.5 text-blue-600"></i>
                        <span class="truncate">Yamada</span>
                    </button>

                    <button 
                        type="button" 
                        onclick="fillCredentials('sensei2@sahabatjepangindonesia.com', 'admin123', 'sensei2')" 
                        id="btnRoleSensei2" 
                        class="py-2 px-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-white/60 flex items-center justify-center gap-1.5 transition text-[11px] font-bold"
                    >
                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span class="truncate">Dewi (N2)</span>
                    </button>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-4 p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-xs">
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold text-base">&times;</button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1 shadow-xs">
                        @foreach($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 flex-shrink-0"></i>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4" id="loginForm">
                    @csrf

                    <!-- Email Input -->
                    <div class="space-y-1.5">
                        <label for="loginEmail" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            Email Akun Terdaftar
                        </label>
                        <div class="relative group">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-japan-600 transition">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <input 
                                type="email" 
                                id="loginEmail"
                                name="email" 
                                value="{{ old('email', 'admin@sahabatjepangindonesia.com') }}" 
                                required 
                                placeholder="nama@sahabatjepangindonesia.com"
                                class="w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-200 text-xs font-bold text-slate-900 bg-slate-50/70 focus:bg-white focus:outline-none focus:ring-2 focus:ring-japan-500/20 focus:border-japan-600 transition shadow-xs"
                            >
                        </div>
                    </div>

                    <!-- Password Input with Show/Hide Toggle -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="loginPassword" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                                Kata Sandi (Password)
                            </label>
                            <a href="{{ route('admin.password.request') }}" class="text-[11px] font-bold text-japan-600 hover:text-japan-700 hover:underline transition">
                                Lupa Password?
                            </a>
                        </div>
                        <div class="relative group">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-japan-600 transition">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </div>
                            <input 
                                type="password" 
                                id="loginPassword"
                                name="password" 
                                value="admin123" 
                                required 
                                placeholder="••••••••"
                                class="w-full pl-10 pr-11 py-3 rounded-2xl border border-slate-200 text-xs font-bold text-slate-900 bg-slate-50/70 focus:bg-white focus:outline-none focus:ring-2 focus:ring-japan-500/20 focus:border-japan-600 transition shadow-xs"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('loginPassword', 'eyeIcon')" 
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 p-1 focus:outline-none transition"
                                title="Tampilkan / Sembunyikan Kata Sandi"
                            >
                                <i id="eyeIcon" data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me Option -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-japan-600 focus:ring-japan-500 border-slate-300" checked>
                            <span class="text-slate-600 font-bold text-[11px]">Ingat Sesi Login (30 Hari)</span>
                        </label>
                        <span class="text-[10px] text-slate-400 font-mono">Anti-Brute Force On</span>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            id="submitBtn"
                            class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-japan-600 via-red-600 to-rose-700 hover:from-japan-700 hover:to-rose-800 text-white font-extrabold text-xs sm:text-sm shadow-lg shadow-red-600/30 hover:shadow-xl hover:shadow-red-600/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 group cursor-pointer"
                        >
                            <span>Masuk ke Dashboard Admin</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>

                </form>
            </div>

            <!-- Footer Links -->
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-japan-600 font-bold inline-flex items-center gap-1.5 transition group">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5 group-hover:-translate-x-1 transition-transform"></i>
                    <span>Kembali ke Website Utama</span>
                </a>
                <span class="font-japanese text-[11px] text-slate-300 font-bold">友好日本インドネシア</span>
            </div>

        </div>

    </div>

    <!-- Scripts & Sakura Simulation Engine -->
    <script>
        // Real-Time Clocks for Sidebar
        function updateSideClocks() {
            const elWib = document.getElementById('clockWibSide');
            const elJst = document.getElementById('clockJstSide');
            const now = new Date();
            const format = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            
            if (elWib) {
                try {
                    elWib.textContent = now.toLocaleTimeString('id-ID', { ...format, timeZone: 'Asia/Jakarta' });
                } catch(e) {
                    elWib.textContent = now.toLocaleTimeString();
                }
            }
            if (elJst) {
                try {
                    elJst.textContent = now.toLocaleTimeString('ja-JP', { ...format, timeZone: 'Asia/Tokyo' });
                } catch(e) {
                    elJst.textContent = now.toLocaleTimeString();
                }
            }
        }
        updateSideClocks();
        setInterval(updateSideClocks, 1000);

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
            const btnSensei2 = document.getElementById('btnRoleSensei2');

            // Reset all
            [btnAdmin, btnSensei, btnSensei2].forEach(btn => {
                if (btn) {
                    btn.className = 'py-2 px-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-white/60 flex items-center justify-center gap-1.5 transition text-[11px] font-bold';
                }
            });

            // Set active
            const activeClasses = 'py-2 px-2 rounded-xl bg-white text-slate-900 shadow-sm flex items-center justify-center gap-1.5 transition text-[11px] font-black border border-slate-200/80';
            if (role === 'admin' && btnAdmin) {
                btnAdmin.className = activeClasses;
            } else if (role === 'sensei' && btnSensei) {
                btnSensei.className = activeClasses;
            } else if (role === 'sensei2' && btnSensei2) {
                btnSensei2.className = activeClasses;
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

            const petalCount = 35;
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
                    this.speedY = Math.random() * 1.2 + 0.7;
                    this.rotation = Math.random() * 360;
                    this.rotationSpeed = Math.random() * 2 - 1;
                    this.opacity = Math.random() * 0.45 + 0.25;
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
