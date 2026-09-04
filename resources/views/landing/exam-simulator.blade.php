@extends('layouts.app')

@section('title', 'Simulasi Ujian JLPT & JFT-Basic CBT Online (100 Soal) - LPK Sahabat Jepang Indonesia')
@section('meta_description', 'Latihan tryout ujian JLPT N5, N4, N3, dan JFT-Basic CBT Online gratis. 100 soal interaktif lengkap dengan skoring otomatis dan kunci pembahasan.')
@section('meta_keywords', 'simulasi ujian jlpt online, tryout jlpt n5 n4 n3 cbt, simulasi jft basic gratis, latihan soal bahasa jepang cbt, sahabat jepang indonesia tryout')

@section('content')
<div class="bg-slate-950 text-white min-h-screen py-8 sm:py-12 relative overflow-hidden">

    <!-- Ambient Japanese Red Glow Background -->
    <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-red-600/15 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 -right-40 w-96 h-96 rounded-full bg-rose-600/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6">

        <!-- Top Header Banner -->
        <div class="bg-slate-900/90 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-slate-800 shadow-2xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold font-japanese">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    <span>日本語能力試験・JFT-Basic CBT Simulator</span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    Simulasi Tryout JLPT & JFT-Basic Online
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl leading-relaxed">
                    Uji kemampuan bahasa Jepang Anda secara instan dan gratis tanpa perlu login. Standar kurikulum resmi mencakup Kosakata (Kotoba), Tata Bahasa (Bunpou), Kanji, dan Pemahaman Membaca (Dokkai).
                </p>
            </div>

            <!-- Level Selector Pills -->
            <div class="flex flex-wrap items-center gap-1.5 bg-slate-950 p-2 rounded-2xl border border-slate-800 shadow-inner">
                <a 
                    href="{{ route('exam.simulator', ['level' => 'all']) }}" 
                    class="px-3.5 py-2 rounded-xl text-xs font-black transition {{ $selectedLevel === 'all' ? 'bg-japan-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}"
                >
                    🔥 Grand Tryout (100 Soal)
                </a>
                @foreach(['N5' => 'JLPT N5 (25 Soal)', 'N4' => 'JLPT N4 (25 Soal)', 'N3' => 'JLPT N3 (25 Soal)', 'JFT-Basic' => 'JFT-Basic (25 Soal)'] as $lvl => $lbl)
                    <a 
                        href="{{ route('exam.simulator', ['level' => $lvl]) }}" 
                        class="px-3.5 py-2 rounded-xl text-xs font-extrabold transition {{ $selectedLevel === $lvl ? 'bg-japan-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}"
                    >
                        {{ $lbl }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Exam CBT Container -->
        <div id="examContainer" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left: Active Question Area (8 Cols) -->
            <div class="lg:col-span-8 space-y-4">
                
                <div id="questionCard" class="bg-white text-slate-900 rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200 min-h-[480px] flex flex-col justify-between relative transition-all duration-200">
                    
                    <div>
                        <!-- Top Metadata & Section Badge -->
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                            <div class="flex items-center gap-3">
                                <span class="w-9 h-9 rounded-xl bg-red-100 text-japan-700 font-black text-sm flex items-center justify-center shadow-xs" id="currentQNumBadge">
                                    1
                                </span>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-slate-100 text-slate-700" id="currentQSection">
                                            {{ $questions[0]->section ?? 'Kotoba' }}
                                        </span>
                                        <span class="text-xs font-bold text-japan-600 font-japanese">
                                            Level {{ $selectedLevel }}
                                        </span>
                                        <span id="flagIndicator" class="hidden px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px] items-center gap-1 border border-amber-200">
                                            🚩 Ditandai Ragu
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 font-semibold mt-0.5">
                                        Bobot: {{ $questions[0]->points ?? 10 }} Poin
                                    </p>
                                </div>
                            </div>

                            <span class="text-xs font-bold text-slate-400 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                                Soal <span id="currentQIndexText" class="text-slate-900 font-black text-sm">1</span> dari {{ count($questions) }}
                            </span>
                        </div>

                        <!-- Question Text (With Japanese Furigana Support) -->
                        <div class="space-y-3 mb-6" id="questionContentBox">
                            <h3 id="questionTitle" class="text-base sm:text-lg font-extrabold text-slate-900 leading-relaxed font-sans">
                                {{ $questions[0]->question ?? 'Memuat soal...' }}
                            </h3>
                            @if(!empty($questions[0]->question_japanese))
                                <div id="questionJapaneseBox" class="p-4 rounded-2xl bg-red-50/50 border border-red-100 text-slate-900 font-japanese text-base sm:text-lg font-bold leading-relaxed shadow-xs">
                                    {{ $questions[0]->question_japanese }}
                                </div>
                            @else
                                <div id="questionJapaneseBox" class="hidden p-4 rounded-2xl bg-red-50/50 border border-red-100 text-slate-900 font-japanese text-base sm:text-lg font-bold leading-relaxed shadow-xs"></div>
                            @endif
                        </div>

                        <!-- Multiple Choice Options -->
                        <div class="space-y-3" id="optionsContainer">
                            @php
                                $firstQ = $questions[0] ?? null;
                            @endphp
                            @if($firstQ)
                                @foreach(['A' => $firstQ->option_a, 'B' => $firstQ->option_b, 'C' => $firstQ->option_c, 'D' => $firstQ->option_d] as $optKey => $optVal)
                                    <button 
                                        type="button" 
                                        onclick="selectAnswer('{{ $optKey }}')" 
                                        id="optBtn_{{ $optKey }}"
                                        class="option-btn w-full p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/40 text-left font-semibold text-xs sm:text-sm text-slate-800 flex items-center gap-3.5 transition group active:scale-[0.99]"
                                    >
                                        <span class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-japan-100 group-hover:text-japan-700 text-slate-700 font-black text-xs flex items-center justify-center flex-shrink-0 option-key transition">
                                            {{ $optKey }}
                                        </span>
                                        <span class="flex-1 font-japanese font-bold text-slate-800 group-hover:text-japan-900 option-text text-sm sm:text-base">{{ $optVal }}</span>
                                    </button>
                                @endforeach
                            @endif
                        </div>

                    </div>

                    <!-- Bottom Nav Actions with Ragu-ragu -->
                    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-5 mt-8">
                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                id="btnPrevQ" 
                                onclick="prevQuestion()" 
                                disabled
                                class="px-4 sm:px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-bold text-xs flex items-center gap-1.5 transition active:scale-[0.97]"
                            >
                                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                <span>Sebelumnya</span>
                            </button>

                            <!-- Button Ragu-ragu (Doubt toggle) -->
                            <button 
                                type="button" 
                                id="btnFlagQ" 
                                onclick="toggleFlag()" 
                                class="px-3.5 py-2.5 rounded-xl border border-amber-300 bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold text-xs flex items-center gap-1.5 transition active:scale-[0.97]"
                                title="Tandai nomor ini jika masih ragu-ragu"
                            >
                                <i data-lucide="flag" class="w-3.5 h-3.5 text-amber-600"></i>
                                <span id="flagBtnText">Ragu-ragu</span>
                            </button>
                        </div>

                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                onclick="confirmFinishExam()" 
                                class="px-4 sm:px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 shadow-md shadow-emerald-600/30 transition active:scale-[0.97]"
                            >
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                <span>Kumpulkan Ujian</span>
                            </button>

                            <button 
                                type="button" 
                                id="btnNextQ" 
                                onclick="nextQuestion()" 
                                class="btn-red-primary px-5 sm:px-6 py-2.5 rounded-xl font-bold text-xs flex items-center gap-1.5 shadow-md shadow-red-600/30 active:scale-[0.97]"
                            >
                                <span>Selanjutnya</span>
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Keyboard Navigation Hint Bar -->
                <div class="px-4 py-2.5 rounded-2xl bg-slate-900/80 border border-slate-800 text-[11px] text-slate-400 flex flex-wrap items-center justify-between gap-2 backdrop-blur-md">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-300">⌨️ Pintasan Keyboard:</span>
                        <span class="inline-flex items-center gap-1"><kbd class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700 text-white font-mono text-[10px]">A</kbd>-<kbd class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700 text-white font-mono text-[10px]">D</kbd> Pilih Opsi</span>
                        <span class="inline-flex items-center gap-1"><kbd class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700 text-white font-mono text-[10px]">&larr;</kbd> <kbd class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700 text-white font-mono text-[10px]">&rarr;</kbd> Navigasi</span>
                        <span class="inline-flex items-center gap-1"><kbd class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700 text-white font-mono text-[10px]">R</kbd> Ragu-ragu</span>
                    </div>
                    <span class="text-slate-500 font-mono text-[10px]">CBT Mode v2.4</span>
                </div>

            </div>

            <!-- Right: Timer, Progress & Question Grid (4 Cols) -->
            <div class="lg:col-span-4 space-y-4">
                
                <!-- Live Countdown Timer Card -->
                <div class="bg-slate-900/90 rounded-3xl p-6 border border-slate-800 shadow-xl space-y-3 text-center backdrop-blur-md">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Sisa Waktu Pengerjaan</span>
                    <div class="text-4xl font-black text-white font-mono flex items-center justify-center gap-2">
                        <i data-lucide="timer" class="w-7 h-7 text-red-500 animate-pulse"></i>
                        <span id="timerDisplay">{{ sprintf('%02d:00', max(30, (int) ceil(count($questions) * 1.2))) }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium">Timer otomatis berjalan saat mulai menjawab</p>
                </div>

                <!-- Navigator Question Matrix -->
                <div class="bg-slate-900/90 rounded-3xl p-6 border border-slate-800 shadow-xl space-y-4 backdrop-blur-md">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <h4 class="font-extrabold text-white text-xs uppercase tracking-wider">Navigasi Nomor Soal</h4>
                        <span class="text-xs font-bold text-emerald-400" id="answeredCountText">0 / {{ count($questions) }} Terjawab</span>
                    </div>

                    <!-- Question Badges Grid -->
                    <div class="grid grid-cols-5 gap-2 max-h-64 overflow-y-auto pr-1" id="questionNavGrid">
                        @foreach($questions as $idx => $q)
                            <button 
                                type="button" 
                                onclick="goToQuestion({{ $idx }})" 
                                id="navBtn_{{ $idx }}"
                                class="nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center relative transition {{ $idx === 0 ? 'bg-japan-600 text-white ring-2 ring-red-400' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}"
                            >
                                <span>{{ $idx + 1 }}</span>
                            </button>
                        @endforeach
                    </div>

                    <!-- Legend -->
                    <div class="pt-3 border-t border-slate-800 grid grid-cols-2 gap-2 text-[11px] text-slate-400">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-emerald-600"></span>
                            <span>Sudah Terjawab</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-amber-500"></span>
                            <span>Ragu-ragu (🚩)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-japan-600 ring-1 ring-red-400"></span>
                            <span>Soal Aktif</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-slate-800 border border-slate-700"></span>
                            <span>Belum Dijawab</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Result Screen Card (Hidden Initially) -->
        <div id="resultCard" class="hidden bg-white text-slate-900 rounded-3xl p-6 sm:p-10 shadow-2xl border border-red-100 space-y-8 animate-fadeIn relative">
            
            <!-- Confetti Canvas Overlay -->
            <canvas id="confettiCanvas" class="absolute inset-0 pointer-events-none z-20 w-full h-full"></canvas>

            <div class="text-center space-y-3 max-w-xl mx-auto relative z-10">
                <div id="passBadge" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-black mb-2 bg-emerald-100 text-emerald-800 border border-emerald-300">
                    <i data-lucide="award" class="w-4 h-4 text-emerald-600"></i>
                    <span>Hasil Evaluasi Ujian</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900">
                    Rekapitulasi Nilai Ujian {{ $selectedLevel === 'all' ? '100 Soal Lengkap' : $selectedLevel }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-600">
                    Berikut adalah hasil analisis skor dan kunci pembahasan lengkap dari simulasi ujian Anda.
                </p>
            </div>

            <!-- Authentic Japanese Goukaku Certificate of Merit (Shown if passed) -->
            <div id="certificateContainer" class="hidden max-w-2xl mx-auto p-6 sm:p-8 rounded-3xl border-4 border-amber-500/50 bg-gradient-to-br from-amber-50/70 via-white to-amber-50/50 shadow-2xl relative overflow-hidden text-center space-y-4">
                <div class="absolute -top-12 -right-12 w-36 h-36 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-12 -left-12 w-36 h-36 bg-red-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Certificate Header -->
                <div class="space-y-1.5">
                    <p class="font-japanese font-black text-amber-700 tracking-widest text-xs uppercase">日本学修了認定証 • CERTIFICATE OF MERIT</p>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900 font-japanese">合格認定証 (GOUKAKU CERTIFICATE)</h3>
                    <p class="text-xs text-slate-600">Diberikan sebagai pengakuan pencapaian standar kompetensi bahasa Jepang</p>
                </div>

                <div class="py-3 px-4 rounded-2xl bg-white/90 border border-amber-200/80 shadow-xs flex items-center justify-around text-center">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Tingkat Ujian</span>
                        <strong class="text-sm font-black text-japan-600 font-japanese">Level {{ $selectedLevel }}</strong>
                    </div>
                    <div class="h-8 w-px bg-slate-200"></div>
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Skor Kelulusan</span>
                        <strong class="text-sm font-black text-emerald-600 font-mono" id="certScoreDisplay">0 / 0</strong>
                    </div>
                    <div class="h-8 w-px bg-slate-200"></div>
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Status</span>
                        <strong class="text-sm font-black text-japan-700 font-japanese">合格 (LULUS)</strong>
                    </div>
                </div>

                <!-- Certificate Seal & Stamp -->
                <div class="flex items-center justify-between pt-2 px-2">
                    <div class="text-left text-[11px] text-slate-600 leading-snug">
                        <p class="font-bold text-slate-900">LPK Sahabat Jepang Indonesia</p>
                        <p class="text-[10px] text-slate-500">Izin Kemenaker RI: KEP.224/LATTAS/XII/2023</p>
                        <p class="text-[10px] text-slate-400 mt-1">Tanggal Verifikasi: <span id="certDateDisplay">{{ date('d F Y') }}</span></p>
                    </div>

                    <!-- Official Japanese Hanko Goukaku Stamp -->
                    <div class="hanko-stamp flex-shrink-0" style="width: 76px; height: 76px; border-width: 2.5px;" title="Official Goukaku Seal">
                        <span style="font-size: 8px;">友好日本</span>
                        <span class="hanko-center" style="font-size: 13px;">合格</span>
                        <span style="font-size: 7.5px;">認定済</span>
                    </div>
                </div>

                <!-- Print / Share buttons -->
                <div class="flex flex-wrap items-center justify-center gap-2 pt-2 print:hidden">
                    <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center gap-1.5 shadow-sm transition active:scale-[0.97]">
                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                        <span>Cetak Sertifikat</span>
                    </button>
                    <button type="button" onclick="shareScoreToWA()" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 shadow-sm transition active:scale-[0.97]">
                        <i data-lucide="share-2" class="w-3.5 h-3.5"></i>
                        <span>Bagikan ke WhatsApp</span>
                    </button>
                </div>
            </div>

            <!-- Score Stats Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-3xl mx-auto">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="text-[11px] font-bold text-slate-400 uppercase">Skor Anda</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-japan-600 mt-1" id="resEarnedPoints">0</h3>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="text-[11px] font-bold text-slate-400 uppercase">Total Poin</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1" id="resTotalPoints">100</h3>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="text-[11px] font-bold text-slate-400 uppercase">Persentase</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-blue-600 mt-1" id="resPercentage">0%</h3>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="text-[11px] font-bold text-slate-400 uppercase">Benar / Salah</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1" id="resCounts">0 / 0</h3>
                </div>
            </div>

            <!-- CTA Next Steps -->
            <div class="p-6 rounded-3xl bg-gradient-to-r from-japan-900 via-japan-800 to-red-700 text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
                <div class="space-y-1 text-center sm:text-left">
                    <h4 class="font-extrabold text-base sm:text-lg text-white">Ingin Mematangkan Persiapan & Langsung Kerja ke Jepang?</h4>
                    <p class="text-xs text-red-100">Konsultasikan hasil nilai Anda dengan Sensei LPK Sahabat Jepang Indonesia untuk percepatan kelas.</p>
                </div>
                <button onclick="openModal('consultationModal')" class="px-6 py-3 rounded-2xl bg-white text-japan-700 hover:bg-red-50 font-black text-xs sm:text-sm whitespace-nowrap shadow-md transition flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                    <span>Daftar Konsultasi Kelas</span>
                </button>
            </div>

            <!-- Detailed Answers & Explanations Accordion -->
            <div class="space-y-4">
                <div class="border-b border-slate-200 pb-3 flex items-center justify-between">
                    <h3 class="font-extrabold text-slate-900 text-base flex items-center gap-2">
                        <i data-lucide="book-open" class="w-4 h-4 text-japan-600"></i>
                        <span>Kunci Jawaban & Pembahasan Lengkap</span>
                    </h3>
                    <span class="text-xs font-bold text-slate-400">Pembahasan Tiap Nomor</span>
                </div>

                <div class="space-y-3" id="explanationsList">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>

            <div class="text-center pt-4">
                <a href="{{ route('exam.simulator', ['level' => $selectedLevel]) }}" class="px-6 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-100 font-bold text-xs inline-flex items-center gap-2">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    <span>Ulangi Simulasi Ujian Ini</span>
                </a>
            </div>

        </div>

    </div>
</div>

<script>
    const questionsData = @json($questions);
    let currentIndex = 0;
    let userAnswers = {}; // { questionId: 'A' }
    let flaggedQuestions = {}; // { questionId: true }
    let totalMinutes = Math.max(30, Math.ceil(questionsData.length * 1.2));
    let timerSeconds = totalMinutes * 60;
    let timerInterval = null;
    let isTimerStarted = false;
    let finalResultData = null;

    function startTimer() {
        if (isTimerStarted) return;
        isTimerStarted = true;

        timerInterval = setInterval(() => {
            if (timerSeconds <= 0) {
                clearInterval(timerInterval);
                finishExam();
                return;
            }
            timerSeconds--;
            const mins = Math.floor(timerSeconds / 60);
            const secs = timerSeconds % 60;
            document.getElementById('timerDisplay').innerText = 
                `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }, 1000);
    }

    function renderQuestion(idx) {
        currentIndex = idx;
        const q = questionsData[idx];
        if (!q) return;

        // Animate question transition
        const qCard = document.getElementById('questionCard');
        if (qCard) {
            qCard.classList.add('opacity-80', 'scale-[0.99]');
            setTimeout(() => {
                qCard.classList.remove('opacity-80', 'scale-[0.99]');
            }, 120);
        }

        // Meta tags
        document.getElementById('currentQNumBadge').innerText = idx + 1;
        document.getElementById('currentQIndexText').innerText = idx + 1;
        document.getElementById('currentQSection').innerText = q.section || 'Kotoba';

        // Flag status
        const isFlagged = !!flaggedQuestions[q.id];
        const flagIndicator = document.getElementById('flagIndicator');
        const flagBtnText = document.getElementById('flagBtnText');
        const btnFlagQ = document.getElementById('btnFlagQ');

        if (isFlagged) {
            flagIndicator.classList.remove('hidden');
            flagIndicator.classList.add('inline-flex');
            flagBtnText.innerText = 'Batal Ragu';
            btnFlagQ.className = 'px-3.5 py-2.5 rounded-xl border border-amber-500 bg-amber-500 text-white font-bold text-xs flex items-center gap-1.5 transition active:scale-[0.97] shadow-sm';
        } else {
            flagIndicator.classList.add('hidden');
            flagIndicator.classList.remove('inline-flex');
            flagBtnText.innerText = 'Ragu-ragu';
            btnFlagQ.className = 'px-3.5 py-2.5 rounded-xl border border-amber-300 bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold text-xs flex items-center gap-1.5 transition active:scale-[0.97]';
        }

        // Title & Japanese
        document.getElementById('questionTitle').innerText = q.question;
        const jpBox = document.getElementById('questionJapaneseBox');
        if (q.question_japanese) {
            jpBox.innerText = q.question_japanese;
            jpBox.classList.remove('hidden');
        } else {
            jpBox.classList.add('hidden');
        }

        // Render options
        const optionsContainer = document.getElementById('optionsContainer');
        optionsContainer.innerHTML = '';

        const opts = { 'A': q.option_a, 'B': q.option_b, 'C': q.option_c, 'D': q.option_d };
        const selectedOpt = userAnswers[q.id];

        for (const [k, v] of Object.entries(opts)) {
            if (!v) continue;
            const isSel = (selectedOpt === k);
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.onclick = () => selectAnswer(k);
            btn.className = `option-btn w-full p-4 rounded-2xl border-2 text-left font-semibold text-xs sm:text-sm flex items-center gap-3.5 transition group active:scale-[0.99] ${
                isSel ? 'border-japan-600 bg-red-50/80 text-japan-900 shadow-md ring-2 ring-red-400/30' : 'border-slate-200 hover:border-japan-600 hover:bg-red-50/40 text-slate-800'
            }`;
            btn.innerHTML = `
                <span class="w-8 h-8 rounded-xl font-black text-xs flex items-center justify-center flex-shrink-0 transition ${
                    isSel ? 'bg-japan-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 group-hover:bg-japan-100 group-hover:text-japan-700'
                }">${k}</span>
                <span class="flex-1 font-japanese font-bold text-sm sm:text-base ${isSel ? 'text-japan-900' : 'text-slate-800'}">${v}</span>
            `;
            optionsContainer.appendChild(btn);
        }

        // Prev & Next Buttons state
        document.getElementById('btnPrevQ').disabled = (idx === 0);
        document.getElementById('btnNextQ').innerHTML = (idx === questionsData.length - 1) 
            ? '<span>Selesai</span><i data-lucide="check" class="w-4 h-4"></i>' 
            : '<span>Selanjutnya</span><i data-lucide="chevron-right" class="w-4 h-4"></i>';

        // Update nav grid highlight
        document.querySelectorAll('.nav-q-btn').forEach((btn, i) => {
            const qId = questionsData[i]?.id;
            const isAns = !!userAnswers[qId];
            const isFlg = !!flaggedQuestions[qId];

            let badgeHtml = `<span>${i + 1}</span>`;
            if (isFlg) {
                badgeHtml += `<span class="absolute -top-1 -right-1 text-[10px]">🚩</span>`;
            }

            btn.innerHTML = badgeHtml;

            if (i === idx) {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center relative transition bg-japan-600 text-white ring-2 ring-red-400 shadow-md';
            } else if (isFlg) {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center relative transition bg-amber-500 text-white shadow-xs';
            } else if (isAns) {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center relative transition bg-emerald-600 text-white';
            } else {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center relative transition bg-slate-800 text-slate-300 hover:bg-slate-700';
            }
        });

        lucide.createIcons();
    }

    function selectAnswer(optKey) {
        startTimer();
        const q = questionsData[currentIndex];
        userAnswers[q.id] = optKey;
        
        // Update answered count
        const ansCount = Object.keys(userAnswers).length;
        document.getElementById('answeredCountText').innerText = `${ansCount} / ${questionsData.length} Terjawab`;

        renderQuestion(currentIndex);
    }

    function toggleFlag() {
        const q = questionsData[currentIndex];
        if (!q) return;

        if (flaggedQuestions[q.id]) {
            delete flaggedQuestions[q.id];
        } else {
            flaggedQuestions[q.id] = true;
        }

        renderQuestion(currentIndex);
    }

    function prevQuestion() {
        if (currentIndex > 0) {
            renderQuestion(currentIndex - 1);
        }
    }

    function nextQuestion() {
        if (currentIndex < questionsData.length - 1) {
            renderQuestion(currentIndex + 1);
        } else {
            confirmFinishExam();
        }
    }

    function goToQuestion(idx) {
        renderQuestion(idx);
    }

    // Keyboard Shortcuts (A-D, 1-4, Left, Right, R)
    window.addEventListener('keydown', (e) => {
        // Ignore if focus is in an input or textarea
        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) return;
        // Ignore if exam is finished
        if (document.getElementById('examContainer').classList.contains('hidden')) return;

        const key = e.key.toUpperCase();

        if (key === 'A' || key === '1') selectAnswer('A');
        else if (key === 'B' || key === '2') selectAnswer('B');
        else if (key === 'C' || key === '3') selectAnswer('C');
        else if (key === 'D' || key === '4') selectAnswer('D');
        else if (key === 'R' || key === 'F') toggleFlag();
        else if (e.key === 'ArrowLeft') prevQuestion();
        else if (e.key === 'ArrowRight') nextQuestion();
    });

    function confirmFinishExam() {
        const total = questionsData.length;
        const answered = Object.keys(userAnswers).length;
        const flagged = Object.keys(flaggedQuestions).length;

        if (answered < total || flagged > 0) {
            const message = `Peringatan Evaluasi:\n- Soal terjawab: ${answered} dari ${total}\n- Soal belum dijawab: ${total - answered}\n- Soal ragu-ragu: ${flagged}\n\nApakah Anda yakin ingin mengumpulkan dan menilai sekarang?`;
            if (confirm(message)) {
                finishExam();
            }
        } else {
            if (confirm('Apakah Anda yakin ingin mengumpulkan seluruh lembar ujian?')) {
                finishExam();
            }
        }
    }

    async function finishExam() {
        if (timerInterval) clearInterval(timerInterval);

        try {
            const res = await fetch("{{ route('exam.simulator.evaluate') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    level: '{{ $selectedLevel }}',
                    answers: userAnswers
                })
            });

            const data = await res.json();
            if (data.status === 'success') {
                finalResultData = data;
                document.getElementById('examContainer').classList.add('hidden');
                const resultCard = document.getElementById('resultCard');
                resultCard.classList.remove('hidden');

                document.getElementById('resEarnedPoints').innerText = data.earned_points;
                document.getElementById('resTotalPoints').innerText = data.total_points;
                document.getElementById('resPercentage').innerText = `${data.percentage}%`;
                document.getElementById('resCounts').innerText = `${data.correct_count} / ${data.wrong_count}`;

                const passBadge = document.getElementById('passBadge');
                const certContainer = document.getElementById('certificateContainer');

                if (data.is_passed) {
                    passBadge.className = 'inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-black mb-2 bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-xs';
                    passBadge.innerHTML = '<i data-lucide="award" class="w-4 h-4 text-emerald-600"></i><span>SELAMAT, ANDA LULUS STANDAR JLPT! (合格)</span>';
                    
                    // Show Goukaku Certificate
                    if (certContainer) {
                        certContainer.classList.remove('hidden');
                        document.getElementById('certScoreDisplay').innerText = `${data.earned_points} / ${data.total_points} (${data.percentage}%)`;
                    }

                    // Fire Japanese Celebratory Confetti
                    fireJapaneseConfetti();
                } else {
                    passBadge.className = 'inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-black mb-2 bg-amber-100 text-amber-800 border border-amber-300';
                    passBadge.innerHTML = '<i data-lucide="alert-circle" class="w-4 h-4 text-amber-600"></i><span>BELUM LULUS (Perlu Penguatan Kosakata & Bunpou)</span>';
                    if (certContainer) certContainer.classList.add('hidden');
                }

                // Render Explanations Accordion
                const list = document.getElementById('explanationsList');
                list.innerHTML = '';

                data.details.forEach((item, idx) => {
                    const row = document.createElement('div');
                    row.className = `p-4 rounded-2xl border ${item.is_correct ? 'border-emerald-200 bg-emerald-50/40' : 'border-rose-200 bg-rose-50/40'} space-y-2`;
                    row.innerHTML = `
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg ${item.is_correct ? 'bg-emerald-600' : 'bg-rose-600'} text-white flex items-center justify-center font-bold text-xs">${idx + 1}</span>
                                <span class="text-slate-900">${item.section}</span>
                            </span>
                            <span class="${item.is_correct ? 'text-emerald-700' : 'text-rose-700'} font-bold">
                                ${item.is_correct ? '✓ Benar (+ ' + item.points + ' Poin)' : '✗ Salah (0 Poin)'}
                            </span>
                        </div>
                        <p class="text-sm font-bold text-slate-800">${item.question}</p>
                        ${item.question_japanese ? `<p class="text-sm font-japanese font-bold text-japan-700">${item.question_japanese}</p>` : ''}
                        <div class="pt-2 text-xs space-y-1 text-slate-600">
                            <p><strong>Jawaban Anda:</strong> ${item.user_answer || '(Tidak dijawab)'}</p>
                            <p class="text-emerald-800 font-bold"><strong>Kunci Jawaban Benar:</strong> Opsi ${item.correct_answer}</p>
                            <p class="text-slate-500 italic bg-white p-2.5 rounded-xl border border-slate-200 mt-1">
                                💡 <strong>Pembahasan:</strong> ${item.explanation || 'Tidak ada pembahasan khusus.'}
                            </p>
                        </div>
                    `;
                    list.appendChild(row);
                });

                lucide.createIcons();
                window.scrollTo({ top: resultCard.offsetTop - 80, behavior: 'smooth' });
            }
        } catch (e) {
            console.error(e);
            alert('Gagal memproses hasil ujian.');
        }
    }

    function shareScoreToWA() {
        if (!finalResultData) return;
        const lvl = '{{ $selectedLevel }}';
        const msg = encodeURIComponent(`Halo Sensei LPK Sahabat Jepang Indonesia! Saya baru saja menyelesaikan Tryout JLPT CBT Online Level ${lvl} dengan hasil:\n- Skor: ${finalResultData.earned_points} / ${finalResultData.total_points} (${finalResultData.percentage}%)\n- Status: ${finalResultData.is_passed ? 'LULUS (合格)' : 'Perlu Bimbingan'}\n\nSaya ingin konsultasi persiapan kelas dan percepatan penempatan kerja ke Jepang.`);
        window.open(`https://api.whatsapp.com/send?phone=6281234567890&text=${msg}`, '_blank');
    }

    // Canvas Confetti Celebration
    function fireJapaneseConfetti() {
        const canvas = document.getElementById('confettiCanvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        canvas.width = canvas.parentElement.offsetWidth;
        canvas.height = canvas.parentElement.offsetHeight;

        const colors = ['#DC2626', '#E11D48', '#F59E0B', '#10B981', '#3B82F6', '#FFD1DC'];
        const pieces = [];
        const count = 75;

        for (let i = 0; i < count; i++) {
            pieces.push({
                x: Math.random() * canvas.width,
                y: Math.random() * -canvas.height * 0.5,
                size: Math.random() * 8 + 6,
                color: colors[Math.floor(Math.random() * colors.length)],
                vx: Math.random() * 4 - 2,
                vy: Math.random() * 3 + 2,
                rot: Math.random() * 360,
                rotSpeed: Math.random() * 4 - 2
            });
        }

        let frames = 0;
        function renderConfetti() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            pieces.forEach(p => {
                p.x += p.vx;
                p.y += p.vy;
                p.rot += p.rotSpeed;

                ctx.save();
                ctx.translate(p.x, p.y);
                ctx.rotate((p.rot * Math.PI) / 180);
                ctx.fillStyle = p.color;
                ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.6);
                ctx.restore();
            });

            frames++;
            if (frames < 180) {
                requestAnimationFrame(renderConfetti);
            } else {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
        }
        requestAnimationFrame(renderConfetti);
    }
</script>
@endsection
