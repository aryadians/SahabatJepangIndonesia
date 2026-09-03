<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - LPK Sahabat Jepang Indonesia</title>

    <!-- Favicon (SVG Torii / Kanji Japanese Emblem) -->
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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        /* Smooth, ultra-thin custom scrollbar for admin sidebar */
        .custom-sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(225, 29, 72, 0.4) rgba(15, 23, 42, 0.4);
        }
        .custom-sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .custom-sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.5);
        }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(225, 29, 72, 0.4);
            border-radius: 9999px;
        }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(225, 29, 72, 0.8);
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased h-full overflow-hidden flex">

    <!-- Mobile Sidebar Backdrop -->
    <div id="adminSidebarBackdrop" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-30 hidden md:hidden" onclick="toggleAdminSidebar(false)"></div>

    <!-- Sidebar Navigation (Fixed Full-Height App Shell) -->
    <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col h-full transition-transform duration-300 -translate-x-full md:translate-x-0 md:static border-r border-slate-800 select-none">
        
        <!-- Sidebar Header (Fixed at top) -->
        <div class="h-16 flex-shrink-0 flex items-center justify-between px-5 border-b border-slate-800 bg-slate-950/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black text-base shadow-md">
                    友
                </div>
                <div>
                    <h2 class="font-black text-white text-xs tracking-tight uppercase leading-none">LPK SAHABAT JEPANG</h2>
                    <p class="text-[10px] text-red-400 font-semibold font-japanese mt-0.5">
                        {{ auth()->user()->role === 'teacher' ? 'Portal Pengajar / Sensei' : 'Admin Management' }}
                    </p>
                </div>
            </div>

            <!-- Mobile Close Button -->
            <button type="button" onclick="toggleAdminSidebar(false)" class="md:hidden text-slate-400 hover:text-white p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Navigation Links (Scrollable area) -->
        <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-1 text-xs font-semibold custom-sidebar-scroll">
            
            <div class="px-3 pt-2 pb-1 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                Utama
            </div>

            <a 
                href="{{ route('admin.dashboard') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>Dashboard</span>
            </a>

            <a 
                href="{{ route('admin.consultations.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.consultations.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Leads Pendaftar</span>
                @php
                    $pendingCount = \App\Models\Consultation::where('status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto px-2 py-0.5 rounded-full bg-amber-500 text-slate-950 font-black text-[10px]">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            <div class="px-3 pt-3 pb-1 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                Akademik & Siswa
            </div>

            <a 
                href="{{ route('admin.students.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.students.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                <span>Data Diri Siswa & Biaya</span>
            </a>

            <a 
                href="{{ route('admin.interviews.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.interviews.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="video" class="w-4 h-4"></i>
                <span>Wawancara Kaisha</span>
                @php
                    $schedCount = \App\Models\JobInterview::where('status', 'scheduled')->count();
                @endphp
                @if($schedCount > 0)
                    <span class="ml-auto px-2 py-0.5 rounded-full bg-blue-500 text-white font-black text-[10px]">
                        {{ $schedCount }}
                    </span>
                @endif
            </a>

            <a 
                href="{{ route('admin.teachers.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.teachers.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="user-check" class="w-4 h-4"></i>
                <span>Data Pengajar (Sensei)</span>
            </a>

            <a 
                href="{{ route('admin.schedules.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.schedules.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>Jadwal Angkatan & Kuota</span>
            </a>

            <div class="px-3 pt-3 pb-1 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                Keuangan & CRM Growth
            </div>

            <a 
                href="{{ route('admin.finance.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.finance.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="trending-up" class="w-4 h-4"></i>
                <span>Proyeksi Kas & Keuangan</span>
            </a>

            <a 
                href="{{ route('admin.whatsapp.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.whatsapp.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="message-square" class="w-4 h-4"></i>
                <span>Otomatisasi WhatsApp</span>
            </a>

            <a 
                href="{{ route('admin.affiliates.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.affiliates.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="handshake" class="w-4 h-4"></i>
                <span>Kemitraan SMK & BKK</span>
            </a>

            @if(auth()->user()->isAdmin())
                <div class="px-3 pt-3 pb-1 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                    Kelola Konten Web
                </div>

                <a 
                    href="{{ route('admin.settings.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
                >
                    <i data-lucide="sliders" class="w-4 h-4"></i>
                    <span>Pengaturan & Hero</span>
                </a>

                <a 
                    href="{{ route('admin.programs.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.programs.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
                >
                    <i data-lucide="briefcase" class="w-4 h-4"></i>
                    <span>Program Karir</span>
                </a>

                <a 
                    href="{{ route('admin.facilities.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.facilities.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
                >
                    <i data-lucide="building" class="w-4 h-4"></i>
                    <span>Fasilitas & Asrama</span>
                </a>

                <a 
                    href="{{ route('admin.testimonials.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
                >
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                    <span>Testimoni Alumni</span>
                </a>

                <a 
                    href="{{ route('admin.faqs.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.faqs.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
                >
                    <i data-lucide="help-circle" class="w-4 h-4"></i>
                    <span>Tanya Jawab (FAQ)</span>
                </a>

                <a 
                    href="{{ route('admin.partners.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.partners.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
                >
                    <i data-lucide="handshake" class="w-4 h-4"></i>
                    <span>Mitra Kaisha</span>
                </a>

                <a 
                    href="{{ route('admin.articles.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.articles.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
                >
                    <i data-lucide="newspaper" class="w-4 h-4"></i>
                    <span>Artikel & Berita</span>
                </a>
            @endif

            <div class="px-3 pt-3 pb-1 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                Sistem & Keamanan
            </div>

            @if(auth()->user()->isAdmin())
                <a 
                    href="{{ route('admin.users.index') }}" 
                    class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
                >
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>Manajemen Pengguna (RBAC)</span>
                </a>
            @endif

            <a 
                href="{{ route('admin.profile.index') }}" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition {{ request()->routeIs('admin.profile.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}"
            >
                <i data-lucide="user-cog" class="w-4 h-4"></i>
                <span>Profil & Kata Sandi</span>
            </a>

        </nav>

        <!-- Sidebar Footer (Fixed at bottom) -->
        <div class="flex-shrink-0 p-3 border-t border-slate-800 bg-slate-950/80">
            <a 
                href="{{ route('home') }}" 
                target="_blank" 
                class="flex items-center justify-between px-3 py-2 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-300 text-xs font-bold transition mb-1.5"
            >
                <span class="flex items-center gap-2">
                    <i data-lucide="external-link" class="w-3.5 h-3.5 text-red-400"></i>
                    <span>Lihat Website</span>
                </span>
                <i data-lucide="arrow-up-right" class="w-3 h-3 text-slate-500"></i>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-1.5 rounded-xl text-rose-400 hover:bg-rose-500/10 text-xs font-bold transition">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content Area (Scrolls independently while Sidebar remains 100% fixed) -->
    <div class="flex-1 flex flex-col h-full overflow-y-auto min-w-0 bg-slate-100">
        
        <!-- Topbar (Fixed at top of right pane) -->
        <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-20 shadow-sm flex-shrink-0">
            <div class="flex items-center gap-3">
                <button 
                    type="button" 
                    onclick="toggleAdminSidebar(true)" 
                    class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-japan-600 transition"
                    aria-label="Toggle sidebar menu"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <span class="font-bold text-slate-800 text-base truncate">@yield('page_title', 'Admin Panel')</span>
            </div>

            <div class="flex items-center gap-3">
                <!-- Real-Time Sync Indicator -->
                <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/80 text-[11px] font-bold text-emerald-700 shadow-xs" title="Sistem tersinkronisasi langsung dengan pendaftaran guest">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="tracking-tight">Live Sync Aktif</span>
                </div>

                <!-- Live Notification Bell Dropdown -->
                <div class="relative" id="realtimeNotificationWrapper">
                    <button 
                        type="button" 
                        id="notifBellBtn" 
                        onclick="toggleNotificationDropdown()" 
                        class="relative p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition"
                        title="Notifikasi Pendaftaran Siswa & Leads Baru"
                    >
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span 
                            id="notifBadge" 
                            class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 bg-red-600 text-white rounded-full text-[10px] font-black flex items-center justify-center shadow-md hidden"
                        >
                            0
                        </span>
                    </button>

                    <!-- Notification Dropdown Menu -->
                    <div 
                        id="notifDropdown" 
                        class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden z-50 hidden"
                    >
                        <div class="p-3.5 bg-slate-900 text-white flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i data-lucide="bell-ring" class="w-4 h-4 text-japan-400"></i>
                                <span class="text-xs font-bold">Pendaftaran Masuk (Live)</span>
                            </div>
                            <span id="notifDropdownBadge" class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-full bg-red-600 text-white">0 Baru</span>
                        </div>

                        <div id="notifList" class="max-h-72 overflow-y-auto divide-y divide-slate-100 p-1 text-xs">
                            <div class="py-8 text-center text-slate-400">
                                <i data-lucide="inbox" class="w-6 h-6 mx-auto mb-1 opacity-50"></i>
                                <p class="text-xs font-semibold">Tidak ada pendaftar baru</p>
                            </div>
                        </div>

                        <div class="p-2.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('admin.consultations.index') }}" class="text-[11px] font-bold text-japan-600 hover:underline flex items-center gap-1">
                                <span>Buka Seluruh Leads</span>
                                <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                            <span id="liveSyncClock" class="text-[10px] font-mono text-slate-400">-</span>
                        </div>
                    </div>
                </div>

                <div class="text-right hidden sm:block">
                    <div class="flex items-center justify-end gap-1.5">
                        <p class="text-xs font-bold text-slate-900">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        @if(auth()->user()->isAdmin())
                            <span class="px-1.5 py-0.2 rounded bg-red-100 text-japan-800 font-extrabold text-[9px]">Admin</span>
                        @elseif(auth()->user()->isTeacher())
                            <span class="px-1.5 py-0.2 rounded bg-blue-100 text-blue-800 font-extrabold text-[9px]">Sensei</span>
                        @else
                            <span class="px-1.5 py-0.2 rounded bg-slate-100 text-slate-700 font-extrabold text-[9px]">Staf</span>
                        @endif
                    </div>
                    <p class="text-[10px] text-slate-400">{{ auth()->user()->email ?? 'admin@sahabatjepangindonesia.com' }}</p>
                </div>
                
                <a href="{{ route('admin.profile.index') }}" class="w-9 h-9 rounded-xl bg-red-100 text-japan-700 font-bold flex items-center justify-center text-xs shadow-sm hover:ring-2 hover:ring-red-400 transition" title="Edit Profil">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </a>
            </div>
        </header>

        <!-- Main Body (Scrolls smoothly without affecting the sidebar) -->
        <main class="p-4 sm:p-6 lg:p-8 flex-1 space-y-6">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold text-lg leading-none">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1 shadow-sm">
                    @foreach($errors->all() as $err)
                        <div class="flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-rose-600 flex-shrink-0"></i>
                            <span>{{ $err }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            @yield('content')

        </main>
    </div>

    <script>
        // Initialize Icons
        lucide.createIcons();

        // Responsive Admin Sidebar Toggle
        function toggleAdminSidebar(open) {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            if (!sidebar || !backdrop) return;

            if (open) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        // Modal Helpers
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('active');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('active');
            }
        }

        // ==========================================
        // REAL-TIME SYNC & NOTIFICATION ENGINE
        // ==========================================
        let lastKnownMaxLeadId = null;
        let isFirstSync = true;

        function toggleNotificationDropdown() {
            const dd = document.getElementById('notifDropdown');
            if (!dd) return;
            dd.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('realtimeNotificationWrapper');
            const dd = document.getElementById('notifDropdown');
            if (wrapper && dd && !wrapper.contains(e.target)) {
                dd.classList.add('hidden');
            }
        });

        // Web Audio API Soft Chime
        function playChimeSound() {
            try {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;
                const ctx = new AudioContext();
                if (ctx.state === 'suspended') {
                    ctx.resume();
                }
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(587.33, ctx.currentTime); // D5
                osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.12); // A5
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.35);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.35);
            } catch(e) {
                // Audio context may be prevented until first user gesture
            }
        }

        // Show Floating Toast
        function showRealTimeToast(lead) {
            const container = document.getElementById('realtimeToastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto bg-slate-900/95 text-white p-4 rounded-2xl shadow-2xl border-2 border-red-500/80 flex items-start gap-3 backdrop-blur-md transform transition-all duration-300 translate-y-4 opacity-0 max-w-sm';
            toast.innerHTML = `
                <div class="w-10 h-10 rounded-xl bg-red-600/20 text-red-400 border border-red-500/40 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <i data-lucide="sparkles" class="w-5 h-5 text-japan-400"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase tracking-wider text-red-400">Pendaftar Baru Masuk!</span>
                        <span class="text-[9px] text-slate-400 font-mono">Baru saja</span>
                    </div>
                    <h5 class="text-xs font-bold text-white truncate mt-0.5">${lead.name}</h5>
                    <p class="text-[11px] text-slate-300 truncate">${lead.program} • ${lead.city || 'Umum'}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <a href="${lead.wa_link}" target="_blank" class="px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] flex items-center gap-1 transition">
                            <i data-lucide="message-circle" class="w-3 h-3"></i>
                            <span>Chat WA</span>
                        </a>
                        <a href="{{ route('admin.consultations.index') }}" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-[10px] transition">
                            Buka Leads
                        </a>
                    </div>
                </div>
                <button onclick="this.closest('.pointer-events-auto').remove()" class="text-slate-400 hover:text-white text-base leading-none p-1">
                    &times;
                </button>
            `;

            container.appendChild(toast);
            if (window.lucide) {
                lucide.createIcons();
            }

            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
            }, 50);

            // Auto dismiss after 8s
            setTimeout(() => {
                toast.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 8000);
        }

        // Fetch Live Sync from Admin API
        function pollAdminSync() {
            fetch('{{ route("admin.realtime.admin") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status !== 'success') return;

                // Update Server Clock
                const clockEl = document.getElementById('liveSyncClock');
                if (clockEl) clockEl.textContent = 'Server: ' + data.server_time;

                // Update Pending Leads Badge
                const count = data.notifications.pending_leads_count;
                const badge = document.getElementById('notifBadge');
                const ddBadge = document.getElementById('notifDropdownBadge');

                if (badge) {
                    if (count > 0) {
                        badge.textContent = count > 99 ? '99+' : count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
                if (ddBadge) ddBadge.textContent = count + ' Baru';

                // Populate Leads List
                const notifList = document.getElementById('notifList');
                if (notifList && data.notifications.latest_leads) {
                    if (data.notifications.latest_leads.length === 0) {
                        notifList.innerHTML = `
                            <div class="py-8 text-center text-slate-400">
                                <i data-lucide="inbox" class="w-6 h-6 mx-auto mb-1 opacity-50"></i>
                                <p class="text-xs font-semibold">Tidak ada pendaftar baru</p>
                            </div>
                        `;
                    } else {
                        notifList.innerHTML = '';
                        data.notifications.latest_leads.forEach(item => {
                            const row = document.createElement('div');
                            row.className = 'p-3 hover:bg-slate-50 transition flex items-start justify-between gap-2.5';
                            row.innerHTML = `
                                <div class="min-w-0">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                        <h6 class="font-bold text-slate-900 text-xs truncate">${item.name}</h6>
                                    </div>
                                    <p class="text-[11px] text-slate-500 truncate">${item.program} (${item.city || '-'})</p>
                                    <span class="text-[9px] text-slate-400 font-mono">${item.created_at_human}</span>
                                </div>
                                <a href="${item.wa_link}" target="_blank" class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold transition flex-shrink-0" title="Chat WhatsApp">
                                    <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                                </a>
                            `;
                            notifList.appendChild(row);
                        });
                    }
                }

                // Global Dashboard KPI Metrics Sync
                window.updateAdminStatsDom(data);

                // Detect New Incoming Lead
                if (!isFirstSync && lastKnownMaxLeadId !== null && data.max_consultation_id > lastKnownMaxLeadId) {
                    playChimeSound();
                    if (data.notifications.latest_leads && data.notifications.latest_leads.length > 0) {
                        showRealTimeToast(data.notifications.latest_leads[0]);
                    }
                    const alertBanner = document.getElementById('newLeadAlertBanner');
                    if (alertBanner) {
                        alertBanner.classList.remove('hidden');
                    }
                }

                lastKnownMaxLeadId = data.max_consultation_id;
                isFirstSync = false;

                if (window.lucide) {
                    lucide.createIcons();
                }
            })
            .catch(err => {
                // Silently wait for next interval
            });
        }

        // Global function to sync all data-admin-stat elements across any admin page
        window.updateAdminStatsDom = function(data) {
            if (!data) return;

            // Leads KPIs
            if (data.leads_kpi) {
                const map = {
                    'leads_total': data.leads_kpi.total,
                    'leads_pending': data.leads_kpi.pending,
                    'leads_contacted': data.leads_kpi.contacted,
                    'leads_registered': data.leads_kpi.registered,
                    'leads_cancelled': data.leads_kpi.cancelled,
                };
                Object.keys(map).forEach(key => {
                    const val = map[key];
                    if (val !== undefined) {
                        document.querySelectorAll(`[data-admin-stat="${key}"]`).forEach(el => {
                            const suffix = el.getAttribute('data-suffix') || '';
                            const prefix = el.getAttribute('data-prefix') || '';
                            el.textContent = prefix + Number(val).toLocaleString('id-ID') + suffix;
                        });
                    }
                });
            }

            // Students KPIs
            if (data.students_kpi) {
                const map = {
                    'students_total': data.students_kpi.total,
                    'students_active': data.students_kpi.active,
                    'students_departed': data.students_kpi.departed,
                };
                Object.keys(map).forEach(key => {
                    const val = map[key];
                    if (val !== undefined) {
                        document.querySelectorAll(`[data-admin-stat="${key}"]`).forEach(el => {
                            const suffix = el.getAttribute('data-suffix') || '';
                            const prefix = el.getAttribute('data-prefix') || '';
                            el.textContent = prefix + Number(val).toLocaleString('id-ID') + suffix;
                        });
                    }
                });
            }

            // Financial KPIs
            if (data.financial_kpi && data.financial_kpi.formatted_receivables) {
                document.querySelectorAll('[data-admin-stat="receivables"]').forEach(el => {
                    el.textContent = data.financial_kpi.formatted_receivables;
                });
            }
        };

        // Start Real-Time Sync Poller
        pollAdminSync();
        setInterval(pollAdminSync, 8000);
    </script>

    <!-- Real-Time Floating Notification Toast Container -->
    <div id="realtimeToastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2.5 max-w-sm pointer-events-none"></div>
</body>
</html>
