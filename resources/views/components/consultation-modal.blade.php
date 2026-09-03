<!-- Consultation & Registration Modal Pop-up (Clean, Compact, Responsive) -->
<div id="consultationModal" class="custom-modal fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
    
    <!-- Backdrop Blur -->
    <div class="modal-backdrop-blur fixed inset-0" onclick="closeModal('consultationModal')"></div>

    <!-- Modal Box (Strict Max Height & Clean Scroll) -->
    <div class="modal-content-box relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100 z-10 my-auto flex flex-col max-h-[88vh]">
        
        <!-- Modal Header Banner (Compact & Fixed) -->
        <div class="bg-gradient-to-r from-japan-900 via-japan-700 to-red-600 text-white p-5 sm:p-6 relative flex-shrink-0">
            <button 
                type="button" 
                onclick="closeModal('consultationModal')" 
                class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition focus:outline-none"
                aria-label="Tutup Formulir"
            >
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>

            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-sm text-[11px] font-semibold mb-1.5">
                <span class="font-japanese">無料相談</span>
                <span>• Konsultasi Gratis</span>
            </div>
            
            <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                Pendaftaran & Konsultasi Karir
            </h3>
            <p class="text-[11px] sm:text-xs text-red-100 mt-0.5">
                Isi data singkat berikut. Tim konselor LPK SJI akan segera menghubungi Anda melalui WhatsApp.
            </p>
        </div>

        <!-- Form Body (Scrollable Container) -->
        <form action="{{ route('consultation.store') }}" method="POST" class="consultation-form p-5 sm:p-6 space-y-3.5 overflow-y-auto flex-1 text-xs">
            @csrf

            <!-- Nama Lengkap & No WhatsApp -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block font-bold text-slate-700 uppercase text-[10px]">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        required 
                        placeholder="Nama lengkap Anda"
                        class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none"
                    >
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-slate-700 uppercase text-[10px]">
                        Nomor WhatsApp Aktif <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="tel" 
                        name="phone" 
                        required 
                        placeholder="Contoh: 081234567890"
                        class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none font-semibold"
                    >
                </div>
            </div>

            <!-- Program Minat -->
            <div class="space-y-1">
                <label class="block font-bold text-slate-700 uppercase text-[10px]">
                    Pilihan Program Minat <span class="text-red-500">*</span>
                </label>
                <select id="consultProgramSelect" name="program" required class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none font-bold text-japan-700">
                    <optgroup label="Program Resmi Pemerintah (Unggulan)">
                        <option value="Program Pemerintah: SMILE Project (Kemenkes Kaigo 100% Gratis)">★ SMILE Project (Beasiswa Kemenkes & Poltekkes Kaigo 100% Gratis)</option>
                        <option value="Program Pemerintah: SMK Go Japan (Vokasi Industri)">★ SMK Go Japan (Khusus Siswa & Alumni SMK)</option>
                    </optgroup>
                    <optgroup label="Jalur Reguler & Karir Jepang">
                        <option value="Tokutei Ginou (SSW)" selected>Tokutei Ginou (Specified Skilled Worker / SSW)</option>
                        <option value="Ginou Jisshusei (Magang Kerja)">Ginou Jisshusei (Magang Praktik Kerja)</option>
                        <option value="Kursus Intensif Bahasa & Budaya">Kursus Intensif Bahasa Jepang (N5, N4, N3)</option>
                        <option value="Engineer & Professional Career">Engineer & Profesional (IT / Teknik)</option>
                        <option value="Belum Tahu / Ingin Konsultasi Dulu">Ingin Konsultasi Pilihan Program Dulu</option>
                    </optgroup>
                </select>
            </div>

            <!-- Usia & Pendidikan Terakhir -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block font-bold text-slate-700 uppercase text-[10px]">
                        Usia (Tahun)
                    </label>
                    <input 
                        type="number" 
                        name="age" 
                        min="16" 
                        max="50" 
                        placeholder="Contoh: 21"
                        class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none"
                    >
                </div>

                <div class="space-y-1">
                    <label class="block font-bold text-slate-700 uppercase text-[10px]">
                        Pendidikan Terakhir
                    </label>
                    <select name="education" class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none">
                        <option value="SMA / SMK Sederajat">SMA / SMK Sederajat</option>
                        <option value="Diploma (D1 - D3)">Diploma (D1 - D3)</option>
                        <option value="Sarjana (S1 / D4)">Sarjana (S1 / D4)</option>
                        <option value="SMP / Sederajat">SMP / Sederajat</option>
                    </select>
                </div>
            </div>

            <!-- Kota Asal / Domisili -->
            <div class="space-y-1">
                <label class="block font-bold text-slate-700 uppercase text-[10px]">
                    Kota Asal / Domisili
                </label>
                <input 
                    type="text" 
                    name="city" 
                    placeholder="Contoh: Bandung, Surabaya, Medan, dll."
                    class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none"
                >
            </div>

            <!-- Pertanyaan / Catatan Tambahan -->
            <div class="space-y-1">
                <label class="block font-bold text-slate-700 uppercase text-[10px]">
                    Pertanyaan / Catatan (Opsional)
                </label>
                <textarea 
                    name="message" 
                    rows="2" 
                    placeholder="Tuliskan pertanyaan seputar biaya, asrama, atau alur seleksi..."
                    class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none"
                ></textarea>
            </div>

            <!-- Submit Button (Fixed at bottom) -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full btn-red-primary py-3 rounded-xl font-black text-xs sm:text-sm flex items-center justify-center gap-2 shadow-md shadow-red-600/30 transition hover:scale-[1.01]"
                >
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Kirim Formulir Pendaftaran</span>
                </button>
                <p class="text-[10px] text-slate-400 text-center mt-2">
                    🔒 Data pribadi Anda dijamin aman untuk keperluan seleksi resmi LPK SJI.
                </p>
            </div>

        </form>

    </div>
</div>
