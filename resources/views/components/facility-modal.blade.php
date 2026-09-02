<!-- Facility Lightbox Preview Modal -->
<div id="facilityModal" class="custom-modal fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
    
    <!-- Backdrop Blur -->
    <div class="modal-backdrop-blur fixed inset-0"></div>

    <!-- Modal Box -->
    <div class="modal-content-box relative w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100 z-10 my-8">
        
        <!-- Close Button -->
        <button 
            type="button" 
            onclick="closeModal('facilityModal')" 
            class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center transition focus:outline-none backdrop-blur-sm"
        >
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <!-- Image Container -->
        <div class="relative aspect-[16/10] bg-slate-900 overflow-hidden">
            <img id="facModalImg" src="" alt="" class="w-full h-full object-cover">
            
            <div class="absolute top-4 left-4">
                <span id="facModalCategory" class="px-3 py-1 rounded-full text-xs font-bold bg-japan-600 text-white shadow-md"></span>
            </div>
        </div>

        <!-- Info Description -->
        <div class="p-6 sm:p-8 space-y-2">
            <h3 id="facModalTitle" class="text-2xl font-extrabold text-slate-900"></h3>
            <p id="facModalDesc" class="text-sm text-slate-600 leading-relaxed"></p>
        </div>

        <!-- Footer -->
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button 
                type="button" 
                onclick="closeModal('facilityModal')" 
                class="px-6 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-sm transition"
            >
                Tutup Preview
            </button>
        </div>

    </div>
</div>
