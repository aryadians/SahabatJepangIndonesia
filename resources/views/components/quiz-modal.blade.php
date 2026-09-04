<!-- Interactive Program Matchmaker Quiz Modal -->
<div id="quizModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <!-- Backdrop -->
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('quizModal')"></div>

    <!-- Modal Content Box -->
    <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-red-100/80 overflow-hidden modal-content-box z-10 flex flex-col max-h-[90vh]">
        
        <!-- Modal Header -->
        <div class="relative bg-gradient-to-r from-japan-900 via-japan-700 to-japan-800 text-white p-6 sm:p-7">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-amber-300 font-bold border border-white/20">
                        <i data-lucide="compass" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base sm:text-lg font-black text-white">Tes Kecocokan Program Karir Jepang</h3>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-slate-950 uppercase">30 Detik</span>
                        </div>
                        <p class="text-xs text-red-100/80">Temukan jalur kerja ke Jepang yang paling sesuai dengan profil Anda</p>
                    </div>
                </div>

                <button 
                    onclick="closeModal('quizModal')"
                    class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition"
                >
                    &times;
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="mt-4 bg-black/20 h-2 rounded-full overflow-hidden">
                <div id="quizProgressBar" class="h-full bg-gradient-to-r from-amber-300 to-amber-500 transition-all duration-300 w-1/4"></div>
            </div>
            <div class="flex justify-between text-[11px] text-red-200 mt-1 font-medium">
                <span id="quizStepText">Langkah 1 dari 4: Usia</span>
                <span id="quizPercentText">25%</span>
            </div>
        </div>

        <!-- Modal Body (Questions & Result) -->
        <div class="p-6 sm:p-8 overflow-y-auto flex-1 space-y-6">
            
            <!-- STEP 1: Usia -->
            <div id="quizStep1" class="quiz-step space-y-4">
                <div class="text-center sm:text-left">
                    <span class="text-xs font-bold text-japan-600 uppercase tracking-wider">Pertanyaan 1</span>
                    <h4 class="text-lg font-black text-slate-900 mt-0.5">Berapa rentang usia Anda saat ini?</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <button type="button" onclick="selectQuizAnswer('age', '18-25', 2)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">18 - 25 Tahun</p>
                            <p class="text-xs text-slate-400">Usia emas seluruh program</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('age', '26-30', 2)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">26 - 30 Tahun</p>
                            <p class="text-xs text-slate-400">Sangat potensial SSW & Engineer</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('age', '31-35', 2)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">31 - 35 Tahun</p>
                            <p class="text-xs text-slate-400">Jalur Tokutei Ginou / Kaigo</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('age', '36+', 2)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Di atas 35 Tahun</p>
                            <p class="text-xs text-slate-400">Jalur Khusus Skill / Kursus</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 2: Pendidikan -->
            <div id="quizStep2" class="quiz-step hidden space-y-4">
                <div class="text-center sm:text-left">
                    <span class="text-xs font-bold text-japan-600 uppercase tracking-wider">Pertanyaan 2</span>
                    <h4 class="text-lg font-black text-slate-900 mt-0.5">Apa jenjang pendidikan terakhir Anda?</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <button type="button" onclick="selectQuizAnswer('education', 'SMA/SMK', 3)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">SMA / SMK Sederajat</p>
                            <p class="text-xs text-slate-400">Semua jurusan diterima</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('education', 'Diploma D3', 3)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Diploma (D1 - D3)</p>
                            <p class="text-xs text-slate-400">Kesehatan / Teknik / Umum</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('education', 'Sarjana S1', 3)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Sarjana (S1 / D4)</p>
                            <p class="text-xs text-slate-400">Peluang Karir Engineer & Visa Kerja</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('education', 'SMP', 3)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group active:scale-[0.98]">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">SMP / Lainnya</p>
                            <p class="text-xs text-slate-400">Konsultasi jalur kejar paket</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="prevQuizStep(1)" class="text-xs font-bold text-slate-400 hover:text-slate-700 flex items-center gap-1 transition">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        <span>Kembali ke pertanyaan sebelumnya</span>
                    </button>
                </div>
            </div>

            <!-- STEP 3: Pengalaman Bahasa Jepang -->
            <div id="quizStep3" class="quiz-step hidden space-y-4">
                <div class="text-center sm:text-left">
                    <span class="text-xs font-bold text-japan-600 uppercase tracking-wider">Pertanyaan 3</span>
                    <h4 class="text-lg font-black text-slate-900 mt-0.5">Kemampuan Bahasa Jepang saat ini?</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <button type="button" onclick="selectQuizAnswer('japanese', 'Nol / Pemula', 4)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group active:scale-[0.98]">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Nol / Belum Pernah Belajar</p>
                            <p class="text-xs text-slate-400">90% siswa mulai dari tahap ini</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('japanese', 'Dasar N5', 4)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group active:scale-[0.98]">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Dasar (Hiragana / N5)</p>
                            <p class="text-xs text-slate-400">Bisa membaca huruf dasar</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('japanese', 'N4 / JFT A2', 4)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group active:scale-[0.98]">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Level N4 / JFT-Basic A2</p>
                            <p class="text-xs text-slate-400">Siap matching wawancara kerja</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('japanese', 'N3 / N2', 4)" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group active:scale-[0.98]">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Menengah / Mahir (N3 / N2)</p>
                            <p class="text-xs text-slate-400">Jalur ekspres karir profesional</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="prevQuizStep(2)" class="text-xs font-bold text-slate-400 hover:text-slate-700 flex items-center gap-1 transition">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        <span>Kembali ke pertanyaan sebelumnya</span>
                    </button>
                </div>
            </div>

            <!-- STEP 4: Bidang Sektor Minat -->
            <div id="quizStep4" class="quiz-step hidden space-y-4">
                <div class="text-center sm:text-left">
                    <span class="text-xs font-bold text-japan-600 uppercase tracking-wider">Pertanyaan 4 (Terakhir)</span>
                    <h4 class="text-lg font-black text-slate-900 mt-0.5">Bidang pekerjaan apa yang paling Anda sukai?</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <button type="button" onclick="selectQuizAnswer('sector', 'Pengolahan Makanan & Restoran', 'result')" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group active:scale-[0.98]">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Pengolahan Makanan / F&B</p>
                            <p class="text-xs text-slate-400">Pabrik bento, bakery, restoran</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('sector', 'Kaigo (Caregiver / Perawat Lansia)', 'result')" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group active:scale-[0.98]">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Kaigo (Caregiver)</p>
                            <p class="text-xs text-slate-400">Paling banyak kuota & bonus besar</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('sector', 'Manufaktur, Otomotif & Mesin', 'result')" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group active:scale-[0.98]">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">Manufaktur & Otomotif</p>
                            <p class="text-xs text-slate-400">Pabrik mobil, elektronik, welding</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>

                    <button type="button" onclick="selectQuizAnswer('sector', 'IT, Teknik & Engineering', 'result')" class="quiz-opt-btn p-4 rounded-2xl border-2 border-slate-200 hover:border-japan-600 hover:bg-red-50/50 text-left transition flex items-center justify-between group active:scale-[0.98]">
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm group-hover:text-japan-700">IT & Engineering</p>
                            <p class="text-xs text-slate-400">Programmer, CAD drafter, teknisi</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-japan-600"></i>
                    </button>
                </div>

                <div class="pt-2">
                    <button type="button" onclick="prevQuizStep(3)" class="text-xs font-bold text-slate-400 hover:text-slate-700 flex items-center gap-1 transition">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        <span>Kembali ke pertanyaan sebelumnya</span>
                    </button>
                </div>
            </div>

            <!-- RESULT SCREEN -->
            <div id="quizResultScreen" class="hidden space-y-6 text-center">
                
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Tingkat Kelayakan: 96% Sangat Direkomendasikan</span>
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hasil Rekomendasi Program Terbaik Anda:</p>
                    <h3 id="quizResultProgramTitle" class="text-2xl sm:text-3xl font-black text-japan-700 mt-1">
                        Tokutei Ginou (SSW) - Pengolahan Makanan
                    </h3>
                    <p id="quizResultProgramDesc" class="text-xs sm:text-sm text-slate-600 max-w-lg mx-auto mt-2 leading-relaxed">
                        Profil Anda sangat cocok untuk mengikuti program Tokutei Ginou dengan potensi penghasilan Rp 19 - 27 Juta/bulan dan penempatan kerja resmi.
                    </p>
                </div>

                <!-- Highlight Benefit Box -->
                <div class="grid grid-cols-2 gap-3 max-w-md mx-auto text-left">
                    <div class="p-3.5 rounded-2xl bg-red-50 border border-red-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Estimasi Gaji</p>
                        <p id="quizResultSalary" class="text-sm font-black text-slate-900 mt-0.5">¥ 190.000 - 250.000</p>
                        <p class="text-[10px] text-japan-600 font-bold">± Rp 20 - 27 Jt/bln</p>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Estimasi Waktu</p>
                        <p class="text-sm font-black text-slate-900 mt-0.5">4 - 6 Bulan</p>
                        <p class="text-[10px] text-slate-500 font-medium">Pelatihan s/d Terbang</p>
                    </div>
                </div>

                <!-- CTA Actions -->
                <div class="space-y-3 pt-2 max-w-md mx-auto">
                    <button 
                        id="quizApplyBtn" 
                        onclick="claimQuizRecommendation()"
                        class="w-full btn-red-primary py-3.5 rounded-2xl font-bold text-sm shadow-xl flex items-center justify-center gap-2 active:scale-[0.98]"
                    >
                        <i data-lucide="sparkles" class="w-5 h-5 text-amber-200"></i>
                        <span>Klaim Hasil & Buka Formulir</span>
                    </button>

                    <button 
                        type="button" 
                        onclick="shareQuizToWA()"
                        class="w-full py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-md shadow-emerald-600/30 transition active:scale-[0.98]"
                    >
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Kirim Hasil ke WhatsApp Sensei Sekarang</span>
                    </button>

                    <button 
                        type="button" 
                        onclick="resetQuiz()" 
                        class="text-xs font-bold text-slate-400 hover:text-slate-700 transition block mx-auto pt-1"
                    >
                        Ulangi Tes Dari Awal
                    </button>
                </div>

            </div>

        </div>

    </div>
</div>
