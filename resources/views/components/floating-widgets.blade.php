<!-- Floating Action Widgets & Public Concierge Dock -->
<div>
    
    <!-- 1. Zen Luxury Public Floating Concierge Dock (Desktop & Tablet) -->
    <div 
        id="publicConciergeDock" 
        class="hidden md:flex fixed bottom-6 left-1/2 -translate-x-1/2 z-40 items-center gap-1 p-1.5 rounded-full bg-slate-950/85 backdrop-blur-xl border border-white/15 shadow-2xl text-xs font-bold text-white transition-all duration-300 hover:border-japan-500/40 hover:shadow-japan-900/20 pointer-events-auto"
    >
        <!-- Peta Alumni Jepang -->
        <a 
            href="{{ route('alumni.map') }}" 
            class="flex items-center gap-2 px-3.5 py-2 rounded-full hover:bg-white/10 transition group text-slate-200 hover:text-white"
            title="Eksplorasi Peta Sebaran Alumni 47 Prefektur Jepang"
        >
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
            </span>
            <span class="group-hover:text-red-300 transition-colors">Peta Alumni 🇯🇵</span>
        </a>

        <div class="h-4 w-px bg-white/15"></div>

        <!-- CBT Simulator -->
        <a 
            href="{{ route('exam.simulator') }}" 
            class="flex items-center gap-1.5 px-3 py-2 rounded-full hover:bg-white/10 transition group text-slate-300 hover:text-white"
            title="Simulasi CBT Ujian JLPT & JFT-Basic Online"
        >
            <i data-lucide="book-open" class="w-3.5 h-3.5 text-amber-400"></i>
            <span>Simulasi CBT</span>
        </a>

        <div class="h-4 w-px bg-white/15"></div>

        <!-- Cek Status Siswa -->
        <a 
            href="{{ route('student.portal') }}" 
            class="flex items-center gap-1.5 px-3 py-2 rounded-full hover:bg-white/10 transition group text-slate-300 hover:text-white"
            title="Portal Cek Status Siswa & Kwitansi Resmi"
        >
            <i data-lucide="search" class="w-3.5 h-3.5 text-blue-400"></i>
            <span>Cek Status</span>
        </a>

        <div class="h-4 w-px bg-white/15"></div>

        <!-- Unduh Brosur -->
        <a 
            href="{{ route('brochure.index') }}" 
            class="flex items-center gap-1.5 px-3 py-2 rounded-full hover:bg-white/10 transition group text-slate-300 hover:text-white"
            title="Unduh Brosur & Kurikulum Pelatihan 2026"
        >
            <i data-lucide="download" class="w-3.5 h-3.5 text-emerald-400"></i>
            <span>Brosur</span>
        </a>

        <div class="h-4 w-px bg-white/15"></div>

        <!-- Tes Minat Karir Button -->
        <button 
            type="button" 
            onclick="openModal('quizModal')" 
            class="flex items-center gap-1.5 px-3 py-2 rounded-full bg-japan-600 hover:bg-japan-700 text-white font-black text-xs shadow-md transition"
            title="Tes Kecocokan Karir Jepang 30 Detik"
        >
            <i data-lucide="compass" class="w-3.5 h-3.5 text-amber-300"></i>
            <span>Tes Minat</span>
        </button>
    </div>

    <!-- 2. Floating Action Widgets (Right Corner) -->
    <div class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-3 pointer-events-auto">
        
        <!-- Scroll To Top Button with Circular Progress -->
        <button 
            id="scrollToTopBtn" 
            type="button" 
            class="w-12 h-12 rounded-full bg-white text-slate-800 shadow-xl border border-slate-200 flex items-center justify-center opacity-0 pointer-events-none translate-y-6 transition-all duration-300 hover:text-japan-600 hover:border-japan-300 group"
            aria-label="Scroll to top"
        >
            <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="46" fill="none" stroke="#E2E8F0" stroke-width="4"></circle>
                <circle id="scrollProgressPath" cx="50" cy="50" r="46" fill="none" stroke="#DC2626" stroke-width="4" stroke-dasharray="289.026" stroke-dashoffset="289.026" stroke-linecap="round" class="transition-all duration-100"></circle>
            </svg>
            <i data-lucide="arrow-up" class="w-5 h-5 group-hover:-translate-y-0.5 transition-transform"></i>
        </button>

        <!-- Floating Quiz Matchmaker Button (Mobile only since Desktop has it in Concierge Dock) -->
        <button 
            type="button" 
            onclick="openModal('quizModal')" 
            class="md:hidden group flex items-center gap-2 p-3 rounded-full bg-slate-900 text-amber-300 shadow-xl border border-amber-400/40 hover:scale-105 hover:bg-slate-800 transition-all duration-300"
            title="Tes Kecocokan Program Jepang 30 Detik"
        >
            <i data-lucide="compass" class="w-5 h-5 text-amber-400 group-hover:rotate-45 transition-transform"></i>
            <span class="hidden sm:inline font-black text-xs text-white">
                Tes Minat (30 Dtk)
            </span>
        </button>

        <!-- Floating WhatsApp Action Button -->
        @php
            $waAdmin = $settings['contact_whatsapp'] ?? '6281234567890';
            $cleanWaFloating = preg_replace('/[^0-9]/', '', $waAdmin);
            if (str_starts_with($cleanWaFloating, '0')) $cleanWaFloating = '62' . substr($cleanWaFloating, 1);
        @endphp
        <a 
            href="https://api.whatsapp.com/send?phone={{ $cleanWaFloating }}&text=Halo%20Admin%20LPK%20Sahabat%20Jepang%20Indonesia,%20saya%20tertarik%20bertanya%20tentang%20pelatihan%20dan%20kerja%20di%20Jepang" 
            target="_blank" 
            rel="noopener noreferrer"
            class="group relative flex items-center gap-2 p-3.5 sm:px-5 sm:py-3.5 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-xl shadow-emerald-600/30 hover:shadow-2xl hover:scale-105 transition-all duration-300"
            aria-label="Chat via WhatsApp"
        >
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 rounded-full bg-red-500 border-2 border-white animate-ping"></span>
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 rounded-full bg-red-500 border-2 border-white"></span>
            
            <i data-lucide="message-circle" class="w-6 h-6 fill-white stroke-none"></i>
            
            <span class="hidden sm:inline font-bold text-sm">
                Chat Konselor
            </span>
        </a>

    </div>

</div>
