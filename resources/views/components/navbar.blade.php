<!-- Navigation Bar Component -->
<header id="mainNavbar" class="sticky top-0 z-40 w-full transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-red-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-2 xl:gap-3">
            
            <!-- Brand Logo (Left) -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group flex-shrink-0">
                @if(!empty($settings['site_logo']))
                    <img src="{{ $settings['site_logo'] }}" alt="{{ $settings['site_name'] ?? 'LPK Sahabat Jepang' }}" class="h-10 w-auto object-contain max-w-[140px] rounded-lg">
                @else
                    <div class="w-10 h-10 rounded-2xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black text-xl shadow-md shadow-red-600/30 group-hover:scale-105 transition duration-200 flex-shrink-0">
                        友
                    </div>
                @endif
                <div class="flex flex-col justify-center">
                    <div class="flex items-center gap-1.5">
                        <span class="font-black text-xs sm:text-sm xl:text-base text-slate-900 tracking-tight leading-none uppercase">
                            {{ $settings['site_name'] ?? 'SAHABAT JEPANG' }}
                        </span>
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-extrabold bg-red-100 text-japan-700">
                            LPK & SO
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium flex items-center gap-1 mt-1 leading-none">
                        <span class="font-japanese text-[10px] text-japan-600 font-bold">友好日本</span>
                        <span>•</span>
                        <span>{{ $settings['site_tagline'] ?? 'Sending Organization Resmi RI' }}</span>
                    </p>
                </div>
            </a>

            <!-- Desktop Nav Links (Center) -->
            <nav class="hidden lg:flex items-center justify-center gap-0.5 xl:gap-1 flex-1 mx-1">
                <a href="{{ route('home') }}#beranda" class="px-2.5 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition">
                    Beranda
                </a>
                
                <a href="{{ route('home') }}#program" class="px-2.5 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition">
                    Program
                </a>

                <a href="{{ route('exam.simulator') }}" class="px-2.5 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition flex items-center gap-1">
                    <span>Tryout JLPT</span>
                    <span class="px-1 py-0.2 rounded bg-japan-100 text-japan-700 text-[8px] font-black">CBT</span>
                </a>

                <a href="{{ route('alumni.map') }}" class="px-2.5 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition">
                    Peta Alumni
                </a>
                
                <a href="{{ route('home') }}#kalkulator" class="px-2.5 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition">
                    Simulasi Gaji
                </a>
                
                <a href="{{ route('articles.index') }}" class="px-2.5 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50/70 transition">
                    Artikel
                </a>

                <!-- Dropdown Menu "Lainnya" -->
                <div class="relative group">
                    <button 
                        type="button" 
                        class="flex items-center gap-1 px-2.5 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 group-hover:text-japan-600 group-hover:bg-red-50/70 transition"
                    >
                        <span>Lainnya</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 group-hover:text-japan-600 group-hover:rotate-180 transition-transform duration-200"></i>
                    </button>

                    <!-- Dropdown Box -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-full pt-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200 z-50 pointer-events-none group-hover:pointer-events-auto">
                        <div class="w-64 bg-white rounded-2xl shadow-2xl border border-red-100 p-2 space-y-1 ring-1 ring-black/5">
                            
                            <a href="{{ route('home') }}#tentang" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Tentang & Legalitas</p>
                                    <p class="text-[10px] text-slate-400">Akreditasi SO Kemenaker</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#jadwal" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Jadwal & Kuota</p>
                                    <p class="text-[10px] text-slate-400">Pendaftaran angkatan baru</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#pengajar" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center">
                                    <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Sensei & Pengajar</p>
                                    <p class="text-[10px] text-slate-400">Instruktur N1/N2 & Native</p>
                                </div>
                            </a>

                            <a href="{{ route('affiliates.public.register') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <i data-lucide="handshake" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 flex items-center gap-1">
                                        <span>Kemitraan SMK & BKK</span>
                                        <span class="px-1 rounded bg-emerald-100 text-emerald-800 text-[8px] font-black">Komisi</span>
                                    </p>
                                    <p class="text-[10px] text-slate-400">Program Referral Guru BK</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#fasilitas" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center">
                                    <i data-lucide="building" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Fasilitas & Asrama</p>
                                    <p class="text-[10px] text-slate-400">Sarana asrama LPK</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#faq" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center">
                                    <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Tanya Jawab (FAQ)</p>
                                    <p class="text-[10px] text-slate-400">Pertanyaan umum</p>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            </nav>

            <!-- Actions (Right) -->
            <div class="flex items-center gap-1.5 sm:gap-2 flex-shrink-0">
                
                <!-- Tes Minat Quiz Button (Desktop) -->
                <button 
                    type="button" 
                    onclick="openModal('quizModal')" 
                    class="hidden xl:inline-flex items-center gap-1 px-2.5 py-2 rounded-xl text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition"
                    title="Cek program yang cocok untuk Anda"
                >
                    <i data-lucide="compass" class="w-3.5 h-3.5 text-amber-600"></i>
                    <span>Tes Minat</span>
                </button>

                <!-- Portal Staf / Login Admin (Desktop) -->
                <a 
                    href="{{ route('admin.login') }}" 
                    class="hidden sm:inline-flex items-center gap-1 px-2.5 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition"
                    title="Login Portal Staf & Pengajar"
                >
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-japan-600"></i>
                    <span>Portal Staf</span>
                </a>

                <!-- CTA Button -->
                <button 
                    type="button"
                    onclick="openModal('consultationModal')" 
                    class="btn-red-primary px-3 sm:px-4 py-2 rounded-xl text-xs font-extrabold flex items-center justify-center gap-1 shadow-md shadow-red-600/20 whitespace-nowrap"
                >
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-200"></i>
                    <span>Konsultasi Gratis</span>
                </button>

                <!-- Mobile Hamburger Toggle Button -->
                <button 
                    id="mobileMenuBtn" 
                    type="button"
                    class="lg:hidden inline-flex items-center justify-center w-9 h-9 rounded-xl text-slate-700 hover:bg-red-50 hover:text-japan-600 border border-slate-200 transition focus:outline-none"
                    aria-label="Toggle navigation menu"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobileMenu" class="hidden lg:hidden py-4 border-t border-slate-100 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl px-4 space-y-1 my-2">
            <a href="{{ route('home') }}#beranda" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="home" class="w-4 h-4 text-japan-600"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('exam.simulator') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-japan-600 bg-red-50/50 hover:bg-red-50 transition">
                <i data-lucide="file-check" class="w-4 h-4 text-japan-600"></i>
                <span>Simulasi Ujian JLPT & JFT (CBT Gratis)</span>
            </a>
            <a href="{{ route('alumni.map') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="map" class="w-4 h-4 text-japan-600"></i>
                <span>Peta Sebaran Alumni di Jepang</span>
            </a>
            <a href="{{ route('affiliates.public.register') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-emerald-700 hover:text-emerald-800 hover:bg-emerald-50 transition">
                <i data-lucide="handshake" class="w-4 h-4 text-emerald-600"></i>
                <span>Program Kemitraan SMK & BKK (Afiliasi)</span>
            </a>
            <a href="{{ route('home') }}#program" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="briefcase" class="w-4 h-4 text-japan-600"></i>
                <span>Program Karir (SSW & Magang)</span>
            </a>
            <a href="{{ route('home') }}#jadwal" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="calendar" class="w-4 h-4 text-japan-600"></i>
                <span>Jadwal & Kuota Angkatan Baru</span>
            </a>
            <a href="{{ route('home') }}#kalkulator" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="calculator" class="w-4 h-4 text-japan-600"></i>
                <span>Simulasi Gaji & Tabungan</span>
            </a>
            <a href="{{ route('articles.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="newspaper" class="w-4 h-4 text-japan-600"></i>
                <span>Artikel & Berita</span>
            </a>

            <!-- Mobile Action Buttons -->
            <div class="pt-3 border-t border-slate-100 space-y-2">
                <button 
                    type="button" 
                    onclick="openModal('quizModal')" 
                    class="w-full py-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold flex items-center justify-center gap-2"
                >
                    <i data-lucide="compass" class="w-4 h-4 text-amber-600"></i>
                    <span>Tes Minat & Kecocokan Program</span>
                </button>
                
                <a 
                    href="{{ route('admin.login') }}" 
                    class="w-full py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold flex items-center justify-center gap-2 shadow-sm"
                >
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-red-400"></i>
                    <span>Login Portal Staf & Pengajar</span>
                </a>
            </div>
        </div>

    </div>
</header>
