<!-- Footer Component -->
<footer class="bg-slate-950 text-slate-300 relative overflow-hidden border-t-2 border-japan-600">
    
    <!-- Subtle Pattern Watermark -->
    <div class="absolute inset-0 bg-seigaiha opacity-5 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-12 border-b border-slate-800">
            
            <!-- Col 1: Brand & Bio (5 cols) -->
            <div class="lg:col-span-5 space-y-4">
                <div class="flex items-center gap-3">
                    @if(!empty($settings['site_logo']))
                        <img src="{{ $settings['site_logo'] }}" alt="{{ $settings['site_name'] ?? 'LPK Sahabat Jepang' }}" class="h-10 w-auto object-contain max-w-[140px] rounded-lg bg-white/10 p-1">
                    @else
                        <div class="w-10 h-10 rounded-2xl bg-japan-600 flex items-center justify-center text-white font-japanese font-black text-xl shadow-md">
                            友
                        </div>
                    @endif
                    <div>
                        <h3 class="font-black text-lg text-white tracking-tight">{{ $settings['site_name'] ?? 'LPK SAHABAT JEPANG INDONESIA' }}</h3>
                        <p class="text-xs text-slate-400 font-japanese">友好日本インドネシア • Sending Organization</p>
                    </div>
                </div>

                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed pr-4">
                    Lembaga Pelatihan Kerja (LPK) dan Sending Organization (SO) resmi berizin Kementerian Ketenagakerjaan RI, mendedikasikan diri untuk membina dan memberangkatkan tenaga kerja terampil Indonesia menuju masa depan sukses di Jepang.
                </p>

                <!-- Legal Certification Badges -->
                <div class="pt-2 flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-slate-900 border border-slate-800 text-[11px] font-semibold text-slate-300">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-400"></i>
                        Izin Resmi Kemenaker RI
                    </span>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-slate-900 border border-slate-800 text-[11px] font-semibold text-slate-300">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-amber-400"></i>
                        Akreditasi LPK Nasional
                    </span>
                </div>
            </div>

            <!-- Col 2: Program Links (2 cols) -->
            <div class="lg:col-span-2 space-y-3">
                <h4 class="font-extrabold text-white text-sm uppercase tracking-wider">Program Karir</h4>
                <ul class="space-y-2 text-xs sm:text-sm text-slate-400">
                    <li><a href="#program" class="hover:text-red-400 transition">Tokutei Ginou (SSW)</a></li>
                    <li><a href="#program" class="hover:text-red-400 transition">Magang (Jisshusei)</a></li>
                    <li><a href="#program" class="hover:text-red-400 transition">Kursus Bahasa Jepang</a></li>
                    <li><a href="#program" class="hover:text-red-400 transition">Engineer Profesional</a></li>
                    <li><a href="#kalkulator" class="hover:text-red-400 transition">Simulasi Gaji & Tabungan</a></li>
                </ul>
            </div>

            <!-- Col 3: Navigasi (2 cols) -->
            <div class="lg:col-span-2 space-y-3">
                <h4 class="font-extrabold text-white text-sm uppercase tracking-wider">Navigasi</h4>
                <ul class="space-y-2 text-xs sm:text-sm text-slate-400">
                    <li><a href="#beranda" class="hover:text-red-400 transition">Beranda</a></li>
                    <li><a href="#tentang" class="hover:text-red-400 transition">Tentang Kami</a></li>
                    <li><a href="#alur" class="hover:text-red-400 transition">Alur Keberangkatan</a></li>
                    <li><a href="#fasilitas" class="hover:text-red-400 transition">Fasilitas & Asrama</a></li>
                    <li><a href="#testimoni" class="hover:text-red-400 transition">Kisah Alumni</a></li>
                    <li><a href="#faq" class="hover:text-red-400 transition">Tanya Jawab (FAQ)</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact & Office (3 cols) -->
            <div class="lg:col-span-3 space-y-3">
                <h4 class="font-extrabold text-white text-sm uppercase tracking-wider">Hubungi Kami</h4>
                <div class="space-y-2.5 text-xs text-slate-400">
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"></i>
                        <span>Jl. Sakura Raya No. 88, Kawasan Pendidikan & Pelatihan Karir Jepang, Jakarta</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="phone" class="w-4 h-4 text-red-500 flex-shrink-0"></i>
                        <span>+62 812-3456-7890 / (021) 7890-1234</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="mail" class="w-4 h-4 text-red-500 flex-shrink-0"></i>
                        <span>info@sahabatjepangindonesia.com</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="clock" class="w-4 h-4 text-red-500 flex-shrink-0"></i>
                        <span>Senin - Sabtu: 08.00 - 17.00 WIB</span>
                    </div>
                </div>

                <!-- Social Icons -->
                <div class="pt-2 flex items-center gap-2">
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-japan-600 text-slate-400 hover:text-white flex items-center justify-center transition">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-japan-600 text-slate-400 hover:text-white flex items-center justify-center transition">
                        <i data-lucide="youtube" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-japan-600 text-slate-400 hover:text-white flex items-center justify-center transition">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=6281234567890" target="_blank" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-emerald-600 text-slate-400 hover:text-white flex items-center justify-center transition">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <p>© 2026 LPK Sahabat Jepang Indonesia. Seluruh Hak Cipta Dilindungi.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-slate-400">Kebijakan Privasi</a>
                <span>•</span>
                <a href="#" class="hover:text-slate-400">Syarat & Ketentuan</a>
                <span>•</span>
                <span class="font-japanese text-[11px] text-red-400">インドネシアと日本の架け橋</span>
            </div>
        </div>

    </div>
</footer>
