<!-- Navigation Bar -->
<header id="mainNavbar" class="sticky top-0 z-40 w-full transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-red-100/80 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4">
            
            <!-- Brand Logo (Left) -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">
                <div class="relative w-11 h-11 rounded-2xl bg-gradient-to-tr from-japan-700 via-japan-600 to-red-500 flex items-center justify-center text-white shadow-md shadow-red-500/25 group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                    <span class="font-japanese font-black text-xl tracking-tighter">友</span>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full bg-white border-2 border-japan-600 flex items-center justify-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-japan-600"></span>
                    </span>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="flex items-center gap-2">
                        <span class="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight leading-none">SAHABAT JEPANG</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-extrabold bg-red-100 text-japan-700 tracking-wide">LPK & SO</span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium flex items-center gap-1.5 mt-1 leading-none">
                        <span class="font-japanese text-[11px] text-japan-600 font-bold">友好日本</span>
                        <span class="text-slate-300">•</span>
                        <span>Penyalur Resmi Kemenaker</span>
                    </p>
                </div>
            </a>

            <!-- Desktop Nav Links (Center) -->
            <nav class="hidden lg:flex items-center justify-center gap-1 xl:gap-2 flex-1 max-w-2xl mx-2">
                <a href="#beranda" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Beranda
                </a>
                <a href="#tentang" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Tentang
                </a>
                <a href="#program" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Program
                </a>
                <a href="#kalkulator" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Simulasi Gaji
                </a>
                <a href="#alur" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Alur Proses
                </a>
                <a href="#fasilitas" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Fasilitas
                </a>
                <a href="#testimoni" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Testimoni
                </a>
                <a href="#faq" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    FAQ
                </a>
            </nav>

            <!-- Actions (Right) -->
            <div class="flex items-center gap-2.5 sm:gap-3 flex-shrink-0">
                
                <!-- Direct WhatsApp Icon Button (Desktop & Tablet) -->
                <a 
                    href="https://api.whatsapp.com/send?phone=6281234567890&text=Halo%20Admin%20LPK%20Sahabat%20Jepang%20Indonesia,%20saya%20ingin%20tanya%20program%20ke%20Jepang" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    class="hidden sm:inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 text-slate-600 hover:text-emerald-600 hover:border-emerald-300 hover:bg-emerald-50/50 transition"
                    title="Hubungi Admin WhatsApp"
                >
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                </a>

                <!-- CTA Button -->
                <button 
                    type="button"
                    onclick="openModal('consultationModal')" 
                    class="btn-red-primary px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-md shadow-red-600/20"
                >
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-200"></i>
                    <span>Konsultasi Gratis</span>
                </button>

                <!-- Mobile Hamburger Toggle Button -->
                <button 
                    id="mobileMenuBtn" 
                    type="button"
                    class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl text-slate-700 hover:bg-red-50 hover:text-japan-600 border border-slate-200/80 transition focus:outline-none"
                    aria-label="Toggle navigation menu"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobileMenu" class="hidden lg:hidden py-4 border-t border-slate-100 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl px-4 space-y-1 my-2">
            <a href="#beranda" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="home" class="w-4 h-4 text-japan-600"></i>
                <span>Beranda</span>
            </a>
            <a href="#tentang" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="shield-check" class="w-4 h-4 text-japan-600"></i>
                <span>Tentang Kami & Legalitas</span>
            </a>
            <a href="#program" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="briefcase" class="w-4 h-4 text-japan-600"></i>
                <span>Program Karir (SSW & Magang)</span>
            </a>
            <a href="#kalkulator" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="calculator" class="w-4 h-4 text-japan-600"></i>
                <span>Simulasi Gaji & Tabungan</span>
            </a>
            <a href="#alur" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="git-branch" class="w-4 h-4 text-japan-600"></i>
                <span>Alur Keberangkatan</span>
            </a>
            <a href="#fasilitas" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="building" class="w-4 h-4 text-japan-600"></i>
                <span>Fasilitas & Asrama</span>
            </a>
            <a href="#testimoni" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="message-square" class="w-4 h-4 text-japan-600"></i>
                <span>Testimoni Alumni</span>
            </a>
            <a href="#faq" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="help-circle" class="w-4 h-4 text-japan-600"></i>
                <span>Tanya Jawab (FAQ)</span>
            </a>
            
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                <button 
                    type="button"
                    onclick="openModal('consultationModal')" 
                    class="w-full btn-red-primary py-3 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-sm"
                >
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Daftar Konsultasi Online</span>
                </button>
            </div>
        </div>
    </div>
</header>
