<!-- Facility Interactive Lightbox Preview Modal -->
<div id="facilityModal" class="custom-modal fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="facModalTitle">
    
    <!-- Backdrop Blur -->
    <div class="modal-backdrop-blur fixed inset-0 bg-slate-950/80 backdrop-blur-md" onclick="closeModal('facilityModal')"></div>

    <!-- Modal Box -->
    <div class="modal-content-box relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200/80 z-10 my-auto animate-modal-in">
        
        <!-- Header Bar -->
        <div class="px-5 py-4 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800">
            <div class="flex items-center gap-3">
                <span id="facModalCategory" class="px-3 py-1 rounded-full text-xs font-bold bg-japan-600 text-white shadow-sm flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    <span>Akomodasi</span>
                </span>
                <span id="facModalCounter" class="text-xs font-semibold text-slate-400">
                    Fasilitas 1 dari 6
                </span>
            </div>

            <!-- Close & Quick Shortcuts -->
            <div class="flex items-center gap-2">
                <span class="hidden sm:inline-block text-[10px] text-slate-400 font-mono bg-slate-800 px-2 py-0.5 rounded border border-slate-700">ESC</span>
                <button 
                    type="button" 
                    onclick="closeModal('facilityModal')" 
                    class="w-9 h-9 rounded-full bg-slate-800 hover:bg-red-600 text-slate-300 hover:text-white flex items-center justify-center transition focus:outline-none"
                    aria-label="Tutup"
                >
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Lightbox Image Stage with Previous / Next Arrows -->
        <div class="relative aspect-[16/10] sm:aspect-[16/9] bg-slate-950 overflow-hidden select-none group">
            <img id="facModalImg" src="" alt="" class="w-full h-full object-cover transition-all duration-500">
            
            <!-- Left Carousel Button -->
            <button 
                type="button"
                onclick="prevFacilityLightbox()"
                class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/60 hover:bg-japan-600 text-white flex items-center justify-center transition-all duration-200 shadow-xl backdrop-blur-sm focus:outline-none hover:scale-110 active:scale-95"
                title="Foto Sebelumnya (Panah Kiri)"
                aria-label="Sebelumnya"
            >
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </button>

            <!-- Right Carousel Button -->
            <button 
                type="button"
                onclick="nextFacilityLightbox()"
                class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/60 hover:bg-japan-600 text-white flex items-center justify-center transition-all duration-200 shadow-xl backdrop-blur-sm focus:outline-none hover:scale-110 active:scale-95"
                title="Foto Selanjutnya (Panah Kanan)"
                aria-label="Selanjutnya"
            >
                <i data-lucide="chevron-right" class="w-6 h-6"></i>
            </button>

            <!-- Bottom Left Keyboard Hint Tag -->
            <div class="absolute bottom-3 left-4 hidden sm:flex items-center gap-2 bg-black/60 backdrop-blur-md px-3 py-1 rounded-full text-[11px] text-white/80">
                <span>Navigasi Keyboard:</span>
                <kbd class="font-mono bg-white/20 px-1.5 py-0.5 rounded text-[10px]">←</kbd>
                <kbd class="font-mono bg-white/20 px-1.5 py-0.5 rounded text-[10px]">→</kbd>
            </div>
        </div>

        <!-- Info Description & Quality Highlights -->
        <div class="p-6 sm:p-8 space-y-4 bg-white">
            <div class="space-y-1">
                <h3 id="facModalTitle" class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight"></h3>
                <p id="facModalDesc" class="text-xs sm:text-sm text-slate-600 leading-relaxed"></p>
            </div>

            <!-- Standard Quality Tags -->
            <div class="flex flex-wrap gap-2 pt-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-500"></i>
                    Standar Izin Kemnaker RI
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-red-50 text-japan-700 text-xs font-semibold border border-red-100">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-japan-600"></i>
                    Keamanan & Disiplin 24 Jam
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-100">
                    <i data-lucide="wifi" class="w-3.5 h-3.5 text-blue-500"></i>
                    Akses Wi-Fi Super Cepat
                </span>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button 
                    type="button" 
                    onclick="prevFacilityLightbox()" 
                    class="flex-1 sm:flex-initial px-4 py-2 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs transition flex items-center justify-center gap-1"
                >
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    Sebelumnya
                </button>
                <button 
                    type="button" 
                    onclick="nextFacilityLightbox()" 
                    class="flex-1 sm:flex-initial px-4 py-2 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs transition flex items-center justify-center gap-1"
                >
                    Selanjutnya
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <a 
                    id="facModalWaBtn"
                    href="#" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition"
                >
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Tanyakan Info Fasilitas via WA</span>
                </a>
                <button 
                    type="button" 
                    onclick="closeModal('facilityModal')" 
                    class="px-4 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition"
                >
                    Tutup
                </button>
            </div>
        </div>

    </div>
</div>
