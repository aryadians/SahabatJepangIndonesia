<!-- Bottom Call To Action Banner -->
<section class="py-16 sm:py-20 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-japan-900 via-japan-700 to-japan-800 text-white shadow-2xl p-8 sm:p-14 lg:p-16 reveal-scale">
            
            <!-- Japanese Pattern Watermark Background -->
            <div class="absolute inset-0 bg-seigaiha opacity-10 pointer-events-none"></div>
            <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-red-500/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl space-y-6 text-center lg:text-left">
                
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase tracking-wider">
                    <span class="font-japanese text-sm font-semibold">未来への一歩</span>
                    <span>• Saatnya Melangkah Bersama SJI</span>
                </div>

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                    Wujudkan Impian Berkarir di Jepang Sekarang Juga!
                </h2>

                <p class="text-base sm:text-lg text-red-100 max-w-2xl leading-relaxed">
                    Jangan biarkan keraguan menghambat masa depan Anda. Dapatkan bimbingan menyeluruh, pelatihan bahasa dari dasar, dan kepastian penyaluran kerja berpenghasilan tinggi di Jepang.
                </p>

                <div class="pt-4 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <button 
                        type="button"
                        onclick="openModal('consultationModal')" 
                        class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white text-japan-800 font-extrabold text-base shadow-xl hover:bg-red-50 hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 active:scale-95"
                    >
                        <i data-lucide="sparkles" class="w-5 h-5 text-amber-500"></i>
                        <span>Daftar Konsultasi Gratis</span>
                    </button>

                    <a 
                        href="https://api.whatsapp.com/send?phone={{ $settings['contact_whatsapp'] ?? '6281234567890' }}&text=Halo%20Admin%20LPK%20Sahabat%20Jepang%20Indonesia,%20saya%20tertarik%20mendaftar%20program%20ke%20Jepang." 
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-full sm:w-auto px-7 py-4 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold text-base transition flex items-center justify-center gap-2 active:scale-95"
                    >
                        <i data-lucide="message-circle" class="w-5 h-5 text-emerald-400"></i>
                        <span>Chat via WhatsApp Langsung</span>
                    </a>
                </div>

                <!-- Trust Points Ribbon -->
                <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-x-6 gap-y-2 text-xs text-red-200/90 font-medium">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-300"></i>
                        <span>Respon Cepat &lt; 15 Menit</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span>Izin Resmi SO Kemnaker RI</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-amber-300"></i>
                        <span>500+ Alumni Berangkat</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
