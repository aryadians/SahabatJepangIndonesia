<!-- Navigation Bar -->
<header id="mainNavbar" class="sticky top-0 z-40 w-full transition-all duration-300 bg-white/85 backdrop-blur-md border-b border-red-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="relative w-11 h-11 rounded-2xl bg-gradient-to-tr from-japan-700 via-japan-600 to-red-500 flex items-center justify-center text-white shadow-md shadow-red-500/20 group-hover:scale-105 transition-transform duration-300">
                    <!-- Japanese Torii / Mount Fuji Crest Silhouette -->
                    <span class="font-japanese font-black text-xl tracking-tighter">友</span>
                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-white border-2 border-japan-600 flex items-center justify-center">
                        <span class="w-2 h-2 rounded-full bg-japan-600"></span>
                    </span>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-extrabold text-lg sm:text-xl text-slate-900 tracking-tight">SAHABAT JEPANG</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-red-100 text-japan-700 uppercase">LPK & SO</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium flex items-center gap-1">
                        <span class="font-japanese text-[11px] text-japan-600 font-semibold">友好日本インドネシア</span>
                        <span>• Penyalur Resmi RI</span>
                    </p>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-8">
                <a href="#beranda" class="text-sm font-semibold text-slate-700 hover:text-japan-600 transition-colors">Beranda</a>
                <a href="#tentang" class="text-sm font-semibold text-slate-700 hover:text-japan-600 transition-colors">Tentang Kami</a>
                <a href="#program" class="text-sm font-semibold text-slate-700 hover:text-japan-600 transition-colors">Program Karir</a>
                <a href="#kalkulator" class="text-sm font-semibold text-slate-700 hover:text-japan-600 transition-colors">Simulasi Gaji</a>
                <a href="#alur" class="text-sm font-semibold text-slate-700 hover:text-japan-600 transition-colors">Alur Proses</a>
                <a href="#fasilitas" class="text-sm font-semibold text-slate-700 hover:text-japan-600 transition-colors">Fasilitas</a>
                <a href="#testimoni" class="text-sm font-semibold text-slate-700 hover:text-japan-600 transition-colors">Testimoni</a>
                <a href="#faq" class="text-sm font-semibold text-slate-700 hover:text-japan-600 transition-colors">FAQ</a>
            </nav>

            <!-- Actions -->
            <div class="hidden sm:flex items-center gap-3">
                <a href="https://api.whatsapp.com/send?phone=6281234567890&text=Halo%20Admin%20LPK%20Sahabat%20Jepang%20Indonesia,%20saya%20ingin%20tanya%20program%20ke%20Jepang" target="_blank" rel="noopener noreferrer" class="p-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-japan-600 hover:border-japan-300 hover:bg-red-50/50 transition">
                    <i data-lucide="phone-call" class="w-4 h-4"></i>
                </a>
                <button onclick="openModal('consultationModal')" class="btn-red-primary px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Konsultasi Gratis</span>
                </button>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex lg:hidden items-center gap-2">
                <button onclick="openModal('consultationModal')" class="sm:hidden btn-red-primary px-3 py-2 rounded-lg text-xs font-bold">
                    Daftar
                </button>
                <button id="mobileMenuBtn" class="p-2 rounded-xl text-slate-700 hover:bg-red-50 hover:text-japan-600 focus:outline-none transition">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobileMenu" class="hidden lg:hidden py-4 border-t border-red-50 bg-white/95 backdrop-blur-md rounded-b-2xl shadow-xl px-4 space-y-3">
            <a href="#beranda" class="block py-2 text-sm font-semibold text-slate-700 hover:text-japan-600">Beranda</a>
            <a href="#tentang" class="block py-2 text-sm font-semibold text-slate-700 hover:text-japan-600">Tentang Kami & Legalitas</a>
            <a href="#program" class="block py-2 text-sm font-semibold text-slate-700 hover:text-japan-600">Program Karir (SSW & Magang)</a>
            <a href="#kalkulator" class="block py-2 text-sm font-semibold text-slate-700 hover:text-japan-600">Simulasi Gaji & Tabungan</a>
            <a href="#alur" class="block py-2 text-sm font-semibold text-slate-700 hover:text-japan-600">Alur Keberangkatan</a>
            <a href="#fasilitas" class="block py-2 text-sm font-semibold text-slate-700 hover:text-japan-600">Fasilitas & Asrama</a>
            <a href="#testimoni" class="block py-2 text-sm font-semibold text-slate-700 hover:text-japan-600">Testimoni Alumni</a>
            <a href="#faq" class="block py-2 text-sm font-semibold text-slate-700 hover:text-japan-600">Tanya Jawab (FAQ)</a>
            
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                <button onclick="openModal('consultationModal')" class="w-full btn-red-primary py-3 rounded-xl text-sm font-bold flex items-center justify-center gap-2">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                    <span>Daftar Konsultasi Online</span>
                </button>
            </div>
        </div>
    </div>
</header>
