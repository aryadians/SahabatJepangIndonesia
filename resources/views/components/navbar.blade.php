<!-- Navigation Bar Component -->
<header id="mainNavbar" class="sticky top-0 z-40 w-full transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-red-100 shadow-sm">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex items-center justify-between h-20 gap-2 sm:gap-4 xl:gap-6">
            
            <!-- Brand Logo (Left) -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group flex-shrink-0">
                @if(!empty($settings['site_logo']))
                    <img src="{{ $settings['site_logo'] }}" alt="{{ $settings['site_name'] ?? 'LPK Sahabat Jepang' }}" class="h-9 sm:h-10 w-auto object-contain max-w-[140px] rounded-lg">
                @else
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-br from-japan-600 to-red-700 text-white flex items-center justify-center font-japanese font-black text-xl sm:text-2xl shadow-md shadow-red-600/30 group-hover:scale-105 group-hover:rotate-3 transition duration-200 flex-shrink-0">
                        友
                    </div>
                @endif
                <div class="flex flex-col justify-center">
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <span class="font-black text-sm sm:text-base xl:text-lg text-slate-900 tracking-tight leading-none uppercase whitespace-nowrap">
                            {{ $settings['site_name'] ?? 'LPK SAHABAT JEPANG INDONESIA' }}
                        </span>
                        <span class="px-1.5 sm:px-2 py-0.5 rounded-full text-[9px] sm:text-[10px] font-black bg-red-100 text-japan-700 border border-red-200 uppercase tracking-wider whitespace-nowrap">
                            LPK & SO
                        </span>
                    </div>
                    <p class="text-[10px] sm:text-[11px] text-slate-500 font-medium flex items-center gap-1 sm:gap-1.5 mt-1 leading-none whitespace-nowrap">
                        <span class="font-japanese text-xs text-japan-600 font-bold">友好日本</span>
                        <span class="text-slate-300">•</span>
                        <span>{{ $settings['site_tagline'] ?? 'Sending Organization Resmi Kemnaker RI' }}</span>
                    </p>
                </div>
            </a>

            <!-- Desktop Nav Links (Center - Balanced & No-Wrap) -->
            <nav class="hidden lg:flex items-center justify-center gap-4 xl:gap-6 flex-1 mx-1 xl:mx-3">
                <a href="{{ route('home') }}#beranda" class="text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 transition whitespace-nowrap py-1">
                    Beranda
                </a>

                <!-- Dropdown Menu "Program & Beasiswa" -->
                <div class="relative group">
                    <button 
                        type="button" 
                        class="flex items-center gap-1.5 text-xs xl:text-sm font-bold text-slate-700 group-hover:text-japan-600 transition whitespace-nowrap py-1"
                    >
                        <span>Program & Beasiswa</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[9px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200 uppercase">Resmi</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 group-hover:text-japan-600 group-hover:rotate-180 transition-transform duration-200"></i>
                    </button>

                    <!-- Mega Dropdown Box (Two Categorized Columns) -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-full pt-3 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200 z-50 pointer-events-none group-hover:pointer-events-auto">
                        <div class="w-[520px] bg-white rounded-3xl shadow-2xl border border-red-100 p-4 ring-1 ring-black/5 grid grid-cols-2 gap-3">
                            
                            <!-- Col 1: Program Pemerintah Unggulan (Beasiswa) -->
                            <div class="space-y-2 p-3.5 rounded-2xl bg-emerald-50/50 border border-emerald-100/80">
                                <div class="flex items-center gap-1.5 text-[10px] font-black text-emerald-800 uppercase tracking-wider pb-1 border-b border-emerald-100">
                                    <i data-lucide="award" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    <span>Program Pemerintah RI</span>
                                </div>

                                <a href="{{ route('home') }}#kemitraan" class="block p-2 rounded-xl hover:bg-white text-slate-800 transition">
                                    <p class="text-xs font-black text-slate-900 flex items-center justify-between">
                                        <span>SMILE Project</span>
                                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[9px] font-black">100% GRATIS</span>
                                    </p>
                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Beasiswa Kemenkes & Poltekkes Kaigo</p>
                                </a>

                                <a href="{{ route('home') }}#kemitraan" class="block p-2 rounded-xl hover:bg-white text-slate-800 transition">
                                    <p class="text-xs font-black text-slate-900 flex items-center justify-between">
                                        <span>SMK Go Japan</span>
                                        <span class="px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 text-[9px] font-black">VOKASI</span>
                                    </p>
                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Khusus siswa & alumni SMK seluruh RI</p>
                                </a>

                                <a href="{{ route('home') }}#kemitraan" class="block p-2 rounded-xl hover:bg-white text-slate-800 transition">
                                    <p class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                        <i data-lucide="image" class="w-3.5 h-3.5 text-emerald-600"></i>
                                        <span>Galeri MoU Kampus</span>
                                    </p>
                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Dokumentasi 4 gelombang keberangkatan</p>
                                </a>
                            </div>

                            <!-- Col 2: Jalur Karir Reguler -->
                            <div class="space-y-2 p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <div class="flex items-center gap-1.5 text-[10px] font-black text-slate-600 uppercase tracking-wider pb-1 border-b border-slate-200/60">
                                    <i data-lucide="briefcase" class="w-3.5 h-3.5 text-japan-600"></i>
                                    <span>Jalur Karir Reguler</span>
                                </div>

                                <a href="{{ route('home') }}#program" class="block p-2 rounded-xl hover:bg-white text-slate-800 transition">
                                    <p class="text-xs font-bold text-slate-900">Tokutei Ginou (SSW)</p>
                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Kaigo, Manufaktur, Makanan & Konstruksi</p>
                                </a>

                                <a href="{{ route('home') }}#program" class="block p-2 rounded-xl hover:bg-white text-slate-800 transition">
                                    <p class="text-xs font-bold text-slate-900">Ginou Jisshusei (Magang)</p>
                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Praktik kerja resmi 3 tahun di Jepang</p>
                                </a>

                                <a href="{{ route('home') }}#program" class="block p-2 rounded-xl hover:bg-white text-slate-800 transition">
                                    <p class="text-xs font-bold text-slate-900">Engineer & Kursus Bahasa</p>
                                    <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Lulusan D3/S1 & intensif N5, N4, N3</p>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                
                <a href="{{ route('home') }}#kalkulator" class="text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 transition whitespace-nowrap py-1">
                    Simulasi Gaji
                </a>
                
                <a href="{{ route('articles.index') }}" class="text-xs xl:text-sm font-bold text-slate-700 hover:text-japan-600 transition whitespace-nowrap py-1">
                    Artikel & Berita
                </a>

                <!-- Dropdown Menu "Lainnya" -->
                <div class="relative group">
                    <button 
                        type="button" 
                        class="flex items-center gap-1.5 text-xs xl:text-sm font-bold text-slate-700 group-hover:text-japan-600 transition whitespace-nowrap py-1"
                    >
                        <span>Lainnya</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 group-hover:text-japan-600 group-hover:rotate-180 transition-transform duration-200"></i>
                    </button>

                    <!-- Dropdown Box -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-full pt-3 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200 z-50 pointer-events-none group-hover:pointer-events-auto">
                        <div class="w-80 bg-white rounded-3xl shadow-2xl border border-red-100 p-3 space-y-1.5 ring-1 ring-black/5">
                            
                            <!-- Tryout JLPT CBT Highlight -->
                            <a href="{{ route('exam.simulator') }}" class="flex items-center gap-3 p-2.5 rounded-2xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition group/item">
                                <div class="w-9 h-9 rounded-xl bg-japan-600 text-white flex items-center justify-center font-bold shadow-xs">
                                    <i data-lucide="file-check" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-900 flex items-center gap-1.5">
                                        <span>Tryout JLPT & JFT</span>
                                        <span class="px-1.5 py-0.5 rounded bg-japan-100 text-japan-700 text-[9px] font-black uppercase">100 Soal</span>
                                    </p>
                                    <p class="text-[11px] text-slate-400">Simulasi CBT online gratis tanpa login</p>
                                </div>
                            </a>

                            <!-- Peta Alumni Highlight -->
                            <a href="{{ route('alumni.map') }}" class="flex items-center gap-3 p-2.5 rounded-2xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-9 h-9 rounded-xl bg-red-100 text-japan-600 flex items-center justify-center font-bold">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Peta Sebaran Alumni</p>
                                    <p class="text-[11px] text-slate-400">Sebaran alumni di 47 prefektur Jepang</p>
                                </div>
                            </a>

                            <!-- Unduh Brosur Resmi Highlight -->
                            <a href="{{ route('brochure.index') }}" class="flex items-center gap-3 p-2.5 rounded-2xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-9 h-9 rounded-xl bg-japan-50 text-japan-600 flex items-center justify-center font-bold">
                                    <i data-lucide="book-open" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>Brosur & Biaya Resmi</span>
                                        <span class="px-1.5 py-0.5 rounded bg-japan-100 text-japan-700 text-[9px] font-black uppercase">2026</span>
                                    </p>
                                    <p class="text-[11px] text-slate-400">Kurikulum & rincian biaya transparan</p>
                                </div>
                            </a>

                            <!-- Tes Minat Karir -->
                            <button type="button" onclick="openModal('quizModal')" class="w-full flex items-center gap-3 p-2.5 rounded-2xl hover:bg-amber-50 text-slate-700 hover:text-amber-900 transition text-left">
                                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                                    <i data-lucide="compass" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>Tes Minat & Karir</span>
                                        <span class="px-1.5 py-0.5 rounded bg-amber-200 text-amber-900 text-[9px] font-black uppercase">Quiz</span>
                                    </p>
                                    <p class="text-[11px] text-slate-400">Rekomendasi program sesuai potensi Anda</p>
                                </div>
                            </button>

                            <!-- Kemitraan SMK & Afiliasi -->
                            <a href="{{ route('affiliates.public.register') }}" class="flex items-center gap-3 p-2.5 rounded-2xl hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 transition">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                    <i data-lucide="handshake" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>Kemitraan SMK & BKK</span>
                                        <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[9px] font-black">Komisi</span>
                                    </p>
                                    <p class="text-[11px] text-slate-400">Program referral guru BK & alumni</p>
                                </div>
                            </a>

                            <div class="my-1 border-t border-slate-100"></div>

                            <a href="{{ route('home') }}#jadwal" class="flex items-center gap-3 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Jadwal Angkatan & Kuota</p>
                                    <p class="text-[10px] text-slate-400">Pendaftaran kelas baru</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#pengajar" class="flex items-center gap-3 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                                    <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Sensei & Instruktur</p>
                                    <p class="text-[10px] text-slate-400">Pengajar bersertifikasi N1/N2 & Native</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#fasilitas" class="flex items-center gap-3 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                                    <i data-lucide="building" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Fasilitas & Asrama</p>
                                    <p class="text-[10px] text-slate-400">Sarana asrama representatif</p>
                                </div>
                            </a>

                            <a href="{{ route('home') }}#faq" class="flex items-center gap-3 p-2 rounded-xl hover:bg-red-50 text-slate-700 hover:text-japan-700 transition">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                                    <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Tanya Jawab (FAQ)</p>
                                    <p class="text-[10px] text-slate-400">Pertanyaan umum seputar proses</p>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            </nav>

            <!-- Actions (Right - Clean, Fully Visible & Never Cut Off) -->
            <div class="flex items-center gap-2 sm:gap-2.5 xl:gap-3 flex-shrink-0">
                
                <!-- Tes Minat Quiz Button (Shown on 2xl screens) -->
                <button 
                    type="button" 
                    onclick="openModal('quizModal')" 
                    class="hidden 2xl:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-amber-900 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition shadow-2xs whitespace-nowrap"
                    title="Cek program yang cocok untuk Anda"
                >
                    <i data-lucide="compass" class="w-3.5 h-3.5 text-amber-600"></i>
                    <span>Tes Minat</span>
                </button>

                <!-- Portal Staf / Login Admin: Sleek Icon+Text on xl, Icon-only on sm/md/lg -->
                <a 
                    href="{{ route('admin.login') }}" 
                    class="hidden sm:inline-flex items-center gap-1.5 px-2.5 xl:px-3 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200/80 transition whitespace-nowrap"
                    title="Login Portal Staf & Pengajar"
                >
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-japan-600"></i>
                    <span class="hidden xl:inline">Portal Staf</span>
                </a>

                <!-- CTA Button (Always 100% visible with sparkling icon) -->
                <button 
                    type="button"
                    onclick="openModal('consultationModal')" 
                    class="btn-red-primary px-3.5 sm:px-4 xl:px-5 py-2 sm:py-2.5 rounded-xl text-xs font-extrabold flex items-center justify-center gap-1.5 sm:gap-2 shadow-md shadow-red-600/25 whitespace-nowrap flex-shrink-0"
                >
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
