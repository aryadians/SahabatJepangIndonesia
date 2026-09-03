<!-- Interactive Salary & Savings Simulator Section -->
<section id="kalkulator" class="py-20 lg:py-28 bg-white relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute inset-0 bg-japanese-pattern opacity-30 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 space-y-3 reveal-on-scroll">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-bold uppercase tracking-wider">
                <span class="font-japanese text-sm">給与シミュレーション</span>
                <span>• Transparansi Finansial</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                Simulasi Penghasilan & <br class="hidden sm:inline">
                <span class="text-japan-600">Transparansi Biaya Program</span>
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Ketahui secara terbuka potensi penghasilan bulanan di Jepang serta rincian biaya pelatihan tanpa biaya tersembunyi.
            </p>

            <!-- Tab Switcher -->
            <div class="pt-4 flex items-center justify-center">
                <div class="inline-flex p-1.5 rounded-2xl bg-slate-100 border border-slate-200">
                    <button 
                        type="button" 
                        id="tabSalaryBtn" 
                        onclick="switchCalcTab('salary')" 
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold bg-white text-japan-700 shadow-sm transition"
                    >
                        💰 Simulasi Gaji & Tabungan
                    </button>
                    <button 
                        type="button" 
                        id="tabCostBtn" 
                        onclick="switchCalcTab('cost')" 
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 hover:text-slate-900 transition"
                    >
                        📋 Transparansi Biaya & Dana Talangan
                    </button>
                </div>
            </div>
        </div>

        <!-- TAB 1: SALARY & SAVINGS SIMULATOR -->
        <div id="salaryTabContent" class="max-w-5xl mx-auto rounded-3xl bg-gradient-to-br from-white via-red-50/40 to-white border border-red-200/80 shadow-2xl p-6 sm:p-10 reveal-scale">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left: Controls & Sliders -->
                <div class="lg:col-span-6 space-y-6">
                    
                    <div class="space-y-2">
                        <label for="calcSector" class="block text-sm font-bold text-slate-800">
                            Pilih Bidang Pekerjaan / Sektor
                        </label>
                        <select id="calcSector" class="w-full input-japan px-4 py-3 rounded-xl bg-white text-slate-800 text-sm font-semibold focus:ring-2 focus:ring-red-500">
                            <option value="225000">Tokutei Ginou - Kaigo (Caregiver) [¥225.000 / bln]</option>
                            <option value="210000" selected>Tokutei Ginou - Pengolahan Makanan [¥210.000 / bln]</option>
                            <option value="215000">Tokutei Ginou - Manufaktur & Mesin [¥215.000 / bln]</option>
                            <option value="200000">Tokutei Ginou - Pertanian Modern [¥200.000 / bln]</option>
                            <option value="230000">Tokutei Ginou - Konstruksi & Scaffolding [¥230.000 / bln]</option>
                            <option value="175000">Ginou Jisshusei - Magang Manufaktur/Pabrik [¥175.000 / bln]</option>
                            <option value="170000">Ginou Jisshusei - Magang Pertanian [¥170.000 / bln]</option>
                            <option value="270000">Engineer IT & Mekanikal Profesional [¥270.000 / bln]</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="calcPrefecture" class="block text-sm font-bold text-slate-800">
                            Wilayah / Prefektur Penempatan
                        </label>
                        <select id="calcPrefecture" class="w-full input-japan px-4 py-3 rounded-xl bg-white text-slate-800 text-sm font-semibold focus:ring-2 focus:ring-red-500">
                            <option value="1.12">Wilayah Kanto (Tokyo, Kanagawa, Chiba, Saitama) - Standar Gaji Tertinggi</option>
                            <option value="1.06" selected>Wilayah Kansai (Osaka, Kyoto, Hyogo/Kobe)</option>
                            <option value="1.04">Wilayah Chubu & Tokai (Aichi/Nagoya, Shizuoka, Gifu)</option>
                            <option value="1.00">Wilayah Kyushu (Fukuoka, Kumamoto, Saga)</option>
                            <option value="0.96">Wilayah Tohoku & Hokkaido</option>
                        </select>
                    </div>

                    <!-- Overtime Range Slider -->
                    <div class="space-y-3 pt-2">
                        <div class="flex items-center justify-between">
                            <label for="calcOvertime" class="text-sm font-bold text-slate-800">
                                Estimasi Lembur (Zangyou)
                            </label>
                            <span id="overtimeHoursDisplay" class="px-3 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-extrabold">
                                15 Jam / bln
                            </span>
                        </div>
                        <input 
                            type="range" 
                            id="calcOvertime" 
                            min="0" 
                            max="40" 
                            step="5" 
                            value="15" 
                            class="w-full h-2 bg-slate-200 rounded-lg cursor-pointer"
                        >
                        <div class="flex justify-between text-[11px] text-slate-400 font-medium">
                            <span>0 Jam (Standard)</span>
                            <span>20 Jam (Sedang)</span>
                            <span>40 Jam (Maksimal)</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200 text-xs text-amber-800 flex items-start gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5"></i>
                        <span>Kurs acuan estimasi dihitung pada <strong>1 JPY ≈ Rp 106,5</strong>. Potongan mencakup Pajak Penghasilan, Asuransi Kesehatan Jepang (Shakai Hoken), dan Jaminan Hari Tua (Nenkin).</span>
                    </div>

                </div>

                <!-- Right: Breakdown Result Box -->
                <div class="lg:col-span-6 rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-xl relative overflow-hidden border border-slate-800">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hasil Kalkulasi</span>
                            <h3 class="text-lg font-extrabold text-white">Ringkasan Penghasilan Bulanan</h3>
                        </div>
                        <span class="font-japanese text-sm font-bold text-red-400 bg-red-950/60 px-2.5 py-1 rounded-lg border border-red-800/50">
                            月収明細
                        </span>
                    </div>

                    <div class="space-y-4 py-5 border-b border-slate-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-400 font-medium">Gaji Kotor (Base + Lembur)</p>
                                <p id="calcGrossIdr" class="text-xs text-slate-500">≈ Rp 24.500.000</p>
                            </div>
                            <span id="calcGrossYen" class="text-base font-extrabold text-white">¥ 232.000</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-xs text-slate-400 font-medium">Potongan Pajak & Asuransi (18%)</p>
                            <span id="calcDeductionsYen" class="text-sm font-bold text-rose-400">- ¥ 41.760</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-xs text-slate-400 font-medium">Sewa Asrama, Makan & Utilitas</p>
                            <span id="calcLivingCostYen" class="text-sm font-bold text-rose-400">- ¥ 50.880</span>
                        </div>
                    </div>

                    <!-- Net Highlight -->
                    <div class="pt-5 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 flex items-center gap-1">
                                <i data-lucide="piggy-bank" class="w-4 h-4"></i>
                                Potensi Bersih Ditabung
                            </span>
                            <span id="calcNetSavingsYen" class="text-2xl sm:text-3xl font-black text-emerald-400">¥ 139.360</span>
                        </div>
                        <p id="calcNetSavingsIdr" class="text-base sm:text-lg font-extrabold text-white">
                            ≈ Rp 14.840.000 / bln
                        </p>
                        <p class="text-[11px] text-slate-400 leading-relaxed pt-1">
                            *Uang tabungan ini sepenuhnya menjadi hak Anda dan siap ditransfer langsung ke rekening keluarga di Indonesia.
                        </p>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-6 pt-4 border-t border-slate-800">
                        <button onclick="openModal('consultationModal')" class="w-full btn-red-primary py-3.5 rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-red-900/40">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Daftarkan Diri untuk Program Ini</span>
                        </button>
                    </div>

                </div>

            </div>
        </div>

        <!-- TAB 2: COST TRANSPARENCY & FINANCIAL AID -->
        <div id="costTabContent" class="hidden max-w-5xl mx-auto rounded-3xl bg-white border border-slate-200 shadow-2xl p-6 sm:p-10">
            <div class="space-y-8">
                
                <div class="text-center sm:text-left space-y-1">
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900">Transparansi Rincian Biaya & Skema Dana Talangan</h3>
                    <p class="text-xs sm:text-sm text-slate-600">Seluruh biaya dijelaskan di awal secara tertulis di depan notaris/perjanjian resmi tanpa pungutan liar.</p>
                </div>

                <!-- 3 Step Cost Breakdown Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="w-8 h-8 rounded-xl bg-red-100 text-japan-700 font-black flex items-center justify-center text-xs">
                            1
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Tahap 1: Pelatihan di LPK</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5">
                            <li>• Modul Buku & Aplikasi Bahasa</li>
                            <li>• Pengajar Native & Bersertifikasi</li>
                            <li>• Asrama & Sarana Pelatihan</li>
                            <li>• Simulasi Wawancara (Mensetsu)</li>
                        </ul>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="w-8 h-8 rounded-xl bg-red-100 text-japan-700 font-black flex items-center justify-center text-xs">
                            2
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Tahap 2: Sertifikasi & Ujian</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5">
                            <li>• Ujian JFT-Basic A2 / JLPT N4</li>
                            <li>• Ujian Keahlian Sektor (Skill Test)</li>
                            <li>• Bimbingan Try-Out Ujian</li>
                            <li>• Penerbitan Sertifikat Kelulusan</li>
                        </ul>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="w-8 h-8 rounded-xl bg-red-100 text-japan-700 font-black flex items-center justify-center text-xs">
                            3
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Tahap 3: Dokumen & Terbang</h4>
                        <ul class="text-xs text-slate-600 space-y-1.5">
                            <li>• Medical Check-Up (MCU) Resmi</li>
                            <li>• Paspor & Visa Kerja Imigrasi</li>
                            <li>• Pengurusan COE (Eligibility)</li>
                            <li>• Tiket Pesawat ke Jepang</li>
                        </ul>
                    </div>

                </div>

                <!-- Special Government Scholarships Banner (SMILE Project & SMK Go Japan) -->
                <div class="p-6 rounded-3xl bg-gradient-to-br from-emerald-950 via-slate-900 to-slate-950 text-white border border-emerald-500/30 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
                    <div class="space-y-2 text-center sm:text-left">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 font-black text-xs border border-emerald-400/30">
                            <i data-lucide="award" class="w-3.5 h-3.5 text-emerald-400"></i>
                            <span>Jalur Beasiswa Pemerintah RI (100% Bebas Biaya)</span>
                        </div>
                        <h4 class="text-lg sm:text-xl font-black text-white">SMILE Project (Kemenkes & Poltekkes Kaigo) — Sukses 4 Gelombang</h4>
                        <p class="text-xs sm:text-sm text-emerald-100/80 max-w-xl">
                            Khusus lulusan Poltekkes Kemenkes & STIKes kesehatan se-Indonesia, seluruh biaya pelatihan bahasa, asrama, sertifikasi Kaigo, CoE, visa, hingga tiket pesawat <b>100% dibiayai negara (Gratis)</b>. Juga tersedia jalur vokasi industri <b>SMK Go Japan</b> khusus anak SMK.
                        </p>
                    </div>

                    <a href="{{ route('brochure.index') }}" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black shadow-lg flex-shrink-0 transition flex items-center gap-2">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        <span>Unduh Brosur Beasiswa</span>
                    </a>
                </div>

                <!-- Dana Talangan Highlight Banner (Jalur Reguler Umum) -->
                <div class="p-6 rounded-2xl bg-gradient-to-r from-japan-900 to-japan-700 text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
                    <div class="space-y-2 text-center sm:text-left">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400 text-slate-950 font-black text-xs">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                            <span>Skema Dana Talangan Resmi (Jalur Reguler)</span>
                        </div>
                        <h4 class="text-lg sm:text-xl font-black text-white">Bisa Berangkat Dahulu, Cicil Setelah Bergaji di Jepang</h4>
                        <p class="text-xs sm:text-sm text-red-100/90 max-w-xl">
                            Untuk siswa jalur umum yang terkendala biaya, LPK menyediakan fasilitas talangan kerjasama perbankan resmi yang dapat dicicil ringan dari gaji bulanan di Jepang.
                        </p>
                    </div>

                    <button onclick="openModal('consultationModal')" class="btn-white-outline bg-white text-japan-700 hover:bg-red-50 px-6 py-3 rounded-xl text-xs font-black shadow-lg flex-shrink-0">
                        Konsultasi Skema Biaya
                    </button>
                </div>

            </div>
        </div>

    </div>
</section>

<script>
    function switchCalcTab(tab) {
        const salaryContent = document.getElementById('salaryTabContent');
        const costContent = document.getElementById('costTabContent');
        const salaryBtn = document.getElementById('tabSalaryBtn');
        const costBtn = document.getElementById('tabCostBtn');

        if (tab === 'salary') {
            salaryContent.classList.remove('hidden');
            costContent.classList.add('hidden');
            
            salaryBtn.className = 'px-5 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold bg-white text-japan-700 shadow-sm transition';
            costBtn.className = 'px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 hover:text-slate-900 transition';
        } else {
            salaryContent.classList.add('hidden');
            costContent.classList.remove('hidden');

            costBtn.className = 'px-5 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold bg-white text-japan-700 shadow-sm transition';
            salaryBtn.className = 'px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 hover:text-slate-900 transition';
        }
    }
</script>
