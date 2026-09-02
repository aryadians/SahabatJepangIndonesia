<!-- Consultation & Registration Modal Pop-up -->
<div id="consultationModal" class="custom-modal fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
    
    <!-- Backdrop Blur -->
    <div class="modal-backdrop-blur fixed inset-0"></div>

    <!-- Modal Box -->
    <div class="modal-content-box relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100 z-10 my-8">
        
        <!-- Modal Header Banner -->
        <div class="bg-gradient-to-r from-japan-800 via-japan-600 to-red-600 text-white p-6 sm:p-8 relative">
            <button 
                type="button" 
                onclick="closeModal('consultationModal')" 
                class="absolute top-5 right-5 w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition focus:outline-none"
            >
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs font-semibold mb-2">
                <span class="font-japanese">無料相談</span>
                <span>• Formulir Konsultasi Gratis</span>
            </div>
            
            <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Pendaftaran & Konsultasi Karir Jepang
            </h3>
            <p class="text-xs sm:text-sm text-red-100 mt-1">
                Isi formulir singkat di bawah ini. Tim konselor resmi LPK Sahabat Jepang Indonesia akan segera menghubungi Anda melalui WhatsApp.
            </p>
        </div>

        <!-- Form Body -->
        <form action="{{ route('consultation.store') }}" method="POST" class="consultation-form p-6 sm:p-8 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                
                <!-- Nama Lengkap -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        required 
                        placeholder="Contoh: Muhammad Budi Santoso"
                        class="w-full input-japan px-4 py-3 rounded-xl text-sm text-slate-900 bg-slate-50 focus:bg-white"
                    >
                </div>

                <!-- No WhatsApp -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Nomor WhatsApp Aktif <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="tel" 
                        name="phone" 
                        required 
                        placeholder="Contoh: 081234567890"
                        class="w-full input-japan px-4 py-3 rounded-xl text-sm text-slate-900 bg-slate-50 focus:bg-white"
                    >
                </div>

                <!-- Usia -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Usia Anda (Tahun)
                    </label>
                    <input 
                        type="number" 
                        name="age" 
                        min="16" 
                        max="50" 
                        placeholder="Contoh: 21"
                        class="w-full input-japan px-4 py-3 rounded-xl text-sm text-slate-900 bg-slate-50 focus:bg-white"
                    >
                </div>

                <!-- Pendidikan Terakhir -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Pendidikan Terakhir
                    </label>
                    <select name="education" class="w-full input-japan px-4 py-3 rounded-xl text-sm text-slate-900 bg-slate-50 focus:bg-white">
                        <option value="SMA / SMK Sederajat">SMA / SMK Sederajat</option>
                        <option value="Diploma (D1 - D3)">Diploma (D1 - D3)</option>
                        <option value="Sarjana (S1 / D4)">Sarjana (S1 / D4)</option>
                        <option value="SMP / Sederajat">SMP / Sederajat</option>
                    </select>
                </div>

            </div>

            <!-- Program Minat -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Pilihan Program Minat <span class="text-red-500">*</span>
                </label>
                <select id="consultProgramSelect" name="program" required class="w-full input-japan px-4 py-3 rounded-xl text-sm text-slate-900 bg-slate-50 focus:bg-white font-semibold">
                    <option value="Tokutei Ginou (SSW)">Tokutei Ginou (Specified Skilled Worker / SSW)</option>
                    <option value="Ginou Jisshusei (Magang Kerja)">Ginou Jisshusei (Program Magang Praktik Kerja)</option>
                    <option value="Kursus Intensif Bahasa & Budaya">Kursus Intensif Bahasa & Budaya Jepang (N5, N4, N3)</option>
                    <option value="Engineer & Professional Career">Program Engineer & Profesional (IT / Teknik)</option>
                    <option value="Belum Tahu / Ingin Konsultasi Dulu">Belum Tahu / Ingin Konsultasi Pilihan Terbaik Dulu</option>
                </select>
            </div>

            <!-- Kota Asal / Domisili -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Kota Asal / Domisili Saat Ini
                </label>
                <input 
                    type="text" 
                    name="city" 
                    placeholder="Contoh: Bandung, Surabaya, Medan, dll."
                    class="w-full input-japan px-4 py-3 rounded-xl text-sm text-slate-900 bg-slate-50 focus:bg-white"
                >
            </div>

            <!-- Catatan / Pertanyaan -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Pertanyaan / Catatan Tambahan (Opsional)
                </label>
                <textarea 
                    name="message" 
                    rows="3" 
                    placeholder="Tuliskan jika ada pertanyaan khusus seputar bidang kerja, asrama, atau tes bahasa..."
                    class="w-full input-japan px-4 py-3 rounded-xl text-sm text-slate-900 bg-slate-50 focus:bg-white"
                ></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-3">
                <button 
                    type="submit" 
                    class="w-full btn-red-primary py-4 rounded-xl font-bold text-base flex items-center justify-center gap-2 shadow-lg shadow-red-600/30"
                >
                    <i data-lucide="send" class="w-5 h-5"></i>
                    <span>Kirim Formulir Pendaftaran</span>
                </button>
                <p class="text-[11px] text-slate-500 text-center mt-3">
                    🔒 Data pribadi Anda dijamin aman & hanya digunakan untuk keperluan konsultasi resmi LPK Sahabat Jepang Indonesia.
                </p>
            </div>

        </form>

    </div>
</div>
