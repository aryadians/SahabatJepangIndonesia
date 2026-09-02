@extends('layouts.app')

@section('title', 'Simulasi Ujian JLPT & JFT-Basic CBT Online - LPK Sahabat Jepang Indonesia')

@section('content')
<div class="bg-slate-900 text-white min-h-screen py-8 sm:py-12 relative overflow-hidden">

    <!-- Ambient Japanese Red Glow Background -->
    <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-red-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-40 w-96 h-96 rounded-full bg-rose-600/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6">

        <!-- Header Banner -->
        <div class="bg-slate-800/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-slate-700 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold font-japanese">
                    <span>日本語能力試験 • CBT Simulator</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Simulasi Ujian JLPT & JFT-Basic Online
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl">
                    Uji kesiapan bahasa Jepang Anda secara gratis dan instan. Dilengkapi penilaian standar kelulusan resmi, kunci jawaban, dan pembahasan lengkap.
                </p>
            </div>

            <!-- Level Selector Pills -->
            <div class="flex flex-wrap items-center gap-2 bg-slate-900/90 p-1.5 rounded-2xl border border-slate-700/80">
                @foreach(['N5' => 'JLPT N5', 'N4' => 'JLPT N4', 'N3' => 'JLPT N3', 'JFT-Basic' => 'JFT A2'] as $lvl => $lbl)
                    <a 
                        href="{{ route('exam.simulator', ['level' => $lvl]) }}" 
                        class="px-3.5 py-2 rounded-xl text-xs font-extrabold transition {{ $selectedLevel === $lvl ? 'bg-japan-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}"
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
                
                <div class="bg-white text-slate-900 rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200 min-h-[460px] flex flex-col justify-between relative">
                    
                    <div>
                        <!-- Top Metadata & Section Badge -->
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-xl bg-red-100 text-japan-700 font-black text-xs flex items-center justify-center" id="currentQNumBadge">
                                    1
                                </span>
                                <div>
                                    <span class="text-xs font-bold text-slate-400 block uppercase" id="currentQSection">
                                        {{ $questions[0]->section ?? 'Kotoba' }}
                                    </span>
                                    <h4 class="text-xs font-bold text-japan-700 font-japanese">
                                        Tingkat {{ $selectedLevel }} ({{ $questions[0]->points ?? 10 }} Poin)
                                    </h4>
                                </div>
                            </div>

                            <span class="text-xs font-bold text-slate-400">
                                Soal <span id="currentQIndexText" class="text-slate-900 font-extrabold">1</span> dari {{ count($questions) }}
                            </span>
                        </div>

                        <!-- Question Text (With Japanese Furigana Support) -->
                        <div class="space-y-3 mb-6">
                            <h3 id="questionTitle" class="text-base sm:text-lg font-extrabold text-slate-900 leading-relaxed font-sans">
                                {{ $questions[0]->question ?? 'Memuat soal...' }}
                            </h3>
                            <div id="questionJapaneseBox" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 font-japanese text-sm sm:text-base font-bold leading-relaxed">
                                {{ $questions[0]->question_japanese ?? '' }}
                            </div>
                        </div>

                        <!-- Multiple Choice Options -->
                        <div class="space-y-2.5" id="optionsContainer">
                            @php
                                $firstQ = $questions[0] ?? null;
                            @endphp
                            @if($firstQ)
                                @foreach(['A' => $firstQ->option_a, 'B' => $firstQ->option_b, 'C' => $firstQ->option_c, 'D' => $firstQ->option_d] as $optKey => $optVal)
                                    <button 
                                        type="button" 
                                        onclick="selectAnswer('{{ $optKey }}')" 
                                        id="optBtn_{{ $optKey }}"
                                        class="option-btn w-full p-3.5 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left font-semibold text-xs sm:text-sm text-slate-800 flex items-center gap-3 transition"
                                    >
                                        <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs flex items-center justify-center flex-shrink-0 option-key">
                                            {{ $optKey }}
                                        </span>
                                        <span class="flex-1 font-japanese option-text">{{ $optVal }}</span>
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Bottom Nav Actions (Prev / Next / Finish) -->
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between">
                        <button 
                            type="button" 
                            id="btnPrevQ" 
                            onclick="prevQuestion()" 
                            class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold flex items-center gap-1.5 transition disabled:opacity-40 disabled:cursor-not-allowed"
                            disabled
                        >
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Sebelumnya</span>
                        </button>

                        <button 
                            type="button" 
                            id="btnNextQ" 
                            onclick="nextQuestion()" 
                            class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold flex items-center gap-1.5 transition shadow-sm"
                        >
                            <span>Selanjutnya</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>

                </div>

            </div>

            <!-- Right: Timer, Progress & Number Grid (4 Cols) -->
            <div class="lg:col-span-4 space-y-4">
                
                <!-- Timer Card -->
                <div class="bg-slate-800 rounded-3xl p-5 border border-slate-700 shadow-xl space-y-3 text-center">
                    <div class="flex items-center justify-center gap-2 text-xs font-bold text-slate-400 uppercase">
                        <i data-lucide="clock" class="w-4 h-4 text-red-400"></i>
                        <span>Sisa Waktu Pengerjaan</span>
                    </div>
                    <div id="timerDisplay" class="font-mono text-3xl sm:text-4xl font-black text-white tracking-widest text-japan-500">
                        15:00
                    </div>
                    <p class="text-[11px] text-slate-400">Waktu berjalan otomatis saat Anda mulai memilih jawaban.</p>
                </div>

                <!-- Number Grid Navigator -->
                <div class="bg-slate-800 rounded-3xl p-5 border border-slate-700 shadow-xl space-y-4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-extrabold text-white uppercase tracking-wider">Navigasi Soal</h4>
                        <span id="answeredCountText" class="text-[11px] text-red-400 font-bold">0 / {{ count($questions) }} Terjawab</span>
                    </div>

                    <div class="grid grid-cols-5 gap-2" id="questionNavGrid">
                        @foreach($questions as $idx => $q)
                            <button 
                                type="button" 
                                id="navBtn_{{ $idx }}" 
                                onclick="goToQuestion({{ $idx }})" 
                                class="nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center transition {{ $idx === 0 ? 'bg-japan-600 text-white ring-2 ring-red-400' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' }}"
                            >
                                {{ $idx + 1 }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Finish Exam Button -->
                    <div class="pt-2 border-t border-slate-700">
                        <button 
                            type="button" 
                            onclick="finishExam()" 
                            class="w-full btn-red-primary py-3 rounded-2xl text-xs font-black flex items-center justify-center gap-2 shadow-lg shadow-red-600/30"
                        >
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Selesai & Lihat Skor</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <!-- Result Evaluation Card (Hidden Initially) -->
        <div id="resultCard" class="hidden bg-white text-slate-900 rounded-3xl p-6 sm:p-10 shadow-2xl border border-red-100 space-y-8 animate-fadeIn">
            
            <div class="text-center space-y-3 border-b border-slate-100 pb-8">
                <div id="passBadge" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-black mb-2">
                    <!-- Dynamic -->
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Hasil Skor Simulasi Ujian JLPT {{ $selectedLevel }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto">
                    Evaluasi komprehensif kemampuan bahasa Jepang Anda untuk persiapan karir & kerja di Jepang.
                </p>

                <!-- Score Board -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 max-w-3xl mx-auto">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-slate-400 uppercase">Skor Diperoleh</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-japan-600 mt-1" id="resEarnedPoints">0</h3>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-slate-400 uppercase">Total Poin</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-800 mt-1" id="resTotalPoints">100</h3>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-slate-400 uppercase">Persentase</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-blue-600 mt-1" id="resPercentage">0%</h3>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-slate-400 uppercase">Benar / Salah</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1" id="resCounts">0 / 0</h3>
                    </div>
                </div>
            </div>

            <!-- Call to Action Banner -->
            <div class="p-6 rounded-3xl bg-gradient-to-r from-japan-900 via-japan-700 to-red-600 text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
                <div class="space-y-1">
                    <h3 class="font-extrabold text-lg text-white">Ingin Lolos JLPT / SSW dengan Skor Maksimal?</h3>
                    <p class="text-xs text-red-100">Ikuti pelatihan intensif bahasa & budaya Jepang bersama Sensei bersertifikasi N1/N2 di LPK SJI.</p>
                </div>
                <button onclick="openModal('consultationModal')" class="px-6 py-3 rounded-2xl bg-white text-japan-700 font-black text-xs hover:bg-red-50 transition shadow-md flex-shrink-0 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                    <span>Daftar Kelas Persiapan</span>
                </button>
            </div>

            <!-- Detailed Answers & Explanations Accordion -->
            <div class="space-y-4">
                <h3 class="font-extrabold text-slate-900 text-lg">Kunci Jawaban & Pembahasan Lengkap</h3>
                <div id="explanationsList" class="space-y-3">
                    <!-- Dynamic -->
                </div>
            </div>

            <!-- Retry Button -->
            <div class="text-center pt-4 border-t border-slate-100">
                <a href="{{ route('exam.simulator', ['level' => $selectedLevel]) }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    <span>Coba Ujian Kembali</span>
                </a>
            </div>

        </div>

    </div>
</div>

<script>
    const questionsData = @json($questions);
    let currentIndex = 0;
    const userAnswers = {}; // { question_id: 'A' }
    let timerSeconds = 15 * 60;
    let timerInterval = null;

    function startTimer() {
        if (timerInterval) return;
        timerInterval = setInterval(() => {
            if (timerSeconds <= 0) {
                clearInterval(timerInterval);
                finishExam();
                return;
            }
            timerSeconds--;
            const mins = Math.floor(timerSeconds / 60).toString().padStart(2, '0');
            const secs = (timerSeconds % 60).toString().padStart(2, '0');
            document.getElementById('timerDisplay').innerText = `${mins}:${secs}`;
        }, 1000);
    }

    function renderQuestion(idx) {
        if (!questionsData[idx]) return;
        currentIndex = idx;
        const q = questionsData[idx];

        document.getElementById('currentQNumBadge').innerText = idx + 1;
        document.getElementById('currentQIndexText').innerText = idx + 1;
        document.getElementById('currentQSection').innerText = q.section || 'Kotoba';
        document.getElementById('questionTitle').innerText = q.question;
        document.getElementById('questionJapaneseBox').innerText = q.question_japanese || '';

        const optionsContainer = document.getElementById('optionsContainer');
        optionsContainer.innerHTML = '';

        const opts = { 'A': q.option_a, 'B': q.option_b, 'C': q.option_c, 'D': q.option_d };
        const selected = userAnswers[q.id] || null;

        for (const [k, v] of Object.entries(opts)) {
            const isSel = selected === k;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.onclick = () => selectAnswer(k);
            btn.className = `option-btn w-full p-3.5 rounded-2xl border-2 text-left font-semibold text-xs sm:text-sm text-slate-800 flex items-center gap-3 transition ${
                isSel ? 'border-japan-600 bg-red-50 text-japan-700 shadow-sm' : 'border-slate-200 hover:border-japan-600 hover:bg-slate-50'
            }`;

            btn.innerHTML = `
                <span class="w-7 h-7 rounded-xl font-extrabold text-xs flex items-center justify-center flex-shrink-0 ${
                    isSel ? 'bg-japan-600 text-white' : 'bg-slate-100 text-slate-700'
                }">${k}</span>
                <span class="flex-1 font-japanese font-bold">${v}</span>
            `;
            optionsContainer.appendChild(btn);
        }

        // Prev & Next Buttons state
        document.getElementById('btnPrevQ').disabled = (idx === 0);
        document.getElementById('btnNextQ').innerText = (idx === questionsData.length - 1) ? 'Selesai' : 'Selanjutnya';

        // Update nav grid highlight
        document.querySelectorAll('.nav-q-btn').forEach((btn, i) => {
            const isAns = !!userAnswers[questionsData[i]?.id];
            if (i === idx) {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center transition bg-japan-600 text-white ring-2 ring-red-400';
            } else if (isAns) {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center transition bg-emerald-600 text-white';
            } else {
                btn.className = 'nav-q-btn h-10 rounded-xl font-bold text-xs flex items-center justify-center transition bg-slate-700 text-slate-300 hover:bg-slate-600';
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
