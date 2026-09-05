<!-- Jadwal Gelombang & Kuota Kelas Section -->
@php
    $cleanWa = preg_replace('/[^0-9]/', '', $settings['contact_whatsapp'] ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) $cleanWa = '62' . substr($cleanWa, 1);
@endphp
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

        <!-- Program Filter Tabs for Schedule -->
        <div class="flex flex-wrap items-center justify-center gap-2 pt-2">
            <button 
                type="button" 
                onclick="filterScheduleBatch('all', this)"
                class="schedule-filter-btn active px-4 py-2 rounded-xl text-xs font-bold transition-all bg-japan-600 text-white shadow-md shadow-red-600/30"
                data-filter="all"
            >
                Semua Program
            </button>
            <button 
                type="button" 
                onclick="filterScheduleBatch('Tokutei Ginou', this)"
                class="schedule-filter-btn px-4 py-2 rounded-xl text-xs font-bold transition-all bg-slate-800 hover:bg-slate-700 text-slate-300"
                data-filter="Tokutei Ginou"
            >
                Tokutei Ginou (SSW)
            </button>
            <button 
                type="button" 
                onclick="filterScheduleBatch('Magang', this)"
                class="schedule-filter-btn px-4 py-2 rounded-xl text-xs font-bold transition-all bg-slate-800 hover:bg-slate-700 text-slate-300"
                data-filter="Magang"
            >
                Magang Kerja
            </button>
            <button 
                type="button" 
                onclick="filterScheduleBatch('Kursus', this)"
                class="schedule-filter-btn px-4 py-2 rounded-xl text-xs font-bold transition-all bg-slate-800 hover:bg-slate-700 text-slate-300"
                data-filter="Kursus"
            >
                Kursus Bahasa
            </button>
        </div>

        <!-- Schedule Grid Cards -->
        <div id="scheduleBatchGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($schedules ?? [] as $sch)
                @php
                    $quotaVal = (int) ($sch->quota ?? 20);
                    $remainingVal = (int) ($sch->remaining_seats ?? 0);
                    $filledPercent = $quotaVal > 0 ? max(10, min(100, round((($quotaVal - $remainingVal) / $quotaVal) * 100))) : 50;
                    $regDeadline = $sch->registration_deadline ? date('d M Y', strtotime($sch->registration_deadline)) : '-';
                    $startDate = $sch->start_date ? date('d M Y', strtotime($sch->start_date)) : '-';
                @endphp
                <div 
                    class="schedule-card bg-slate-800/80 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 flex flex-col justify-between hover:border-japan-500 transition-all duration-300 group hover:-translate-y-1 shadow-lg" 
                    data-program="{{ $sch->program_type }}"
                    data-aos="fade-up" 
                    data-aos-delay="{{ $loop->iteration * 100 }}"
                >
                    
                    <div class="space-y-4">
                        
                        <!-- Top Badge Status -->
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wide {{ $sch->status === 'limited' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40' : ($sch->status === 'open' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'bg-slate-700 text-slate-400') }}">
                                {{ $sch->status === 'limited' ? '⚡ Kuota Terbatas' : ($sch->status === 'open' ? '🟢 Pendaftaran Buka' : '🔴 Ditutup') }}
                            </span>
                            <span class="text-[11px] font-black text-japan-400 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-japan-400 animate-ping"></span>
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

                    <!-- CTA Actions: Direct WA Fast-Track or Consultation Modal -->
                    <div class="pt-6 space-y-2">
                        @if($sch->status !== 'closed' && $remainingVal > 0)
                            <button 
                                type="button"
                                onclick="bookBatchSlot('{{ addslashes($sch->batch_name) }}', '{{ addslashes($sch->program_type) }}')" 
                                class="w-full py-2.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-bold text-xs text-center shadow-md hover:shadow-red-600/30 transition flex items-center justify-center gap-1.5 active:scale-95"
                            >
                                <span>Ambil Slot Kursi</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </button>
                            <a 
                                href="https://api.whatsapp.com/send?phone={{ $cleanWa }}&text={{ urlencode('Halo Admin SJI, saya ingin mengamankan slot kursi kelas untuk: ' . $sch->batch_name . ' (' . $sch->program_type . ')') }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="w-full py-2 rounded-xl bg-slate-700/60 hover:bg-emerald-600 text-slate-300 hover:text-white font-bold text-[11px] text-center transition flex items-center justify-center gap-1.5"
                                title="Kunci kursi via WhatsApp"
                            >
                                <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>Kunci Kursi via WA</span>
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

        <!-- 3. Dynamic Kaisha Matching & Scheduled Interviews Showcase -->
        @if(isset($upcomingInterviews) && $upcomingInterviews->count() > 0)
            <div class="pt-8 border-t border-slate-800 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="space-y-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/80 border border-blue-500/30 text-blue-400 text-[11px] font-black uppercase tracking-wider">
                            <i data-lucide="video" class="w-3 h-3"></i>
                            <span class="font-japanese">面接日程</span>
                            <span>• Agenda Wawancara Langsung User Jepang</span>
                        </div>
                        <h3 class="text-xl font-black text-white">Jadwal Seleksi & Wawancara Kaisha Aktif</h3>
                    </div>
                    <span class="text-xs text-slate-400">
                        Sinkronisasi otomatis dengan database penerimaan perusahaan Jepang
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($upcomingInterviews as $interview)
                        <div class="p-4 rounded-2xl bg-white/5 border border-slate-800 hover:border-blue-500/40 transition flex flex-col justify-between space-y-3 group">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-blue-900/60 text-blue-300 border border-blue-700/60">
                                        {{ $interview->program_type }}
                                    </span>
                                    <span class="text-[11px] font-mono text-emerald-400 font-bold">
                                        {{ $interview->quota }} Kuota
                                    </span>
                                </div>
                                <h4 class="font-black text-white text-sm group-hover:text-blue-300 transition line-clamp-1" title="{{ $interview->company_name }}">
                                    {{ $interview->company_name }}
                                </h4>
                                <p class="text-xs text-slate-400 flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-red-400 flex-shrink-0"></i>
                                    <span>Prefektur: {{ $interview->prefecture }}</span>
                                </p>
                            </div>

                            <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-[11px]">
                                <span class="text-slate-400">
                                    {{ $interview->interview_date ? $interview->interview_date->format('d M Y') : 'Terjadwal' }}
                                </span>
                                <span class="text-emerald-400 font-bold uppercase text-[10px] flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span>Online Zoom</span>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Inline Batch Booking Script -->
        <script>
            function bookBatchSlot(batchName, programType) {
                if (typeof openModal === 'function') {
                    openModal('consultationModal');
                }
                if (typeof setConsultProgram === 'function') {
                    setConsultProgram(programType);
                } else {
                    const sel = document.getElementById('consultProgramSelect');
                    if (sel) sel.value = programType;
                }
                const notes = document.querySelector('textarea[name="notes"]');
                if (notes) {
                    notes.value = 'Ingin mendaftar untuk: ' + batchName;
                }
            }

            function filterScheduleBatch(category, btnEl) {
                const buttons = document.querySelectorAll('.schedule-filter-btn');
                buttons.forEach(b => {
                    b.classList.remove('active', 'bg-japan-600', 'text-white', 'shadow-md', 'shadow-red-600/30');
                    b.classList.add('bg-slate-800', 'text-slate-300');
                });
                if (btnEl) {
                    btnEl.classList.add('active', 'bg-japan-600', 'text-white', 'shadow-md', 'shadow-red-600/30');
                    btnEl.classList.remove('bg-slate-800', 'text-slate-300');
                }

                const cards = document.querySelectorAll('.schedule-card');
                cards.forEach(c => {
                    const prog = (c.getAttribute('data-program') || '').toLowerCase();
                    if (category === 'all' || prog.includes(category.toLowerCase())) {
                        c.style.display = 'flex';
                    } else {
                        c.style.display = 'none';
                    }
                });
            }
        </script>

    </div>
</section>
