<!-- Consultation & Registration Modal Pop-up (Clean, Compact, Responsive) -->
@php
    $cleanWa = preg_replace('/[^0-9]/', '', $settings['contact_whatsapp'] ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) $cleanWa = '62' . substr($cleanWa, 1);
@endphp
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
                        inputmode="tel"
                        autocomplete="tel"
                        required 
                        placeholder="Contoh: 081234567890"
                        class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none font-semibold"
                    >
                </div>
            </div>

            <!-- Program Minat -->
            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase text-[10px]">
                    Pilihan Program Minat <span class="text-red-500">*</span>
                </label>
                
                <!-- Quick Selection Chips -->
                <div class="flex flex-wrap gap-1.5 pb-1">
                    <button type="button" onclick="setConsultProgram('Program Pemerintah: SMILE Project (Kemenkes Kaigo 100% Gratis)')" class="consult-chip px-2.5 py-1 rounded-lg bg-red-50 border border-red-200 text-japan-700 font-bold text-[10px] hover:bg-red-100 transition active:scale-[0.97]">
                        🏥 SMILE (Khusus Poltekkes MoU)
                    </button>
                    <button type="button" onclick="setConsultProgram('Tokutei Ginou (SSW)')" class="consult-chip px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 font-bold text-[10px] hover:bg-slate-200 transition active:scale-[0.97]">
                        💼 Tokutei Ginou (SSW)
                    </button>
                    <button type="button" onclick="setConsultProgram('Ginou Jisshusei (Magang Kerja)')" class="consult-chip px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 font-bold text-[10px] hover:bg-slate-200 transition active:scale-[0.97]">
                        🏭 Magang Jepang
                    </button>
                    <button type="button" onclick="setConsultProgram('Program Pemerintah: SMK Go Japan (Vokasi Industri)')" class="consult-chip px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 font-bold text-[10px] hover:bg-slate-200 transition active:scale-[0.97]">
                        🏫 SMK Go Japan
                    </button>
                    <button type="button" onclick="setConsultProgram('Kursus Intensif Bahasa & Budaya')" class="consult-chip px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 font-bold text-[10px] hover:bg-slate-200 transition active:scale-[0.97]">
                        📚 Kursus N5/N4
                    </button>
                </div>

                <select id="consultProgramSelect" name="program" required class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none font-bold text-japan-700">
                    <optgroup label="Program Resmi Pemerintah (Unggulan)">
                        <option value="Program Pemerintah: SMILE Project (Kemenkes Kaigo 100% Gratis)">★ SMILE Project (Khusus Poltekkes MoU - Kaigo 100% Gratis)</option>
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

                <!-- Callout Khusus SMILE Project (Poltekkes MoU) -->
                <div id="smileMouNotice" class="hidden p-3 rounded-xl bg-amber-50 border border-amber-300 text-amber-900 text-xs space-y-1 mt-2">
                    <div class="flex items-center gap-1.5 font-bold text-amber-800">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-amber-600 flex-shrink-0"></i>
                        <span>Khusus Mahasiswa & Alumni Poltekkes yang Sudah MoU</span>
                    </div>
                    <p class="text-[11px] text-amber-800 leading-relaxed">
                        Program <strong>SMILE Project (Kaigo 100% Bebas Biaya)</strong> khusus diperuntukkan bagi mahasiswa tingkat akhir / alumni dari <strong>Poltekkes Kemenkes yang telah memiliki naskah kerja sama (MoU) resmi</strong> dengan LPK Sahabat Jepang Indonesia.
                    </p>
                    <p class="text-[10px] text-amber-700 italic pt-0.5">
                        *Bagi lulusan keperawatan/kebidanan non-Poltekkes MoU atau jalur umum, silakan memilih opsi <strong>Tokutei Ginou (SSW)</strong> bidang Kaigo (tersedia skema dana talangan & beasiswa penempatan).
                    </p>
                </div>

                <!-- Input Asal Poltekkes Khusus SMILE Project -->
                <div id="smileCampusField" class="hidden space-y-1 mt-2">
                    <label class="block font-bold text-slate-700 uppercase text-[10px]">
                        Nama Kampus Poltekkes Asal <span class="text-red-500">* (Wajib Poltekkes Mitra MoU)</span>
                    </label>
                    <input 
                        type="text" 
                        name="campus_origin" 
                        id="smileCampusInput"
                        placeholder="Contoh: Poltekkes Kemenkes Bandung, Jakarta III, Yogyakarta, Semarang..."
                        class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-amber-50/40 border border-amber-300 focus:bg-white focus:border-japan-600 focus:outline-none font-medium"
                    >
                </div>
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
                        inputmode="numeric"
                        min="16" 
                        max="50" 
                        placeholder="Contoh: 21"
                        class="w-full px-3.5 py-2 rounded-xl text-xs text-slate-900 bg-slate-50 border border-slate-200 focus:bg-white focus:border-japan-600 focus:outline-none font-semibold"
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
            <div class="pt-2 space-y-2">
                <button 
                    type="submit" 
                    class="w-full btn-red-primary py-3 rounded-xl font-black text-xs sm:text-sm flex items-center justify-center gap-2 shadow-md shadow-red-600/30 transition hover:scale-[1.01] active:scale-[0.98]"
                >
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Kirim Formulir Pendaftaran</span>
                </button>

                <!-- WhatsApp Fast-Track Divider & Button -->
                <div class="relative flex py-1 items-center">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-2 text-[10px] text-slate-400 font-bold uppercase tracking-wider">Atau Hubungi Langsung</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <a 
                    href="https://api.whatsapp.com/send?phone={{ $cleanWa }}&text=Halo%20Sensei%20LPK%20Sahabat%20Jepang%20Indonesia,%20saya%20ingin%20konsultasi%20langsung%20mengenai%20program%20pelatihan%20dan%20penempatan%20ke%20Jepang." 
                    target="_blank" 
                    class="w-full py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs flex items-center justify-center gap-2 transition active:scale-[0.98]"
                >
                    <i data-lucide="message-circle" class="w-4 h-4 text-emerald-600"></i>
                    <span>Fast-Track Chat WhatsApp Sensei</span>
                </a>

                <p class="text-[10px] text-slate-400 text-center mt-1">
                    🔒 Data pribadi Anda dijamin aman untuk keperluan seleksi resmi LPK SJI.
                </p>
            </div>

        </form>

        <script>
            function checkSmileSelection(val) {
                const notice = document.getElementById('smileMouNotice');
                const campusField = document.getElementById('smileCampusField');
                const campusInput = document.getElementById('smileCampusInput');
                const isSmile = val && val.toLowerCase().includes('smile');

                if (notice) {
                    if (isSmile) {
                        notice.classList.remove('hidden');
                    } else {
                        notice.classList.add('hidden');
                    }
                }
                if (campusField) {
                    if (isSmile) {
                        campusField.classList.remove('hidden');
                        if (campusInput) campusInput.setAttribute('required', 'required');
                    } else {
                        campusField.classList.add('hidden');
                        if (campusInput) {
                            campusInput.removeAttribute('required');
                            campusInput.value = '';
                        }
                    }
                }
                if (window.lucide) lucide.createIcons();
            }

            function setConsultProgram(val) {
                const select = document.getElementById('consultProgramSelect');
                if (select) {
                    select.value = val;
                }
                document.querySelectorAll('.consult-chip').forEach(btn => {
                    if (btn.innerText.includes(val) || btn.getAttribute('onclick').includes(val)) {
                        btn.className = 'consult-chip px-2.5 py-1 rounded-lg bg-red-600 text-white font-bold text-[10px] shadow-xs ring-1 ring-red-400 transition active:scale-[0.97]';
                    } else {
                        btn.className = 'consult-chip px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 font-bold text-[10px] hover:bg-slate-200 transition active:scale-[0.97]';
                    }
                });
                checkSmileSelection(val);
            }

            document.addEventListener('DOMContentLoaded', () => {
                const select = document.getElementById('consultProgramSelect');
                if (select) {
                    select.addEventListener('change', (e) => {
                        checkSmileSelection(e.target.value);
                    });
                    checkSmileSelection(select.value);
                }
            });
        </script>

    </div>
</div>
