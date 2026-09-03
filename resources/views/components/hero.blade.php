<!-- Hero Section with 3D Canvas & Modern Visuals -->
<section id="beranda" class="relative overflow-hidden bg-hero-gradient pt-8 pb-16 lg:pt-16 lg:pb-28 border-b border-red-50">
    
    <!-- 3D Interactive Sakura Petal & Particle Canvas -->
    <canvas id="hero3dCanvas"></canvas>

    <!-- Japanese Background Sun Motif -->
    <div class="absolute top-1/2 -right-32 -translate-y-1/2 w-[450px] h-[450px] lg:w-[650px] lg:h-[650px] rounded-full bg-gradient-to-br from-red-500/10 via-red-500/5 to-transparent blur-3xl pointer-events-none -z-0"></div>
    <div class="absolute -top-20 -left-20 w-[350px] h-[350px] rounded-full bg-red-100/50 blur-2xl pointer-events-none -z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Left Text Column -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                
                <!-- Verified Badge & Japanese Motto -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-red-200/80 shadow-sm text-xs sm:text-sm font-semibold text-japan-700 reveal-on-scroll">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                    </span>
                    <span class="font-japanese text-xs font-bold text-red-600">夢をつかめ</span>
                    <span class="text-slate-300">|</span>
                    <span>{{ $settings['hero_motto'] ?? 'LPK & SO Resmi Kemenaker RI' }}</span>
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                </div>

                <!-- Main Title -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15] reveal-on-scroll delay-100">
                    {{ $settings['hero_title_1'] ?? 'Jembatan Emas Menuju' }} <br class="hidden sm:inline">
                    <span class="bg-gradient-to-r from-japan-700 via-red-600 to-rose-600 bg-clip-text text-transparent">
                        {{ $settings['hero_title_highlight'] ?? 'Karir Gemilang di Jepang' }}
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed reveal-on-scroll delay-200">
                    {!! nl2br(e($settings['hero_subtitle'] ?? 'Wujudkan impian berpenghasilan Rp 18 - 35 Juta/bulan di Jepang. Program Tokutei Ginou (SSW) & Magang Resmi dengan bimbingan bahasa intensif dari nol, asrama representatif, hingga penempatan kerja terpercaya di seluruh prefektur Jepang.')) !!}
                </p>

                <!-- Call To Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2 reveal-on-scroll delay-300">
                    <button onclick="openModal('consultationModal')" class="w-full sm:w-auto btn-red-primary px-8 py-4 rounded-2xl font-bold text-base flex items-center justify-center gap-3 shadow-lg shadow-red-600/30 group">
                        <i data-lucide="sparkles" class="w-5 h-5 text-amber-200 group-hover:rotate-12 transition-transform"></i>
                        <span>Mulai Konsultasi Gratis</span>
                        <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                    
                    <a href="#program" class="w-full sm:w-auto btn-white-outline px-7 py-4 rounded-2xl font-bold text-base flex items-center justify-center gap-2">
                        <i data-lucide="compass" class="w-5 h-5 text-japan-600"></i>
                        <span>Pilihan Program Kerja</span>
                    </a>
                </div>

                <!-- Trust Points -->
                <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-y-2 gap-x-6 text-xs sm:text-sm text-slate-500 font-medium reveal-on-scroll delay-400">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                        <span>Tanpa Potongan Gaji Ilegal</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                        <span>Native Speaker & Sensei N1/N2</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                        <span>Pendampingan 24/7 di Jepang</span>
                    </div>
                </div>

            </div>

            <!-- Right Visual Column (3D Interactive Cards & Japan Visual) -->
            <div class="lg:col-span-5 relative reveal-scale delay-200">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    
                    <!-- Main Image Frame with 3D Border Glow -->
                    <div class="relative rounded-3xl p-2 bg-gradient-to-b from-red-200 via-white to-red-100 shadow-2xl shadow-red-900/10">
                        <div class="relative rounded-2xl overflow-hidden aspect-[4/4.8] sm:aspect-[4/4.5] bg-slate-100">
                            <img 
                                src="{{ $settings['hero_image'] ?? 'https://images.unsplash.com/photo-1528164344705-475426879c0d?auto=format&fit=crop&w=900&q=80' }}" 
                                alt="Pesona Jepang & Karir Alumni Sahabat Jepang Indonesia"
                                class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700"
                                loading="lazy"
                            >
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/20"></div>

                            <!-- Bottom Card Badge in Image -->
                            <div class="absolute bottom-4 left-4 right-4 p-4 rounded-2xl bg-white/90 backdrop-blur-md border border-white/40 shadow-lg text-left">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-japan-600 text-white flex items-center justify-center font-bold">
                                            <i data-lucide="plane-takeoff" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 font-semibold">Keberangkatan Rutin</p>
                                            <h4 class="text-sm font-extrabold text-slate-900">Tokyo • Osaka • Nagoya</h4>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                        Visa Approved
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating 3D Badge 1: Salary Rate (Top Left) -->
                    <div class="absolute -top-6 -left-6 sm:-left-8 p-4 rounded-2xl bg-white/95 backdrop-blur-md border border-red-100 shadow-xl shadow-slate-900/5 animate-float hidden sm:block">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center shadow-md shadow-amber-500/20">
                                <i data-lucide="coins" class="w-6 h-6"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Potensi Gaji</p>
                                <p class="text-base font-extrabold text-slate-900">¥ 200.000+ <span class="text-xs font-medium text-emerald-600">/ bln</span></p>
                                <p class="text-[10px] text-slate-500">± Rp 21 - 35 Juta</p>
                            </div>
                        </div>
                    </div>

                    <!-- Floating 3D Badge 2: Japanese Flag Connection (Bottom Right) -->
                    <div class="absolute -bottom-6 -right-6 sm:-right-8 p-4 rounded-2xl bg-slate-900 text-white border border-slate-700/60 shadow-2xl animate-float hidden sm:block" style="animation-delay: -3s;">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <span class="w-9 h-9 rounded-full bg-red-600 flex items-center justify-center text-xs font-black border-2 border-slate-900 text-white">ID</span>
                                <span class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-xs font-black border-2 border-slate-900 text-red-600">JP</span>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-bold text-white">Mitra Resmi 50+ Kaisha</p>
                                <p class="text-[10px] text-slate-400">Penempatan Kerja Amanah</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Live Achievement Counters (4 Highlights) -->
        <div class="mt-16 sm:mt-20 pt-8 border-t border-slate-200/80 grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 reveal-on-scroll delay-400">
            
            <div class="text-center p-4 rounded-2xl bg-white/60 backdrop-blur-sm border border-slate-100 hover:border-red-200 transition">
                <p class="text-3xl sm:text-4xl lg:text-5xl font-black text-japan-700 tracking-tight" data-counter="{{ $settings['stat_alumni_count'] ?? '500' }}" data-suffix="{{ $settings['stat_alumni_suffix'] ?? '+' }}" data-live-stat="total_alumni">0{{ $settings['stat_alumni_suffix'] ?? '+' }}</p>
                <p class="text-xs sm:text-sm font-bold text-slate-800 mt-1">Alumni Diberangkatkan</p>
                <p class="text-[11px] text-slate-500">Bekerja aktif di Jepang</p>
            </div>

            <div class="text-center p-4 rounded-2xl bg-white/60 backdrop-blur-sm border border-slate-100 hover:border-red-200 transition">
                <p class="text-3xl sm:text-4xl lg:text-5xl font-black text-japan-700 tracking-tight" data-counter="{{ $settings['stat_partners_count'] ?? '50' }}" data-suffix="{{ $settings['stat_partners_suffix'] ?? '+' }}">0{{ $settings['stat_partners_suffix'] ?? '+' }}</p>
                <p class="text-xs sm:text-sm font-bold text-slate-800 mt-1">Mitra Kaisha & Kumiai</p>
                <p class="text-[11px] text-slate-500">Perusahaan terverifikasi</p>
            </div>

            <div class="text-center p-4 rounded-2xl bg-white/60 backdrop-blur-sm border border-slate-100 hover:border-red-200 transition">
                <p class="text-3xl sm:text-4xl lg:text-5xl font-black text-japan-700 tracking-tight" data-counter="{{ $settings['stat_pass_rate_count'] ?? '98' }}" data-suffix="{{ $settings['stat_pass_rate_suffix'] ?? '%' }}">0{{ $settings['stat_pass_rate_suffix'] ?? '%' }}</p>
                <p class="text-xs sm:text-sm font-bold text-slate-800 mt-1">Tingkat Lulus Ujian</p>
                <p class="text-[11px] text-slate-500">JLPT & JFT Basic A2</p>
            </div>

            <div class="text-center p-4 rounded-2xl bg-white/60 backdrop-blur-sm border border-slate-100 hover:border-red-200 transition">
                <p class="text-3xl sm:text-4xl lg:text-5xl font-black text-japan-700 tracking-tight" data-counter="{{ $settings['stat_legal_count'] ?? '100' }}" data-suffix="{{ $settings['stat_legal_suffix'] ?? '%' }}">0{{ $settings['stat_legal_suffix'] ?? '%' }}</p>
                <p class="text-xs sm:text-sm font-bold text-slate-800 mt-1">Legalitas Kemenaker</p>
                <p class="text-[11px] text-slate-500">Sending Organization Resmi</p>
            </div>

        </div>

    </div>
</section>
