<!-- Floating Action Widgets -->
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

    <!-- Floating WhatsApp Action Button -->
    <a 
        href="https://api.whatsapp.com/send?phone=6281234567890&text=Halo%20Admin%20LPK%20Sahabat%20Jepang%20Indonesia,%20saya%20tertarik%20bertanya%20tentang%20pelatihan%20dan%20kerja%20di%20Jepang" 
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
