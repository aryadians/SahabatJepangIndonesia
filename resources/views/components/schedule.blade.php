<!-- Jadwal Gelombang & Kuota Kelas Section -->
<section id="jadwal" class="py-20 bg-slate-900 text-white relative overflow-hidden">
    
    <!-- Background Torii / Seigaiha Watermark -->
    <div class="absolute inset-0 bg-seigaiha opacity-5 pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-japan-600/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-12">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-950/80 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-wider">
                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                <span>Jadwal Angkatan & Kuota Penerimaan</span>
            </div>
            
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
                Jadwal Masuk Kelas & <span class="text-japan-500">Ketersediaan Kursi</span>
            </h2>
            
            <p class="text-xs sm:text-sm text-slate-400">
                Pilih gelombang pelatihan yang sesuai dengan rencana karir Anda. Kuota tiap angkatan dibatasi untuk menjamin efektivitas belajar dan kelulusan tes wawancara user Jepang.
            </p>
        </div>

        <!-- Schedule Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($schedules ?? [] as $sch)
                @php
                    $quotaVal = (int) ($sch->quota ?? 20);
                    $remainingVal = (int) ($sch->remaining_seats ?? 0);
                    $filledPercent = $quotaVal > 0 ? max(10, min(100, round((($quotaVal - $remainingVal) / $quotaVal) * 100))) : 50;
                    $regDeadline = $sch->registration_deadline ? date('d M Y', strtotime($sch->registration_deadline)) : '-';
                    $startDate = $sch->start_date ? date('d M Y', strtotime($sch->start_date)) : '-';
                @endphp
                <div class="bg-slate-800/80 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 flex flex-col justify-between hover:border-japan-500 transition-all duration-300 group hover:-translate-y-1 shadow-lg" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    
                    <div class="space-y-4">
                        
                        <!-- Top Badge Status -->
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wide {{ $sch->status === 'limited' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40' : ($sch->status === 'open' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'bg-slate-700 text-slate-400') }}">
                                {{ $sch->status === 'limited' ? '⚡ Kuota Terbatas' : ($sch->status === 'open' ? '🟢 Pendaftaran Buka' : '🔴 Ditutup') }}
                            </span>
                            <span class="text-[11px] font-black text-japan-400">
                                Sisa <span data-live-batch-seats="{{ $sch->id }}">{{ $remainingVal }}</span> Kursi
                            </span>
                        </div>

                        <!-- Title & Program -->
                        <div>
                            <span class="text-xs font-bold text-slate-400">{{ $sch->program_type }}</span>
                            <h3 class="text-base font-black text-white group-hover:text-japan-400 transition mt-0.5 line-clamp-2">
                                {{ $sch->batch_name }}
                            </h3>
                        </div>

                        <!-- Progress Bar Seat Capacity -->
                        <div class="space-y-1.5 pt-1">
                            <div class="flex items-center justify-between text-[11px] text-slate-400">
                                <span>Kapasitas Terisi</span>
                                <span class="font-bold text-white">{{ $filledPercent }}%</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-700 overflow-hidden flex">
                                <div class="h-full rounded-full {{ $remainingVal <= 3 ? 'bg-gradient-to-r from-amber-500 to-rose-500' : 'bg-gradient-to-r from-japan-600 to-japan-500' }}" data-progress="{{ $filledPercent }}" style="width: {{ $filledPercent }}%;"></div>
                            </div>
                        </div>

                        <!-- Details List -->
                        <div class="space-y-2 pt-2 text-xs border-t border-slate-700/60 text-slate-300">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 flex items-center gap-1.5">
                                    <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-500"></i> Batas Daftar:
                                </span>
                                <span class="font-bold text-rose-400">{{ $regDeadline }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 flex items-center gap-1.5">
                                    <i data-lucide="book-open" class="w-3.5 h-3.5 text-slate-500"></i> Mulai Kelas:
                                </span>
                                <span class="font-semibold text-white">{{ $startDate }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 flex items-center gap-1.5">
                                    <i data-lucide="plane" class="w-3.5 h-3.5 text-slate-500"></i> Target Terbang:
                                </span>
                                <span class="font-semibold text-white">{{ $sch->target_departure ?? '-' }}</span>
                            </div>
                        </div>

                    </div>

                    <!-- CTA Action -->
                    <div class="pt-6">
                        @if($sch->status !== 'closed' && $remainingVal > 0)
                            <a 
                                href="#konsultasi" 
                                onclick="document.getElementById('consultationProgram').value = '{{ $sch->program_type }}'" 
                                class="w-full py-2.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-bold text-xs text-center shadow-md hover:shadow-red-600/30 transition flex items-center justify-center gap-1.5"
                            >
                                <span>Ambil Slot Kursi</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        @else
                            <button disabled class="w-full py-2.5 rounded-xl bg-slate-700 text-slate-500 font-bold text-xs cursor-not-allowed">
                                Kuota Telah Penuh
                            </button>
                        @endif
                    </div>

                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-slate-400 text-sm">
                    Jadwal angkatan baru sedang disiapkan oleh tim akademik LPK.
                </div>
            @endforelse
        </div>

    </div>
</section>
