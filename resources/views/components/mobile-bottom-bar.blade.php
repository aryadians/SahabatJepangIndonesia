<!-- Mobile Sticky Bottom Quick Action Bar (Japanese Career Standard) -->
<div id="mobileBottomBar" class="mobile-bottom-bar sm:hidden transform translate-y-full opacity-0 pointer-events-none transition-all duration-300">
    <div class="px-4 py-2.5 flex items-center justify-between gap-2 max-w-md mx-auto">
        
        <!-- Cek Status Siswa -->
        <a href="{{ route('student.portal') }}" class="flex-1 py-2 px-2 rounded-xl bg-slate-800/90 hover:bg-slate-700 text-slate-200 text-[10px] font-bold flex items-center justify-center gap-1.5 border border-slate-700 transition">
            <i data-lucide="search" class="w-3.5 h-3.5 text-japan-400"></i>
            <span>Cek Status</span>
        </a>

        <!-- Unduh Brosur -->
        <a href="{{ route('brochure.index') }}" class="flex-1 py-2 px-2 rounded-xl bg-slate-800/90 hover:bg-slate-700 text-slate-200 text-[10px] font-bold flex items-center justify-center gap-1.5 border border-slate-700 transition">
            <i data-lucide="download" class="w-3.5 h-3.5 text-emerald-400"></i>
            <span>Brosur</span>
        </a>

        <!-- WhatsApp Konsultan (Primary Highlight Button) -->
        @php
            $cleanWaMobile = preg_replace('/[^0-9]/', '', $settings['contact_whatsapp'] ?? '6281234567890');
            if (str_starts_with($cleanWaMobile, '0')) $cleanWaMobile = '62' . substr($cleanWaMobile, 1);
        @endphp
        <a href="https://api.whatsapp.com/send?phone={{ $cleanWaMobile }}&text=Halo%20LPK%20SJI,%20saya%20ingin%20konsultasi%20program%20kerja%20ke%20Jepang" target="_blank" class="flex-[1.4] py-2 px-3 rounded-xl btn-red-primary text-white text-[10px] font-black flex items-center justify-center gap-1.5 shadow-lg shadow-red-600/30 whitespace-nowrap">
            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
            <span>Chat WA</span>
        </a>

    </div>
</div>
