<!-- Navigation Bar -->
<header id="mainNavbar" class="sticky top-0 z-40 w-full transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-red-100/80 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4">
            
            <!-- Brand Logo (Left) -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">
                @if(!empty($settings['site_logo']))
                    <img src="{{ $settings['site_logo'] }}" alt="{{ $settings['site_name'] ?? 'LPK Sahabat Jepang' }}" class="h-11 w-auto object-contain max-w-[160px] rounded-lg">
                @else
                    <div class="relative w-11 h-11 rounded-2xl bg-gradient-to-tr from-japan-700 via-japan-600 to-red-500 flex items-center justify-center text-white shadow-md shadow-red-500/25 group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                        <span class="font-japanese font-black text-xl tracking-tighter">友</span>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full bg-white border-2 border-japan-600 flex items-center justify-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-japan-600"></span>
                        </span>
                    </div>
                @endif
                <div class="flex flex-col justify-center">
                    <div class="flex items-center gap-2">
                        <span class="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight leading-none">{{ $settings['site_name'] ?? 'SAHABAT JEPANG' }}</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-extrabold bg-red-100 text-japan-700 tracking-wide">LPK & SO</span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium flex items-center gap-1.5 mt-1 leading-none">
                        <span class="font-japanese text-[11px] text-japan-600 font-bold">友好日本</span>
                        <span class="text-slate-300">•</span>
                        <span>{{ $settings['site_tagline'] ?? 'Penyalur Resmi Kemenaker' }}</span>
                    </p>
                </div>
            </a>

            <!-- Desktop Nav Links (Clean, Focused with Hover Dropdown) -->
            <nav class="hidden lg:flex items-center justify-center gap-1 xl:gap-2 flex-1 max-w-xl mx-2">
                
                <a href="{{ route('home') }}#beranda" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Beranda
                </a>
                
                <a href="{{ route('home') }}#tentang" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Tentang
                </a>
                
                <a href="{{ route('home') }}#program" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Program Karir
                </a>
                
                <a href="{{ route('home') }}#kalkulator" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Simulasi Gaji
                </a>
                
                <a href="{{ route('articles.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition-all">
                    Artikel
                </a>

                <!-- Dropdown Menu "Lainnya" (Hover Activated) -->
                <div class="relative group">
                    <button 
                        type="button" 
                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-700 group-hover:text-japan-600 group-hover:bg-red-50/70 transition-all"
                        aria-expanded="false"
                    >
                        <span>Lainnya</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:text-japan-600 group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>

                    <!-- Dropdown Content Box -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-full pt-2 opacity-0 invisible translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-200 z-50">
                        <div class="w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-red-100 p-2 space-y-1 ring-1 ring-black/5">
                            
                            <!-- Jadwal & Kuota Kelas -->
                            <a 
                                href="{{ route('home') }}#jadwal" 
                                class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition group/item"
                            >
                                <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 group-hover/item:bg-japan-600 group-hover/item:text-white flex items-center justify-center transition">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 group-hover/item:text-japan-700 flex items-center gap-1.5">
                                        <span>Jadwal & Kuota</span>
                                        <span class="px-1.5 py-0.2 rounded bg-japan-100 text-japan-700 text-[9px] font-black">Baru</span>
                                    </p>
                                    <p class="text-[10px] text-slate-400">Jadwal masuk gelombang baru</p>
                                </div>
                            </a>

                            <!-- Alur Proses -->
                            <a 
                                href="{{ route('home') }}#alur" 
                                class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition group/item"
                            >
                                <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 group-hover/item:bg-japan-600 group-hover/item:text-white flex items-center justify-center transition">
                                    <i data-lucide="git-branch" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 group-hover/item:text-japan-700">Alur Keberangkatan</p>
                                    <p class="text-[10px] text-slate-400">Tahapan seleksi s/d terbang</p>
                                </div>
                            </a>

                            <!-- Fasilitas & Asrama -->
                            <a 
                                href="{{ route('home') }}#fasilitas" 
                                class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition group/item"
                            >
                                <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 group-hover/item:bg-japan-600 group-hover/item:text-white flex items-center justify-center transition">
                                    <i data-lucide="building" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 group-hover/item:text-japan-700">Fasilitas & Asrama</p>
                                    <p class="text-[10px] text-slate-400">Galeri sarana & asrama</p>
                                </div>
                            </a>

                            <!-- Testimoni Alumni -->
                            <a 
                                href="{{ route('home') }}#testimoni" 
                                class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition group/item"
                            >
                                <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 group-hover/item:bg-japan-600 group-hover/item:text-white flex items-center justify-center transition">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 group-hover/item:text-japan-700">Testimoni Alumni</p>
                                    <p class="text-[10px] text-slate-400">Kisah sukses di Jepang</p>
                                </div>
                            </a>

                            <!-- Tanya Jawab (FAQ) -->
                            <a 
                                href="{{ route('home') }}#faq" 
                                class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition group/item"
                            >
                                <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 group-hover/item:bg-japan-600 group-hover/item:text-white flex items-center justify-center transition">
                                    <i data-lucide="help-circle" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 group-hover/item:text-japan-700">Tanya Jawab (FAQ)</p>
                                    <p class="text-[10px] text-slate-400">Pertanyaan umum</p>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>

            </nav>

            <!-- Actions (Right) -->
            <div class="flex items-center gap-2.5 sm:gap-3 flex-shrink-0">
                
                <!-- Tes Minat Quiz Button (Desktop) -->
                <button 
                    type="button" 
                    onclick="openModal('quizModal')" 
                    class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs xl:text-sm font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/80 transition"
                    title="Cek program yang cocok untuk Anda"
                >
                    <i data-lucide="compass" class="w-4 h-4 text-amber-600"></i>
                    <span>Tes Minat</span>
                </button>

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
            <a href="{{ route('home') }}#beranda" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="home" class="w-4 h-4 text-japan-600"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('home') }}#tentang" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="shield-check" class="w-4 h-4 text-japan-600"></i>
                <span>Tentang Kami & Legalitas</span>
            </a>
            <a href="{{ route('home') }}#program" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="briefcase" class="w-4 h-4 text-japan-600"></i>
                <span>Program Karir (SSW & Magang)</span>
            </a>
            <a href="{{ route('home') }}#kalkulator" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="calculator" class="w-4 h-4 text-japan-600"></i>
                <span>Simulasi Gaji & Tabungan</span>
            </a>
            <a href="{{ route('articles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="newspaper" class="w-4 h-4 text-japan-600"></i>
                <span>Artikel & Berita</span>
            </a>
            
            <div class="pt-2 pb-1 px-3 text-[10px] font-black text-slate-400 uppercase tracking-wider">
                Informasi Lainnya
            </div>

            <a href="{{ route('home') }}#jadwal" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="calendar" class="w-3.5 h-3.5 text-japan-600"></i>
                <span class="font-bold text-japan-600">Jadwal & Kuota Angkatan Baru</span>
            </a>
            <a href="{{ route('home') }}#alur" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="git-branch" class="w-3.5 h-3.5 text-japan-600"></i>
                <span>Alur Keberangkatan</span>
            </a>
            <a href="{{ route('home') }}#fasilitas" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="building" class="w-3.5 h-3.5 text-japan-600"></i>
                <span>Fasilitas & Asrama</span>
            </a>
            <a href="{{ route('home') }}#testimoni" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="message-square" class="w-3.5 h-3.5 text-japan-600"></i>
                <span>Testimoni Alumni</span>
            </a>
            <a href="{{ route('home') }}#faq" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="help-circle" class="w-3.5 h-3.5 text-japan-600"></i>
                <span>Tanya Jawab (FAQ)</span>
            </a>
            
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                <button 
                    type="button" 
                    onclick="openModal('quizModal')" 
                    class="w-full py-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm font-bold flex items-center justify-center gap-2"
                >
                    <i data-lucide="compass" class="w-4 h-4 text-amber-600"></i>
                    <span>Tes Minat & Kecocokan Program</span>
                </button>
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
