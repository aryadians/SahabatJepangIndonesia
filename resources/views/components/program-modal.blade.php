<!-- Detailed Program Info Modal Pop-up -->
<div id="programDetailModal" class="custom-modal fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
    
    <!-- Backdrop Blur -->
    <div class="modal-backdrop-blur fixed inset-0"></div>

    <!-- Modal Box -->
    <div class="modal-content-box relative w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100 z-10 my-8">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-japan-900 via-japan-700 to-japan-800 text-white p-6 sm:p-8 relative">
            <button 
                type="button" 
                onclick="closeModal('programDetailModal')" 
                class="absolute top-5 right-5 w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition focus:outline-none"
            >
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div class="flex items-center gap-2 mb-2">
                <span class="px-3 py-0.5 rounded-full text-xs font-bold bg-white/20 backdrop-blur-sm text-white">Rincian Program</span>
                <span id="progModalJapTitle" class="font-japanese text-sm font-bold text-red-200"></span>
            </div>
            
            <h3 id="progModalTitle" class="text-2xl sm:text-3xl font-black text-white tracking-tight"></h3>
            <p id="progModalSubtitle" class="text-xs sm:text-sm text-red-100 mt-1"></p>
        </div>

        <!-- Modal Body Content -->
        <div class="p-6 sm:p-8 space-y-6 max-h-[70vh] overflow-y-auto">
            
            <!-- Salary & Duration Highlights -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-2xl bg-red-50/70 border border-red-100">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Estimasi Penghasilan</span>
                    <p id="progModalSalaryYen" class="text-lg font-extrabold text-japan-700"></p>
                    <p id="progModalSalaryIdr" class="text-xs text-slate-500"></p>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Masa Kontrak & Legalitas</span>
                    <p id="progModalDuration" class="text-sm font-bold text-slate-800 mt-0.5"></p>
                    <p class="text-xs text-emerald-600 font-semibold">Izin Visa Kerja Resmi Jepang</p>
                </div>
            </div>

            <!-- Description -->
            <div>
                <h4 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-2">Deskripsi Program</h4>
                <p id="progModalDesc" class="text-sm text-slate-600 leading-relaxed"></p>
            </div>

            <!-- Sectors -->
            <div>
                <h4 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-2">Pilihan Bidang Sektor Kerja</h4>
                <ul id="progModalSectors" class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm text-slate-700"></ul>
            </div>

            <!-- Requirements -->
            <div>
                <h4 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-2">Kualifikasi & Persyaratan</h4>
                <ul id="progModalReqs" class="space-y-1.5 text-xs sm:text-sm text-slate-700"></ul>
            </div>

            <!-- Benefits -->
            <div>
                <h4 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-2">Fasilitas & Keuntungan</h4>
                <ul id="progModalBenefits" class="space-y-1.5 text-xs sm:text-sm text-slate-700"></ul>
            </div>

        </div>

        <!-- Footer Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-3">
            <button 
                type="button" 
                onclick="closeModal('programDetailModal')" 
                class="w-full sm:w-auto px-5 py-3 rounded-xl border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-100 transition"
            >
                Tutup
            </button>
            <button 
                type="button" 
                id="registerFromProgModalBtn" 
                class="w-full sm:w-auto btn-red-primary px-7 py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-md"
            >
                <i data-lucide="send" class="w-4 h-4"></i>
                <span>Daftar Program Ini Sekarang</span>
            </button>
        </div>

    </div>
</div>
