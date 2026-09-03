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
                
                <div class="bg-white text-slate-900 rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200 min-h-[480px] flex flex-col justify-between relative">
                    
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
                        <div class="space-y-3 mb-6">
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
                                        class="option-btn w-full p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/40 text-left font-semibold text-xs sm:text-sm text-slate-800 flex items-center gap-3.5 transition group"
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

                    <!-- Bottom Nav Actions -->
                    <div class="flex items-center justify-between border-t border-slate-100 pt-5 mt-8">
                        <button 
                            type="button" 
                            id="btnPrevQ" 
                            onclick="prevQuestion()" 
                            disabled
                            class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-bold text-xs flex items-center gap-1.5 transition"
                        >
                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            <span>Sebelumnya</span>
                        </button>

                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                onclick="finishExam()" 
                                class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 shadow-md shadow-emerald-600/30 transition"
                            >
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                <span>Kumpulkan Ujian</span>
                            </button>

                            <button 
                                type="button" 
                                id="btnNextQ" 
                                onclick="nextQuestion()" 
                                class="btn-red-primary px-6 py-2.5 rounded-xl font-bold text-xs flex items-center gap-1.5 shadow-md shadow-red-600/30"
                            >
                                <span>Selanjutnya</span>
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

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
                    <div class="grid grid-cols-5 gap-2 max-h-60 overflow-y-auto pr-1" id="questionNavGrid">
                        @foreach($questions as $idx => $q)
                            <button 
                                type="button" 
                                onclick="goToQuestion({{ $idx }})" 
                                id="navBtn_{{ $idx }}"
                                class="nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center transition {{ $idx === 0 ? 'bg-japan-600 text-white ring-2 ring-red-400' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}"
                            >
                                {{ $idx + 1 }}
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
                            <span class="w-3 h-3 rounded bg-slate-800 border border-slate-700"></span>
                            <span>Belum Dijawab</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Result Screen Card (Hidden Initially) -->
        <div id="resultCard" class="hidden bg-white text-slate-900 rounded-3xl p-6 sm:p-10 shadow-2xl border border-red-100 space-y-8 animate-fadeIn">
            
            <div class="text-center space-y-3 max-w-xl mx-auto">
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
    let totalMinutes = Math.max(30, Math.ceil(questionsData.length * 1.2));
    let timerSeconds = totalMinutes * 60;
    let timerInterval = null;
    let isTimerStarted = false;

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

        // Meta tags
        document.getElementById('currentQNumBadge').innerText = idx + 1;
        document.getElementById('currentQIndexText').innerText = idx + 1;
        document.getElementById('currentQSection').innerText = q.section || 'Kotoba';

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
            btn.className = `option-btn w-full p-4 rounded-2xl border-2 text-left font-semibold text-xs sm:text-sm flex items-center gap-3.5 transition group ${
                isSel ? 'border-japan-600 bg-red-50 text-japan-900 shadow-sm' : 'border-slate-200 hover:border-japan-600 hover:bg-red-50/40 text-slate-800'
            }`;
            btn.innerHTML = `
                <span class="w-8 h-8 rounded-xl font-black text-xs flex items-center justify-center flex-shrink-0 transition ${
                    isSel ? 'bg-japan-600 text-white' : 'bg-slate-100 text-slate-700 group-hover:bg-japan-100 group-hover:text-japan-700'
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
            const isAns = !!userAnswers[questionsData[i]?.id];
            if (i === idx) {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center transition bg-japan-600 text-white ring-2 ring-red-400';
            } else if (isAns) {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center transition bg-emerald-600 text-white';
            } else {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center transition bg-slate-800 text-slate-300 hover:bg-slate-700';
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

    function prevQuestion() {
        if (currentIndex > 0) {
            renderQuestion(currentIndex - 1);
        }
    }

    function nextQuestion() {
        if (currentIndex < questionsData.length - 1) {
            renderQuestion(currentIndex + 1);
        } else {
            finishExam();
        }
    }

    function goToQuestion(idx) {
        renderQuestion(idx);
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
                document.getElementById('examContainer').classList.add('hidden');
                const resultCard = document.getElementById('resultCard');
                resultCard.classList.remove('hidden');

                document.getElementById('resEarnedPoints').innerText = data.earned_points;
                document.getElementById('resTotalPoints').innerText = data.total_points;
                document.getElementById('resPercentage').innerText = `${data.percentage}%`;
                document.getElementById('resCounts').innerText = `${data.correct_count} / ${data.wrong_count}`;

                const passBadge = document.getElementById('passBadge');
                if (data.is_passed) {
                    passBadge.className = 'inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-black mb-2 bg-emerald-100 text-emerald-800 border border-emerald-300';
                    passBadge.innerHTML = '<i data-lucide="award" class="w-4 h-4 text-emerald-600"></i><span>SELAMAT, ANDA LULUS STANDAR JLPT! (合格)</span>';
                } else {
                    passBadge.className = 'inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-black mb-2 bg-amber-100 text-amber-800 border border-amber-300';
                    passBadge.innerHTML = '<i data-lucide="alert-circle" class="w-4 h-4 text-amber-600"></i><span>BELUM LULUS (Perlu Penguatan Kosakata & Bunpou)</span>';
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
</script>
@endsection
