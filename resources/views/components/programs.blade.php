<!-- Programs Catalog Section -->
<section id="program" class="py-20 lg:py-28 bg-[#FFF8F8] relative overflow-hidden border-y border-red-100">
    
    <!-- Background Accents -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-red-100/50 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-rose-100/40 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3 reveal-on-scroll">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-bold uppercase tracking-wider">
                <span class="font-japanese text-sm">プログラム一覧</span>
                <span>• Program Pilihan Karir ke Jepang</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                Pilih Jalur Karir yang Sesuai dengan <br class="hidden sm:inline">
                <span class="text-japan-600">Minat & Impian Masa Depan Anda</span>
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Seluruh program memiliki standar kurikulum resmi, bimbingan berkala, dan kepastian penyaluran kerja ke perusahaan terkemuka di Jepang.
            </p>
        </div>

        <!-- Program Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($programs as $index => $program)
                <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col justify-between glass-card-hover border border-red-100/80 reveal-on-scroll delay-{{ ($index + 1) * 100 }} relative overflow-hidden group">
                    
                    <!-- Decorative Japanese Kanji Watermark -->
                    <div class="absolute -right-4 -bottom-6 font-japanese font-black text-8xl text-red-500/5 select-none pointer-events-none transition-transform group-hover:scale-110 group-hover:text-red-500/10 duration-500">
                        {{ $program['japanese_title'] }}
                    </div>

                    <div>
                        <!-- Card Header: Badges & Japanese Title -->
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $program['badge_color'] }} shadow-sm">
                                {{ $program['badge'] }}
                            </span>
                            <span class="font-japanese text-sm font-bold text-japan-600 tracking-wider bg-red-50 px-3 py-1 rounded-xl">
                                {{ $program['japanese_title'] }}
                            </span>
                        </div>

                        <!-- Main Title & Subtitle -->
                        <h3 class="text-2xl font-extrabold text-slate-900 group-hover:text-japan-600 transition-colors">
                            {{ $program['title'] }}
                        </h3>
                        <p class="text-xs sm:text-sm font-semibold text-slate-500 mt-1 mb-4">
                            {{ $program['subtitle'] }}
                        </p>

                        <!-- Salary & Duration Card Box -->
                        <div class="p-4 rounded-2xl bg-gradient-to-r from-red-50 via-white to-red-50/50 border border-red-100/80 mb-5">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Estimasi Gaji</p>
                                    <p class="text-base font-extrabold text-japan-700">{{ $program['salary_yen'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $program['salary_idr'] }}</p>
                                </div>
                                <div class="border-l border-red-100 pl-3">
                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Masa Kontrak</p>
                                    <p class="text-xs font-bold text-slate-800 mt-1">{{ $program['duration'] }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Brief Description -->
                        <p class="text-sm text-slate-600 leading-relaxed mb-5">
                            {{ $program['description'] }}
                        </p>

                        <!-- Sector Badges Preview -->
                        <div class="space-y-2 mb-6">
                            <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Bidang Pekerjaan:</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(array_slice($program['sectors'], 0, 4) as $sector)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-red-50 hover:text-japan-600 text-xs font-medium text-slate-700 transition">
                                        <span class="w-1.5 h-1.5 rounded-full bg-japan-600"></span>
                                        {{ $sector }}
                                    </span>
                                @endforeach
                                @if(count($program['sectors']) > 4)
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg bg-red-100/60 text-xs font-bold text-japan-700">
                                        +{{ count($program['sectors']) - 4 }} Bidang Lain
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card Action Buttons -->
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                        <button 
                            type="button"
                            onclick='showProgramDetail(@json($program))'
                            class="w-full sm:flex-1 btn-white-outline py-3 px-4 rounded-xl text-sm font-bold flex items-center justify-center gap-2 group-hover:border-japan-600 transition"
                        >
                            <i data-lucide="info" class="w-4 h-4 text-japan-600"></i>
                            <span>Rincian & Syarat</span>
                        </button>

                        <button 
                            type="button"
                            onclick="openModal('consultationModal'); document.getElementById('consultProgramSelect').value = '{{ $program['title'] }}';"
                            class="w-full sm:flex-1 btn-red-primary py-3 px-4 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-sm"
                        >
                            <i data-lucide="send" class="w-4 h-4"></i>
                            <span>Daftar Sekarang</span>
                        </button>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Bottom Notice Banner -->
        <div class="mt-12 p-6 rounded-3xl bg-white border border-red-200/80 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left reveal-on-scroll">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-100 text-japan-700 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="help-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-base">Masih Bingung Memilih Program yang Tepat?</h4>
                    <p class="text-xs sm:text-sm text-slate-500">Konsultasikan bakat, pendidikan, dan usia Anda dengan tim konselor kami secara gratis.</p>
                </div>
            </div>
            <button onclick="openModal('consultationModal')" class="btn-red-primary px-6 py-3 rounded-xl text-sm font-bold whitespace-nowrap shadow-md">
                Konsultasi Pilihan Program &rarr;
            </button>
        </div>

    </div>
</section>
