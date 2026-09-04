@extends('layouts.app')

@section('title', 'Tanya Jawab & Syarat Resmi Pelatihan Kerja ke Jepang - FAQ LPK Sahabat Jepang Indonesia')
@section('meta_description', 'Pusat informasi dan FAQ resmi LPK Sahabat Jepang Indonesia: syarat fisik (tato, mata minus, tinggi badan), skema dana talangan cicil kerja, beasiswa SMILE Project Kemenkes, dan alur visa SSW.')
@section('meta_keywords', 'faq lpk jepang, syarat fisik kerja jepang, tato kerja di jepang, mata minus magang jepang, dana talangan jepang, beasiswa smile project kemenkes, sahabat jepang indonesia faq')

@section('content')
@php
    $cleanWa = preg_replace('/[^0-9]/', '', $settings['contact_whatsapp'] ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) $cleanWa = '62' . substr($cleanWa, 1);
@endphp
<div class="bg-slate-950 text-white min-h-screen py-10 sm:py-16 relative overflow-hidden">
    
    <!-- Ambient Japanese Red Glow Background -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-red-600/15 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/3 -right-32 w-96 h-96 rounded-full bg-rose-600/10 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 w-80 h-80 rounded-full bg-amber-600/10 blur-[140px] pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-10">

        <!-- Top Header Hero -->
        <div class="text-center space-y-4 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold font-japanese shadow-xs">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span>よくある質問・Pusat Tanya Jawab & Informasi Resmi LPK SJI</span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                Pertanyaan yang Sering Diajukan
            </h1>
            
            <p class="text-xs sm:text-sm md:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto">
                Temukan jawaban transparan seputar persyaratan fisik, tes kesehatan, pembiayaan dana talangan, program pemerintah, dan legalitas keberangkatan ke Jepang.
            </p>

            <!-- Search Bar (Live Filter) -->
            <div class="pt-4 max-w-xl mx-auto">
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        id="faqPageSearchInput"
                        oninput="filterFaqPageList()"
                        placeholder="Cari pertanyaan... (contoh: tato, mata minus, talangan, beasiswa)"
                        class="w-full pl-11 pr-10 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-xs sm:text-sm text-white placeholder-slate-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition shadow-inner"
                    >
                    <button 
                        type="button" 
                        id="faqPageClearBtn" 
                        onclick="clearFaqPageFilter()" 
                        class="hidden absolute right-3.5 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full bg-slate-800 text-slate-400 hover:text-white flex items-center justify-center text-xs"
                    >
                        ✕
                    </button>
                </div>
            </div>

            <!-- Filter Pills by Category -->
            <div class="flex flex-wrap items-center justify-center gap-2 pt-2">
                @foreach($categories as $catKey => $catData)
                    <a 
                        href="{{ route('faq.index', $catKey === 'all' ? [] : ['category' => $catKey]) }}" 
                        class="faq-cat-pill px-4 py-1.5 rounded-full text-xs font-bold transition flex items-center gap-1.5 {{ $selectedCategory === $catKey ? 'bg-japan-600 text-white shadow-md shadow-red-600/30' : 'bg-slate-900/90 text-slate-300 hover:bg-slate-800 border border-slate-800' }}"
                        data-category="{{ $catKey }}"
                    >
                        <span>{{ $catData['label'] }}</span>
                        <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedCategory === $catKey ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400' }}">
                            {{ $catData['count'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Controls Bar (Counters & Expand All) -->
        <div class="p-4 rounded-2xl bg-slate-900/70 border border-slate-800/80 flex flex-wrap items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2 text-slate-400">
                <i data-lucide="help-circle" class="w-4 h-4 text-red-400"></i>
                <span id="faqCountLabel" class="font-bold text-slate-200">
                    {{ count($faqs) }} Pertanyaan Tersedia
                </span>
                <span class="text-slate-700">•</span>
                <span class="text-emerald-400 font-semibold flex items-center gap-1">
                    <i data-lucide="check-check" class="w-3.5 h-3.5"></i>
                    Informasi Terverifikasi Kemnaker RI
                </span>
            </div>

            <div class="flex items-center gap-2">
                <button 
                    type="button" 
                    onclick="toggleAllFaqCards(true)" 
                    class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-[11px] font-bold transition flex items-center gap-1"
                >
                    <i data-lucide="chevrons-down" class="w-3.5 h-3.5"></i>
                    <span>Buka Semua</span>
                </button>
                <button 
                    type="button" 
                    onclick="toggleAllFaqCards(false)" 
                    class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-[11px] font-bold transition flex items-center gap-1"
                >
                    <i data-lucide="chevrons-up" class="w-3.5 h-3.5"></i>
                    <span>Tutup Semua</span>
                </button>
            </div>
        </div>

        <!-- Accordion FAQ Items Grid -->
        <div id="faqItemsContainer" class="space-y-4">
            @forelse($faqs as $index => $faq)
                <div 
                    class="faq-page-item bg-slate-900/80 rounded-2xl border border-slate-800 hover:border-slate-700 transition duration-200 shadow-md group overflow-hidden"
                    data-question="{{ strtolower($faq->question) }}"
                    data-answer="{{ strtolower($faq->answer) }}"
                    data-category="{{ $faq->category }}"
                >
                    <button 
                        type="button" 
                        onclick="toggleFaqCard(this)" 
                        class="faq-page-btn w-full p-5 sm:p-6 text-left flex items-start justify-between gap-4 select-none"
                    >
                        <div class="space-y-1.5 pr-2">
                            <!-- Category badge -->
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider
                                    {{ $faq->category === 'syarat_fisik' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : '' }}
                                    {{ $faq->category === 'biaya' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : '' }}
                                    {{ $faq->category === 'program' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : '' }}
                                    {{ $faq->category === 'pelatihan' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : '' }}
                                    {{ $faq->category === 'umum' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : '' }}
                                ">
                                    {{ $categories[$faq->category]['label'] ?? 'Umum' }}
                                </span>
                            </div>
                            <h3 class="text-sm sm:text-base font-bold text-white group-hover:text-red-400 transition leading-snug">
                                {{ $faq->question }}
                            </h3>
                        </div>

                        <span class="faq-icon-box w-8 h-8 rounded-xl bg-slate-800 group-hover:bg-red-600 text-slate-300 group-hover:text-white flex items-center justify-center flex-shrink-0 transition-transform duration-300">
                            <i data-lucide="chevron-down" class="faq-icon w-4 h-4 transition-transform duration-300"></i>
                        </span>
                    </button>

                    <div class="faq-content-box hidden px-5 sm:px-6 pb-6 pt-0 border-t border-slate-800/60 mt-1">
                        <div class="text-xs sm:text-sm text-slate-300 leading-relaxed pt-4 space-y-3">
                            <p>{!! nl2br(e($faq->answer)) !!}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center text-slate-500 space-y-2">
                    <i data-lucide="inbox" class="w-10 h-10 mx-auto opacity-40"></i>
                    <p class="text-sm font-semibold">Belum ada pertanyaan pada kategori ini.</p>
                    <a href="{{ route('faq.index') }}" class="text-xs text-japan-400 font-bold hover:underline block mt-2">Lihat semua FAQ</a>
                </div>
            @endforelse
        </div>

        <!-- Empty Search Fallback State -->
        <div id="faqEmptySearchNotice" class="hidden py-16 text-center text-slate-400 space-y-3 bg-slate-900/60 rounded-3xl border border-dashed border-slate-800">
            <i data-lucide="search-x" class="w-10 h-10 mx-auto text-slate-500"></i>
            <p class="text-sm font-bold text-white">Tidak ada pertanyaan yang sesuai dengan kata kunci Anda</p>
            <p class="text-xs text-slate-400 max-w-md mx-auto">Pertanyaan Anda belum tercantum di atas? Konsultan resmi LPK SJI siap memberikan penjelasan langsung secara ramah dan terperinci.</p>
            <div class="pt-2 flex justify-center gap-3">
                <button onclick="clearFaqPageFilter()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold transition">
                    Reset Pencarian
                </button>
                <a href="https://api.whatsapp.com/send?phone={{ $cleanWa }}&text={{ urlencode('Halo Konselor LPK SJI, saya membaca halaman FAQ dan memiliki pertanyaan khusus.') }}" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                    <span>Tanya Konselor via WA</span>
                </a>
            </div>
        </div>

        <!-- Bottom VIP Consultation Banner -->
        <div class="bg-gradient-to-r from-red-950/70 via-slate-900 to-slate-950 border border-red-500/20 rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl">
            <div class="space-y-1.5 text-center md:text-left max-w-xl">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-red-500/20 text-red-400 text-[10px] font-black uppercase">
                    <i data-lucide="headphones" class="w-3 h-3"></i>
                    <span>Layanan Konsultasi 24/7 Gratis</span>
                </div>
                <h4 class="text-lg sm:text-xl font-black text-white">Masih Ragu dengan Persyaratan Fisik atau Biaya?</h4>
                <p class="text-xs text-slate-300 leading-relaxed">Konsultasikan langsung profil diri Anda (usia, riwayat medis, dan minat jurusan) bersama konselor resmi kami secara rahasia dan bebas biaya.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3 flex-shrink-0">
                <a 
                    href="{{ route('brochure.index') }}" 
                    class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition flex items-center gap-2"
                >
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>Unduh Brosur Lengkap</span>
                </a>
                <a 
                    href="https://api.whatsapp.com/send?phone={{ $cleanWa }}&text={{ urlencode('Halo LPK Sahabat Jepang Indonesia, saya ingin berkonsultasi mengenai persyaratan fisik dan skema pembiayaan pelatihan.') }}" 
                    target="_blank" 
                    class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition flex items-center gap-2 shadow-lg shadow-emerald-600/30"
                >
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Chat Konselor WhatsApp</span>
                </a>
            </div>
        </div>

    </div>

</div>

<!-- Interactive FAQ Script -->
<script>
    function toggleFaqCard(button) {
        const item = button.closest('.faq-page-item');
        const content = item.querySelector('.faq-content-box');
        const icon = item.querySelector('.faq-icon');

        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            if (icon) icon.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('hidden');
            if (icon) icon.style.transform = 'rotate(0deg)';
        }
    }

    function toggleAllFaqCards(shouldOpen) {
        const items = document.querySelectorAll('.faq-page-item');
        items.forEach(item => {
            const content = item.querySelector('.faq-content-box');
            const icon = item.querySelector('.faq-icon');
            if (shouldOpen) {
                content.classList.remove('hidden');
                if (icon) icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                if (icon) icon.style.transform = 'rotate(0deg)';
            }
        });
    }

    function filterFaqPageList() {
        const input = document.getElementById('faqPageSearchInput');
        const q = (input ? input.value : '').toLowerCase().trim();
        const clearBtn = document.getElementById('faqPageClearBtn');
        const items = document.querySelectorAll('.faq-page-item');
        const emptyState = document.getElementById('faqEmptySearchNotice');
        const countLabel = document.getElementById('faqCountLabel');

        if (clearBtn) clearBtn.style.display = q.length > 0 ? 'flex' : 'none';

        let visibleCount = 0;
        items.forEach(item => {
            const question = item.getAttribute('data-question') || '';
            const answer = item.getAttribute('data-answer') || '';
            const full = question + ' ' + answer;

            if (!q || full.includes(q)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (countLabel) {
            countLabel.textContent = `${visibleCount} Pertanyaan Ditemukan`;
        }

        if (emptyState) {
            emptyState.style.display = (visibleCount === 0 && items.length > 0) ? 'block' : 'none';
        }
    }

    function clearFaqPageFilter() {
        const input = document.getElementById('faqPageSearchInput');
        if (input) input.value = '';
        filterFaqPageList();
    }
</script>

<!-- Google Schema.org FAQPage Structured Data (JSON-LD) for Rich Snippets -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    @foreach($faqs as $f)
    {
      "@@type": "Question",
      "name": {!! json_encode($f->question) !!},
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": {!! json_encode(strip_tags($f->answer)) !!}
      }
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endsection
