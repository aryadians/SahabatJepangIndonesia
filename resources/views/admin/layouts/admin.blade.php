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
                    <p class="text-[10px] text-red-400 font-semibold font-japanese mt-0.5">Admin Management</p>
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

            <div class="px-3 pt-3 pb-1 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                Sistem & Keamanan
            </div>

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
                <a href="{{ route('admin.profile.index') }}" class="text-right hidden sm:block hover:opacity-80 transition">
                    <p class="text-xs font-bold text-slate-900">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-400">{{ auth()->user()->email ?? 'admin@sahabatjepangindonesia.com' }}</p>
                </a>
                
                <a href="{{ route('admin.profile.index') }}" class="w-9 h-9 rounded-xl bg-red-100 text-japan-700 font-bold flex items-center justify-center text-xs shadow-sm hover:ring-2 hover:ring-red-400 transition">
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
    </script>
</body>
</html>
