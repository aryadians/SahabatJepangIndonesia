<!-- FAQ (Pertanyaan yang Sering Diajukan) Section -->
<section id="faq" class="py-20 lg:py-28 bg-[#FFF8F8] relative overflow-hidden border-t border-red-100">
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3 reveal-on-scroll">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-bold uppercase tracking-wider">
                <span class="font-japanese text-sm">よくある質問</span>
                <span>• Tanya Jawab Seputar Karir Jepang</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                Pertanyaan yang Sering <br class="hidden sm:inline">
                <span class="text-japan-600">Diajukan Calon Siswa & Orang Tua</span>
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Temukan jawaban lengkap mengenai persyaratan, alur pelatihan, pembiayaan, hingga keberangkatan ke Jepang.
            </p>
        </div>

        <!-- Accordion Container -->
        <div class="space-y-4">
            @foreach($faqs as $index => $faq)
                <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden transition-all duration-200 hover:border-red-300 reveal-on-scroll delay-{{ ($index + 1) * 100 }}">
                    <button 
                        type="button" 
                        class="faq-toggle w-full p-6 text-left flex items-center justify-between gap-4 font-extrabold text-slate-900 hover:text-japan-600 transition-colors focus:outline-none"
                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                    >
                        <span class="text-base sm:text-lg flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center text-xs font-bold flex-shrink-0">Q{{ $index + 1 }}</span>
                            {{ $faq['q'] }}
                        </span>
                        <div class="faq-icon w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 transition-transform duration-300 flex-shrink-0" style="{{ $index === 0 ? 'transform: rotate(180deg);' : '' }}">
                            <i data-lucide="chevron-down" class="w-5 h-5"></i>
                        </div>
                    </button>

                    <div class="faq-answer px-6 pb-6 text-slate-600 text-sm sm:text-base leading-relaxed border-t border-slate-100 pt-4 {{ $index === 0 ? '' : 'hidden' }}">
                        {{ $faq['a'] }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Need Help Contact Footer -->
        <div class="mt-12 text-center reveal-on-scroll">
            <p class="text-sm text-slate-600 font-medium">
                Punya pertanyaan lain yang belum terjawab di sini?
            </p>
            <div class="mt-3 flex items-center justify-center gap-3">
                <a 
                    href="https://api.whatsapp.com/send?phone=6281234567890&text=Halo%20Admin%20LPK%20Sahabat%20Jepang%20Indonesia,%20saya%20ingin%20konsultasi%20tanya%20jawab%20program" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 text-sm font-bold text-japan-600 hover:text-japan-700 bg-white px-5 py-2.5 rounded-xl border border-red-200 shadow-sm transition"
                >
                    <i data-lucide="message-circle" class="w-4 h-4 text-emerald-600"></i>
                    <span>Tanya Langsung ke Konselor via WhatsApp</span>
                </a>
            </div>
        </div>

    </div>
</section>
