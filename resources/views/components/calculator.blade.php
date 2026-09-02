<!-- Interactive Salary & Savings Simulator Section -->
<section id="kalkulator" class="py-20 lg:py-28 bg-white relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute inset-0 bg-japanese-pattern opacity-30 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3 reveal-on-scroll">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-bold uppercase tracking-wider">
                <span class="font-japanese text-sm">給与シミュレーション</span>
                <span>• Kalkulator Interaktif</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                Simulasi Penghasilan & <br class="hidden sm:inline">
                <span class="text-japan-600">Tabungan Bersih di Jepang</span>
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Hitung perkiraan gaji kotor, potongan wajib standar Jepang, biaya hidup, dan estimasi uang yang bisa Anda tabung atau kirimkan ke keluarga setiap bulannya.
            </p>
        </div>

        <!-- Calculator Interactive Grid -->
        <div class="max-w-5xl mx-auto rounded-3xl bg-gradient-to-br from-white via-red-50/40 to-white border border-red-200/80 shadow-2xl p-6 sm:p-10 reveal-scale">
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
                    
                    <!-- Japanese Kanji Decorative Header -->
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
                        <!-- Gross Salary -->
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-400 font-medium">Gaji Kotor (Base + Lembur)</p>
                                <p id="calcGrossIdr" class="text-xs text-slate-500">≈ Rp 24.500.000</p>
                            </div>
                            <span id="calcGrossYen" class="text-base font-extrabold text-white">¥ 232.000</span>
                        </div>

                        <!-- Deductions -->
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-slate-400 font-medium">Potongan Pajak & Asuransi (18%)</p>
                            <span id="calcDeductionsYen" class="text-sm font-bold text-rose-400">- ¥ 41.760</span>
                        </div>

                        <!-- Living Cost -->
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

    </div>
</section>
