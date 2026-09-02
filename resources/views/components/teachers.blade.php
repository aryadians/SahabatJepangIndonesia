<!-- Sensei & Instructors Team Section -->
<section id="pengajar" class="py-20 sm:py-28 bg-white relative overflow-hidden">
    
    <!-- Subtle Background Accents -->
    <div class="absolute -left-20 top-1/2 -translate-y-1/2 w-96 h-96 bg-red-50/50 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -right-20 bottom-10 w-96 h-96 bg-slate-50 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-4 sm:px-6 relative z-10 max-w-7xl">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-50 text-japan-600 border border-red-100 text-xs font-bold tracking-wide">
                <i data-lucide="award" class="w-4 h-4"></i>
                <span>TENAGA PENGAJAR PROFESIONAL</span>
                <span class="font-japanese font-normal">講師紹介</span>
            </div>
            
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Dibimbing Langsung oleh <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-japan-600 via-red-600 to-rose-700">Sensei Tersertifikasi & Native Jepang</span>
            </h2>
            
            <p class="text-sm sm:text-base text-slate-600">
                Kurikulum standar Jepang yang diasuh oleh Master Trainer berlisensi JLPT N1/N2 serta penutur asli (*Native Speaker*) dari Jepang untuk memastikan kesiapan bahasa & mental wawancara Anda.
            </p>
        </div>

        <!-- Teachers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($teachers as $index => $teacher)
                <div 
                    class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-japan-600/50 transition-all duration-300 flex flex-col justify-between group"
                    data-aos="fade-up"
                    data-aos-delay="{{ ($index + 1) * 100 }}"
                >
                    <div class="space-y-5">
                        
                        <!-- Teacher Profile Card Header -->
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-slate-100 border-2 border-slate-200 overflow-hidden shadow-inner flex-shrink-0 relative group-hover:scale-105 transition-transform duration-300">
                                @if($teacher->photo)
                                    <img src="{{ $teacher->photo }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                        <i data-lucide="user" class="w-8 h-8"></i>
                                    </div>
                                @endif
                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950/80 to-transparent p-1 text-center">
                                    <span class="text-[9px] font-bold text-white uppercase font-mono">{{ $teacher->nip }}</span>
                                </div>
                            </div>

                            <div class="space-y-1 min-w-0 flex-1">
                                <span class="inline-block px-2.5 py-0.5 rounded-full bg-red-50 text-japan-700 font-extrabold text-[11px] border border-red-100">
                                    {{ $teacher->jlpt_level }}
                                </span>
                                <h3 class="text-base font-black text-slate-900 leading-tight group-hover:text-japan-600 transition-colors truncate">
                                    {{ $teacher->name }}
                                </h3>
                                <p class="text-xs font-bold text-slate-500 font-japanese">
                                    {{ $teacher->romaji_name ?: 'Sensei' }}
                                </p>
                            </div>
                        </div>

                        <!-- Teacher Info Badge -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Fokus Pengajaran:</span>
                                <p class="font-bold text-slate-800 mt-0.5">{{ $teacher->specialization }}</p>
                            </div>
                            
                            @if($teacher->japan_experience)
                                <div class="pt-1.5 border-t border-slate-200/60">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pengalaman di Jepang:</span>
                                    <p class="text-slate-600 text-[11px] mt-0.5 italic flex items-center gap-1">
                                        <i data-lucide="map-pin" class="w-3 h-3 text-red-500 flex-shrink-0"></i>
                                        <span>{{ $teacher->japan_experience }}</span>
                                    </p>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- Footer Note -->
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span class="inline-flex items-center gap-1.5 text-emerald-600 font-bold text-[11px]">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                            <span>Instruktur Aktif LPK SJI</span>
                        </span>
                        <span class="text-[10px] text-slate-400 font-japanese">信頼の指導陣</span>
                    </div>

                </div>
            @empty
                <!-- Fallback Sensei Card -->
                <div class="col-span-3 text-center py-8 text-slate-400">
                    <p class="text-xs">Data instruktur sedang dimuat...</p>
                </div>
            @endforelse
        </div>

        <!-- CTA Consult Sensei -->
        <div class="mt-14 p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6" data-aos="fade-up">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 text-red-400 flex items-center justify-center font-bold text-xl flex-shrink-0">
                    <i data-lucide="message-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white">Ingin Konsultasi Kemampuan Bahasa Jepang Anda?</h3>
                    <p class="text-xs sm:text-sm text-slate-300 mt-0.5">Ikuti tes penempatan (*Placement Test*) dan konsultasi karir gratis bersama para Sensei kami.</p>
                </div>
            </div>

            <a 
                href="#daftar" 
                class="btn-red-primary px-6 py-3 rounded-2xl text-xs font-black shadow-md flex items-center gap-2 flex-shrink-0 whitespace-nowrap"
            >
                <i data-lucide="send" class="w-4 h-4"></i>
                <span>Daftar Konsultasi Gratis</span>
            </a>
        </div>

    </div>

</section>
