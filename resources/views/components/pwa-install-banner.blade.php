<!-- Progressive Web App (PWA) Install Banner & Prompt -->
<div id="pwaInstallBanner" class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:max-w-md z-50 transform translate-y-32 opacity-0 transition-all duration-500 pointer-events-none">
    <div class="bg-slate-900/95 text-white backdrop-blur-md rounded-2xl p-4 border border-red-500/30 shadow-2xl shadow-black/40 flex items-start gap-3.5 ring-1 ring-white/10">
        
        <!-- App Icon -->
        <div class="w-12 h-12 rounded-xl bg-japan-600 text-white flex items-center justify-center font-japanese font-black text-xl flex-shrink-0 shadow-md shadow-red-600/30">
            友
        </div>

        <!-- Info & Actions -->
        <div class="flex-1 space-y-1.5">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-red-400 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-ping"></span>
                    <span>Aplikasi Resmi LPK SJI</span>
                </span>
                <button type="button" onclick="dismissPwaBanner()" class="text-slate-400 hover:text-white transition text-xs p-1" title="Tutup">
                    ✕
                </button>
            </div>

            <h4 class="text-xs sm:text-sm font-extrabold text-white leading-snug">
                Pasang Aplikasi di Layar Utama HP
            </h4>
            <p class="text-[11px] text-slate-300 leading-tight">
                Akses cepat katalog brosur, simulasi gaji, dan tryout CBT tanpa perlu mengetik alamat web.
            </p>

            <!-- Action Buttons -->
            <div class="pt-1.5 flex items-center gap-2">
                <button 
                    id="pwaInstallBtn" 
                    type="button" 
                    onclick="triggerPwaInstall()" 
                    class="btn-red-primary px-3.5 py-1.5 rounded-xl text-xs font-black flex items-center gap-1.5 shadow-md shadow-red-600/30 hover:scale-102 transition"
                >
                    <i data-lucide="smartphone" class="w-3.5 h-3.5"></i>
                    <span>Pasang Sekarang</span>
                </button>
                <button 
                    type="button" 
                    onclick="dismissPwaBanner()" 
                    class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold transition"
                >
                    Nanti Saja
                </button>
            </div>

            <!-- iOS Safari Special Instruction (Hidden by default, shown on iOS) -->
            <div id="pwaIosTip" class="hidden pt-1.5 text-[10px] text-amber-300/90 flex items-start gap-1.5 bg-amber-500/10 p-2 rounded-lg border border-amber-500/20">
                <i data-lucide="share" class="w-3.5 h-3.5 flex-shrink-0 mt-0.5"></i>
                <span>Di iPhone: Ketuk tombol <strong>Share</strong> (ikon kotak panah ke atas) di Safari, lalu pilih <strong>'Tambah ke Layar Utama' (Add to Home Screen)</strong>.</span>
            </div>
        </div>

    </div>
</div>

<script>
    // PWA Service Worker Registration & Install Prompt Handler
    let deferredPwaPrompt = null;

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then((reg) => {
                    console.log('PWA ServiceWorker registered successfully with scope:', reg.scope);
                })
                .catch((err) => {
                    console.warn('PWA ServiceWorker registration failed:', err);
                });
        });
    }

    // Detect if already installed (standalone mode)
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;
    const isDismissed = localStorage.getItem('lpk_pwa_dismissed');

    // Detect iOS
    const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent immediate Chrome mini-infobar
        e.preventDefault();
        deferredPwaPrompt = e;

        if (!isStandalone && !isDismissed) {
            setTimeout(() => {
                showPwaBanner();
            }, 3000);
        }
    });

    // Show prompt on iOS Safari if not standalone
    if (isIos && !isStandalone && !isDismissed) {
        setTimeout(() => {
            const iosTip = document.getElementById('pwaIosTip');
            const installBtn = document.getElementById('pwaInstallBtn');
            if (iosTip) iosTip.classList.remove('hidden');
            if (installBtn) installBtn.classList.add('hidden');
            showPwaBanner();
        }, 4000);
    }

    function showPwaBanner() {
        const banner = document.getElementById('pwaInstallBanner');
        if (!banner) return;
        banner.classList.remove('translate-y-32', 'opacity-0', 'pointer-events-none');
        banner.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
        if (window.lucide) lucide.createIcons();
    }

    function dismissPwaBanner() {
        const banner = document.getElementById('pwaInstallBanner');
        if (!banner) return;
        banner.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
        banner.classList.add('translate-y-32', 'opacity-0', 'pointer-events-none');
        localStorage.setItem('lpk_pwa_dismissed', 'true');
    }

    function triggerPwaInstall() {
        if (!deferredPwaPrompt) return;
        deferredPwaPrompt.prompt();
        deferredPwaPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted PWA installation');
                dismissPwaBanner();
            }
            deferredPwaPrompt = null;
        });
    }
</script>
