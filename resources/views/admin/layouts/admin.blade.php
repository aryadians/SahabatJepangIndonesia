<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - LPK Sahabat Jepang Indonesia</title>

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
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex">

    <!-- Mobile Sidebar Backdrop -->
    <div id="adminSidebarBackdrop" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-30 hidden md:hidden" onclick="toggleAdminSidebar(false)"></div>

    <!-- Sidebar Navigation -->
    <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col justify-between min-h-screen transition-transform duration-300 -translate-x-full md:translate-x-0 md:static">
        
        <div>
            <!-- Sidebar Header -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black text-lg shadow-md">
                        友
                    </div>
                    <div>
                        <h2 class="font-extrabold text-white text-sm tracking-tight">LPK SAHABAT JEPANG</h2>
                        <p class="text-[11px] text-red-400 font-semibold font-japanese">Admin CMS & Leads</p>
                    </div>
                </div>

                <!-- Mobile Close Button -->
                <button type="button" onclick="toggleAdminSidebar(false)" class="md:hidden text-slate-400 hover:text-white p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 text-xs font-semibold overflow-y-auto max-h-[calc(100vh-10rem)]">
                
                <div class="px-3 pt-2 pb-1 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                    Utama
                </div>

                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
                >
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>

                <a 
                    href="{{ route('admin.consultations.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.consultations.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
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

                <div class="px-3 pt-4 pb-1 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                    Kelola Konten Web
                </div>

                <a 
                    href="{{ route('admin.settings.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
                >
                    <i data-lucide="sliders" class="w-4 h-4"></i>
                    <span>Pengaturan & Hero</span>
                </a>

                <a 
                    href="{{ route('admin.programs.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.programs.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
                >
                    <i data-lucide="briefcase" class="w-4 h-4"></i>
                    <span>Program Karir</span>
                </a>

                <a 
                    href="{{ route('admin.facilities.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.facilities.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
                >
                    <i data-lucide="building" class="w-4 h-4"></i>
                    <span>Fasilitas & Asrama</span>
                </a>

                <a 
                    href="{{ route('admin.testimonials.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
                >
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                    <span>Testimoni Alumni</span>
                </a>

                <a 
                    href="{{ route('admin.faqs.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.faqs.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
                >
                    <i data-lucide="help-circle" class="w-4 h-4"></i>
                    <span>Tanya Jawab (FAQ)</span>
                </a>

                <a 
                    href="{{ route('admin.partners.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.partners.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
                >
                    <i data-lucide="handshake" class="w-4 h-4"></i>
                    <span>Mitra Kaisha</span>
                </a>

                <a 
                    href="{{ route('admin.articles.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.articles.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
                >
                    <i data-lucide="newspaper" class="w-4 h-4"></i>
                    <span>Artikel & Berita</span>
                </a>

                <div class="px-3 pt-4 pb-1 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                    Sistem & Keamanan
                </div>

                <a 
                    href="{{ route('admin.profile.index') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.profile.*') ? 'bg-japan-600 text-white font-bold shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}"
                >
                    <i data-lucide="user-cog" class="w-4 h-4"></i>
                    <span>Profil & Kata Sandi</span>
                </a>

            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800">
            <a 
                href="{{ route('home') }}" 
                target="_blank" 
                class="flex items-center justify-between px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition mb-3"
            >
                <span class="flex items-center gap-2">
                    <i data-lucide="external-link" class="w-4 h-4 text-red-400"></i>
                    <span>Lihat Website</span>
                </span>
                <i data-lucide="arrow-up-right" class="w-3.5 h-3.5 text-slate-500"></i>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-rose-400 hover:bg-rose-500/10 text-xs font-bold transition">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div class="flex items-center gap-3">
                <button 
                    type="button" 
                    onclick="toggleAdminSidebar(true)" 
                    class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-japan-600 transition"
                    aria-label="Toggle sidebar menu"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <span class="font-bold text-slate-800 text-base sm:text-lg truncate">@yield('page_title', 'Admin Panel')</span>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.profile.index') }}" class="text-right hidden sm:block hover:opacity-80 transition">
                    <p class="text-xs font-bold text-slate-900">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[11px] text-slate-400">{{ auth()->user()->email ?? 'admin@sahabatjepangindonesia.com' }}</p>
                </a>
                
                <a href="{{ route('admin.profile.index') }}" class="w-10 h-10 rounded-xl bg-red-100 text-japan-700 font-bold flex items-center justify-center text-sm shadow-sm hover:ring-2 hover:ring-red-400 transition">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </a>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-4 sm:p-8 flex-1 space-y-6">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold text-lg">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold space-y-1 shadow-sm">
                    @foreach($errors->all() as $err)
                        <div class="flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600 flex-shrink-0"></i>
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
    </script>
</body>
</html>
