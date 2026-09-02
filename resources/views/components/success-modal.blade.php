<!-- Registration Success Celebration Modal -->
<div id="successModal" class="custom-modal fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
    
    <!-- Backdrop Blur -->
    <div class="modal-backdrop-blur fixed inset-0"></div>

    <!-- Modal Box -->
    <div class="modal-content-box relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border border-emerald-100 z-10 my-8 text-center p-8">
        
        <!-- Animated Success Badge -->
        <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-6 ring-8 ring-emerald-50">
            <i data-lucide="check" class="w-10 h-10 stroke-[3]"></i>
        </div>

        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-japan-700 text-xs font-bold mb-3">
            <span class="font-japanese">登録完了</span>
            <span>• Pendaftaran Berhasil</span>
        </div>

        <h3 class="text-2xl font-black text-slate-900 tracking-tight">
            Selamat! Data Anda Berhasil Dikirim
        </h3>
        
        <p id="successMessage" class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
            Terima kasih telah mempercayakan langkah awal karir Anda bersama LPK Sahabat Jepang Indonesia. Tim konselor kami akan segera menghubungi nomor WhatsApp Anda.
        </p>

        <!-- Action Buttons -->
        <div class="mt-8 space-y-3">
            <a 
                id="successWaBtn"
                href="https://api.whatsapp.com/send?phone=6281234567890" 
                target="_blank" 
                rel="noopener noreferrer"
                class="w-full btn-red-primary py-3.5 rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-red-600/30"
            >
                <i data-lucide="message-circle" class="w-5 h-5"></i>
                <span>Konfirmasi Langsung via WhatsApp</span>
            </a>

            <button 
                type="button" 
                onclick="closeModal('successModal')" 
                class="w-full py-3 rounded-xl border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-50 transition"
            >
                Kembali ke Beranda
            </button>
        </div>

    </div>
</div>
