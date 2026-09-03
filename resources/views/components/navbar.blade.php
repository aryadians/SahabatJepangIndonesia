<!-- Navigation Bar Component -->
<header id="mainNavbar" class="sticky top-0 z-40 w-full transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-red-100 shadow-sm">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex items-center justify-between h-20 gap-4 xl:gap-8">
            
            <!-- Brand Logo (Left) -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">
                @if(!empty($settings['site_logo']))
                    <img src="{{ $settings['site_logo'] }}" alt="{{ $settings['site_name'] ?? 'LPK Sahabat Jepang' }}" class="h-10 w-auto object-contain max-w-[140px] rounded-lg">
                @else
                    <div class="w-10 h-10 rounded-2xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black text-xl shadow-md shadow-red-600/20 group-hover:scale-105 transition flex-shrink-0">
                        友
                    </div>
                @endif
                <div class="flex flex-col justify-center">
                    <div class="flex items-center gap-2">
                        <span class="font-black text-sm xl:text-base text-slate-900 tracking-tight leading-none uppercase whitespace-nowrap">
                            {{ $settings['site_name'] ?? 'LPK SAHABAT JEPANG INDONESIA' }}
                        </span>
                        <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-red-100 text-japan-700 border border-red-200 uppercase tracking-wider whitespace-nowrap">
                            LPK & SO
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-400 font-medium flex items-center gap-1.5 mt-1 leading-none whitespace-nowrap">
                        <span class="font-japanese text-xs text-japan-600 font-bold">友好日本</span>
                        <span class="text-slate-300">•</span>
                        <span>{{ $settings['site_tagline'] ?? 'Sending Organization Resmi Kemnaker RI' }}</span>
                    </p>
                </div>
            </a>

            <!-- Desktop Nav Links (Center - Balanced, Clean & Zen) -->
            <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                <a href="{{ route('home') }}#beranda" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 hover:bg-slate-100/70 transition">
                    Beranda
                </a>

                <!-- Dropdown Program Karir -->
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1 px-3 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 group-hover:text-japan-600 group-hover:bg-slate-100/70 transition">
                        <span>Program Karir</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 group-hover:text-japan-600 group-hover:rotate-180 transition-transform duration-200"></i>
                    </button>

                    <div class="absolute left-0 top-full pt-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200 z-50 pointer-events-none group-hover:pointer-events-auto">
                        <div class="w-72 bg-white rounded-2xl shadow-xl border border-slate-200/80 p-2.5 space-y-1 ring-1 ring-black/5">
                            <a href="{{ route('home') }}#program" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-8 h-8 rounded-lg bg-red-100 text-japan-600 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="briefcase" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Tokutei Ginou (SSW)</p>
                                    <p class="text-[10px] text-slate-400">Pekerja berketerampilan spesifik</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#program" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-8 h-8 rounded-lg bg-red-100 text-japan-600 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="wrench" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Ginou Jisshusei (Magang)</p>
                                    <p class="text-[10px] text-slate-400">Praktik kerja resmi 3 tahun</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#program" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-8 h-8 rounded-lg bg-red-100 text-japan-600 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="code" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Engineer & IT Profesional</p>
                                    <p class="text-[10px] text-slate-400">Jalur sarjana & diploma teknik</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#program" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-8 h-8 rounded-lg bg-red-100 text-japan-600 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="languages" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Kursus Bahasa Intensif</p>
                                    <p class="text-[10px] text-slate-400">Persiapan N5, N4, N3</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Dropdown Program Pemerintah & Kemitraan -->
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 group-hover:text-emerald-700 group-hover:bg-emerald-50/70 transition">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Program Pemerintah</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-700 group-hover:rotate-180 transition-transform duration-200"></i>
                    </button>

                    <div class="absolute left-0 top-full pt-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200 z-50 pointer-events-none group-hover:pointer-events-auto">
                        <div class="w-80 bg-white rounded-2xl shadow-xl border border-emerald-100 p-2.5 space-y-1 ring-1 ring-black/5">
                            <a href="{{ route('home') }}#kemitraan" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 transition">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="award" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>SMILE Project</span>
                                        <span class="px-1.5 py-0.2 rounded bg-emerald-200 text-emerald-900 text-[9px] font-black">100% GRATIS</span>
                                    </p>
                                    <p class="text-[10px] text-slate-400">Beasiswa Kemenkes & Poltekkes Kaigo</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#kemitraan" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-blue-50 text-slate-700 hover:text-blue-800 transition">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>SMK Go Japan</span>
                                        <span class="px-1.5 py-0.2 rounded bg-blue-200 text-blue-900 text-[9px] font-black">VOKASI</span>
                                    </p>
                                    <p class="text-[10px] text-slate-400">Khusus siswa & lulusan SMK</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#kemitraan" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 hover:text-slate-900 transition">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="image" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Galeri Kunjungan & MoU</p>
                                    <p class="text-[10px] text-slate-400">Dokumentasi 4 gelombang keberangkatan</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('home') }}#kalkulator" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 hover:bg-slate-100/70 transition">
                    Simulasi Biaya & Gaji
                </a>

                <a href="{{ route('brochure.index') }}" class="px-3 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 hover:bg-slate-100/70 transition">
                    Unduh Brosur
                </a>

                <!-- Dropdown Lainnya -->
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1 px-3 py-2 rounded-xl text-xs xl:text-sm font-bold text-slate-700 group-hover:text-japan-600 group-hover:bg-slate-100/70 transition">
                        <span>Lainnya</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 group-hover:text-japan-600 group-hover:rotate-180 transition-transform duration-200"></i>
                    </button>

                    <div class="absolute right-0 top-full pt-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200 z-50 pointer-events-none group-hover:pointer-events-auto">
                        <div class="w-72 bg-white rounded-2xl shadow-xl border border-slate-200/80 p-2.5 space-y-1 ring-1 ring-black/5">
                            <a href="{{ route('exam.simulator') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-8 h-8 rounded-lg bg-japan-600 text-white flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="file-check" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Tryout JLPT & JFT CBT</p>
                                    <p class="text-[10px] text-slate-400">Simulasi 100 soal online gratis</p>
                                </div>
                            </a>

                            <a href="{{ route('alumni.map') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-8 h-8 rounded-lg bg-red-100 text-japan-600 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Peta Sebaran Alumni</p>
                                    <p class="text-[10px] text-slate-400">Sebaran di 47 prefektur Jepang</p>
                                </div>
                            </a>

                            <a href="{{ route('student.portal') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 transition">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>Cek Status Siswa</span>
                                        <span class="px-1.5 py-0.2 rounded bg-emerald-200 text-emerald-900 text-[9px] font-black">Portal</span>
                                    </p>
                                    <p class="text-[10px] text-slate-400">Tracking berkas & kwitansi mandiri</p>
                                </div>
                            </a>

                            <a href="{{ route('articles.index') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="newspaper" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Artikel & Berita</p>
                                    <p class="text-[10px] text-slate-400">Tips dan info seputar Jepang</p>
                                </div>
                            </a>

                            <button type="button" onclick="openModal('quizModal')" class="w-full flex items-center gap-3 p-2.5 rounded-xl hover:bg-amber-50 text-slate-700 hover:text-amber-800 transition text-left">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold flex-shrink-0">
                                    <i data-lucide="compass" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Tes Minat & Karir</p>
                                    <p class="text-[10px] text-slate-400">Cek kecocokan program</p>
                                </div>
                            </button>

                            <div class="my-1 border-t border-slate-100"></div>

                            <a href="{{ route('home') }}#jadwal" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-slate-900 transition text-xs font-semibold">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>Jadwal Angkatan & Kuota</span>
                            </a>

                            <a href="{{ route('home') }}#pengajar" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-slate-900 transition text-xs font-semibold">
                                <i data-lucide="user-check" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>Sensei & Instruktur</span>
                            </a>

                            <a href="{{ route('home') }}#fasilitas" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-slate-900 transition text-xs font-semibold">
                                <i data-lucide="building" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>Fasilitas & Asrama</span>
                            </a>

                            <a href="{{ route('home') }}#faq" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-slate-50 text-slate-600 hover:text-slate-900 transition text-xs font-semibold">
                                <i data-lucide="help-circle" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>Tanya Jawab (FAQ)</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Actions (Right - Clean, Distinct & Professional) -->
            <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                <!-- Portal Staf Link -->
                <a href="{{ route('admin.login') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-japan-600 hover:bg-slate-100 transition" title="Login Staf & Pengajar">
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-400"></i>
                    <span>Portal Staf</span>
                </a>

                <!-- Primary CTA: Konsultasi Gratis -->
                <button type="button" onclick="openModal('consultationModal')" class="btn-red-primary px-4 xl:px-5 py-2.5 rounded-xl text-xs font-extrabold flex items-center gap-2 shadow-md shadow-red-600/20 hover:shadow-red-600/30 transition whitespace-nowrap flex-shrink-0">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-200"></i>
                    <span>Konsultasi Gratis</span>
                </button>

                <!-- Mobile Hamburger Toggle Button -->
                <button 
                    id="mobileMenuBtn" 
                    type="button"
                    class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl text-slate-700 hover:bg-red-50 hover:text-japan-600 border border-slate-200 transition focus:outline-none"
                    aria-label="Toggle navigation menu"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobileMenu" class="hidden lg:hidden py-4 border-t border-slate-100 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl px-4 space-y-1 my-2">
            <a href="{{ route('home') }}#beranda" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="home" class="w-4 h-4 text-japan-600"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('exam.simulator') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-japan-600 bg-red-50/60 hover:bg-red-50 transition">
                <i data-lucide="file-check" class="w-4 h-4 text-japan-600"></i>
                <span>Simulasi Ujian JLPT & JFT (CBT 100 Soal)</span>
            </a>
            <a href="{{ route('brochure.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="book-open" class="w-4 h-4 text-japan-600"></i>
                <span>Brosur Resmi Kurikulum & Biaya Transparan</span>
            </a>
            <a href="{{ route('alumni.map') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="map-pin" class="w-4 h-4 text-japan-600"></i>
                <span>Peta Sebaran Alumni di Jepang</span>
            </a>
            <a href="{{ route('student.portal') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                    <span>Cek Status Siswa & Kwitansi</span>
                </div>
                <span class="px-1.5 py-0.5 rounded bg-emerald-200 text-emerald-900 text-[9px] font-black uppercase">Portal</span>
            </a>
            <a href="{{ route('affiliates.public.register') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-emerald-700 hover:text-emerald-800 hover:bg-emerald-50 transition">
                <i data-lucide="handshake" class="w-4 h-4 text-emerald-600"></i>
                <span>Program Kemitraan SMK & BKK (Afiliasi)</span>
            </a>
            <a href="{{ route('home') }}#program" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="briefcase" class="w-4 h-4 text-japan-600"></i>
                <span>Program Karir (SSW & Magang)</span>
            </a>
            <a href="{{ route('home') }}#kemitraan" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold text-emerald-800 bg-emerald-50/70 hover:bg-emerald-100 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="award" class="w-4 h-4 text-emerald-600"></i>
                    <span>Program Pemerintah (SMILE & SMK)</span>
                </div>
                <span class="px-1.5 py-0.5 rounded bg-emerald-200/80 text-emerald-900 text-[9px] font-black uppercase">100% Gratis</span>
            </a>
            <a href="{{ route('home') }}#jadwal" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="calendar" class="w-4 h-4 text-japan-600"></i>
                <span>Jadwal & Kuota Angkatan Baru</span>
            </a>
            <a href="{{ route('home') }}#kalkulator" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="calculator" class="w-4 h-4 text-japan-600"></i>
                <span>Simulasi Gaji & Tabungan</span>
            </a>
            <a href="{{ route('articles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:text-japan-600 hover:bg-red-50 transition">
                <i data-lucide="newspaper" class="w-4 h-4 text-japan-600"></i>
                <span>Artikel & Berita</span>
            </a>

            <!-- Mobile Action Buttons -->
            <div class="pt-3 border-t border-slate-100 space-y-2">
                <button 
                    type="button" 
                    onclick="triggerPwaInstall(); showPwaBanner();" 
                    class="w-full py-2.5 rounded-xl bg-japan-50 border border-red-200 text-japan-700 text-xs font-black flex items-center justify-center gap-2 shadow-2xs hover:bg-red-100 transition"
                >
                    <i data-lucide="smartphone" class="w-4 h-4 text-japan-600"></i>
                    <span>Pasang Aplikasi di Layar HP (PWA)</span>
                </button>

                <button 
                    type="button" 
                    onclick="openModal('quizModal')" 
                    class="w-full py-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold flex items-center justify-center gap-2 shadow-xs"
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
