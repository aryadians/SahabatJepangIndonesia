<!-- FAQ (Pertanyaan yang Sering Diajukan) Section -->
@php
    $cleanWa = preg_replace('/[^0-9]/', '', $settings['contact_whatsapp'] ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) $cleanWa = '62' . substr($cleanWa, 1);
@endphp
<section id="faq" class="py-20 lg:py-28 bg-[#FFF8F8] relative overflow-hidden border-t border-red-100">
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 space-y-3 reveal-on-scroll">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-bold uppercase tracking-wider">
                <span class="font-japanese text-sm">よくある質問</span>
                <span>• Tanya Jawab Seputar Karir Jepang</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                Pertanyaan yang Sering <br class="hidden sm:inline">
                <span class="text-japan-600">Diajukan Calon Siswa & Orang Tua</span>
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Temukan jawaban lengkap mengenai persyaratan, alur pelatihan, pembiayaan dana talangan, hingga keberangkatan ke Jepang.
            </p>
        </div>

        <!-- Search Bar & Controls -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-sm mb-8 space-y-4 reveal-on-scroll">
            <!-- Search Input -->
            <div class="relative">
                <i data-lucide="search" class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    id="faqSearchInput" 
                    oninput="filterFaq()"
                    placeholder="Cari pertanyaan... (contoh: biaya, dana talangan, syarat usia, asrama, visa)"
                    class="w-full pl-12 pr-10 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-sm text-slate-800 transition outline-none"
                >
                <button 
                    type="button" 
                    id="faqClearSearch" 
                    onclick="clearFaqSearch()"
                    class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-bold transition"
                    title="Hapus pencarian"
                >
                    ✕
                </button>
            </div>

            <!-- Quick Filter Chips & Action Controls -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-1 border-t border-slate-100 text-xs">
                <!-- Topic Chips -->
                <div class="flex flex-wrap items-center gap-1.5 w-full sm:w-auto">
                    <button 
                        type="button" 
                        onclick="setFaqFilterTopic('all', this)"
                        class="faq-topic-chip active px-3 py-1.5 rounded-lg font-bold transition-all bg-japan-600 text-white shadow-sm"
                        data-topic="all"
                    >
                        Semua Topik
                    </button>
                    <button 
                        type="button" 
                        onclick="setFaqFilterTopic('biaya', this)"
                        class="faq-topic-chip px-3 py-1.5 rounded-lg font-semibold transition-all bg-slate-100 hover:bg-slate-200 text-slate-600"
                        data-topic="biaya"
                    >
                        Biaya & Talangan
                    </button>
                    <button 
                        type="button" 
                        onclick="setFaqFilterTopic('syarat', this)"
                        class="faq-topic-chip px-3 py-1.5 rounded-lg font-semibold transition-all bg-slate-100 hover:bg-slate-200 text-slate-600"
                        data-topic="syarat"
                    >
                        Syarat & Usia
                    </button>
                    <button 
                        type="button" 
                        onclick="setFaqFilterTopic('visa', this)"
                        class="faq-topic-chip px-3 py-1.5 rounded-lg font-semibold transition-all bg-slate-100 hover:bg-slate-200 text-slate-600"
                        data-topic="visa"
                    >
                        Visa & Kontrak
                    </button>
                    <button 
                        type="button" 
                        onclick="setFaqFilterTopic('asrama', this)"
                        class="faq-topic-chip px-3 py-1.5 rounded-lg font-semibold transition-all bg-slate-100 hover:bg-slate-200 text-slate-600"
                        data-topic="asrama"
                    >
                        Asrama & Kelas
                    </button>
                </div>

                <!-- Expand / Collapse All -->
                <div class="flex items-center gap-2 self-end sm:self-auto flex-shrink-0">
                    <span id="faqCounter" class="text-slate-400 font-medium mr-2">
                        {{ count($faqs) }} pertanyaan
                    </span>
                    <button 
                        type="button" 
                        onclick="toggleAllFaqs(true)"
                        class="px-2.5 py-1 rounded-md text-slate-600 hover:text-japan-600 hover:bg-red-50 font-bold transition"
                    >
                        Buka Semua
                    </button>
                    <span class="text-slate-200">|</span>
                    <button 
                        type="button" 
                        onclick="toggleAllFaqs(false)"
                        class="px-2.5 py-1 rounded-md text-slate-600 hover:text-japan-600 hover:bg-red-50 font-bold transition"
                    >
                        Tutup Semua
                    </button>
                </div>
            </div>
        </div>

        <!-- Accordion Container -->
        <div id="faqAccordionList" class="space-y-4">
            @foreach($faqs as $index => $faq)
                <div 
                    class="faq-card rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden transition-all duration-200 hover:border-red-300 reveal-on-scroll delay-{{ (($index % 4) + 1) * 100 }}"
                    data-question="{{ strtolower($faq['q']) }}"
                    data-answer="{{ strtolower($faq['a']) }}"
                >
                    <button 
                        type="button" 
                        class="faq-toggle w-full p-6 text-left flex items-center justify-between gap-4 font-extrabold text-slate-900 hover:text-japan-600 transition-colors focus:outline-none"
                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                    >
                        <span class="text-base sm:text-lg flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center text-xs font-bold flex-shrink-0">Q{{ $index + 1 }}</span>
                            <span class="faq-question-text">{{ $faq['q'] }}</span>
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

        <!-- Empty State (Hidden by default) -->
        <div id="faqEmptyState" class="hidden text-center py-12 px-6 bg-white rounded-3xl border border-dashed border-slate-300 shadow-sm space-y-4 my-4">
            <div class="w-16 h-16 rounded-full bg-red-50 text-japan-600 flex items-center justify-center mx-auto text-2xl">
                🔍
            </div>
            <div class="space-y-1">
                <h4 class="text-lg font-extrabold text-slate-900">Pertanyaan Tidak Ditemukan</h4>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                    Topik yang Anda cari belum ada di daftar. Jangan khawatir, konselor resmi kami siap menjawab via WhatsApp.
                </p>
            </div>
            <div class="pt-2">
                <a 
                    id="faqEmptyWaLink"
                    href="https://api.whatsapp.com/send?phone={{ $cleanWa }}&text=Halo%20Admin%20LPK%20Sahabat%20Jepang%20Indonesia,%20saya%20ingin%20bertanya%20seputar%20program" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-5 py-2.5 rounded-xl shadow-md transition"
                >
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Tanyakan Langsung ke Konselor</span>
                </a>
            </div>
        </div>

        <!-- Need Help Contact Footer -->
        <div class="mt-12 text-center reveal-on-scroll">
            <p class="text-sm text-slate-600 font-medium">
                Punya pertanyaan lain yang belum terjawab di sini?
            </p>
            <div class="mt-3 flex items-center justify-center gap-3">
                <a 
                    href="https://api.whatsapp.com/send?phone={{ $cleanWa }}&text=Halo%20Admin%20LPK%20Sahabat%20Jepang%20Indonesia,%20saya%20ingin%20konsultasi%20tanya%20jawab%20program" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 text-sm font-bold text-japan-600 hover:text-japan-700 bg-white px-5 py-2.5 rounded-xl border border-red-200 shadow-sm transition hover:shadow"
                >
                    <i data-lucide="message-circle" class="w-4 h-4 text-emerald-600"></i>
                    <span>Tanya Langsung ke Konselor via WhatsApp</span>
                </a>
            </div>
        </div>

    </div>
</section>
