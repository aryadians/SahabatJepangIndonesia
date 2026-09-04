@extends('layouts.app')

@section('title', $article->title . ' - LPK Sahabat Jepang Indonesia')
@section('meta_description', Str::limit(strip_tags($article->excerpt ?: $article->content), 160))
@section('meta_image', $article->image ? asset($article->image) : asset('images/og-share-banner.jpg'))
@section('meta_type', 'article')

@section('content')
<!-- Scroll Reading Progress Bar -->
<div id="readingProgressBar" class="fixed top-0 left-0 h-1.5 bg-gradient-to-r from-red-600 via-amber-500 to-japan-600 z-[100] transition-all duration-75 shadow-sm" style="width: 0%;"></div>

<!-- Article Detail Header -->
<article class="bg-white py-10 sm:py-16 relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-japan-600">Beranda</a>
            <span>/</span>
            <a href="{{ route('articles.index') }}" class="hover:text-japan-600">Artikel</a>
            <span>/</span>
            <span class="text-slate-600 truncate max-w-xs">{{ $article->category }}</span>
        </nav>

        <!-- Title & Meta -->
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <span class="inline-block px-3.5 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-bold">
                    {{ $article->category }}
                </span>
                <span class="inline-flex items-center gap-1 text-xs text-slate-400 font-medium">
                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                    Edukasi Karir Jepang
                </span>
            </div>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                {{ $article->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-2 border-y border-slate-100 py-3">
                <div class="flex items-center gap-2 font-semibold text-slate-700">
                    <div class="w-6 h-6 rounded-full bg-red-100 text-japan-600 flex items-center justify-center font-bold text-[10px]">
                        SJI
                    </div>
                    <span>{{ $article->author }}</span>
                </div>
                <span>•</span>
                <div class="flex items-center gap-1.5">
                    <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                    <span>{{ $article->created_at->format('d F Y') }}</span>
                </div>
                <span>•</span>
                <div class="flex items-center gap-1.5">
                    <i data-lucide="clock" class="w-4 h-4 text-slate-400"></i>
                    <span>{{ $article->reading_time }} menit baca</span>
                </div>
                <span>•</span>
                <div class="flex items-center gap-1.5">
                    <i data-lucide="eye" class="w-4 h-4 text-slate-400"></i>
                    <span>{{ $article->views }} x dibaca</span>
                </div>
            </div>
        </div>

        <!-- Reading Preferences Bar (Font Size Adjuster & Social Quick Share) -->
        <div class="flex flex-wrap items-center justify-between gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600">
            <!-- Share Quick Buttons -->
            <div class="flex items-center gap-2">
                <span class="font-bold text-slate-700">Bagikan:</span>
                <a 
                    href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . url()->current()) }}" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="p-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition"
                    title="Bagikan ke WhatsApp"
                >
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                </a>
                <a 
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 transition"
                    title="Bagikan ke Facebook"
                >
                    <i data-lucide="facebook" class="w-4 h-4"></i>
                </a>
                <a 
                    href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="p-2 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 transition"
                    title="Bagikan ke X"
                >
                    <i data-lucide="twitter" class="w-4 h-4"></i>
                </a>
                <button 
                    type="button" 
                    onclick="copyArticleLink()" 
                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-white hover:bg-slate-200 border border-slate-200 text-slate-700 font-bold transition"
                    title="Salin Tautan"
                >
                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                    <span id="copyLinkText">Salin Tautan</span>
                </button>
            </div>

            <!-- Font Size Adjuster -->
            <div class="flex items-center gap-1.5">
                <span class="font-semibold text-slate-500">Ukuran Teks:</span>
                <button 
                    type="button" 
                    onclick="changeArticleFontSize('sm')" 
                    class="font-size-btn px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-100 transition"
                    data-size="sm"
                >
                    A-
                </button>
                <button 
                    type="button" 
                    onclick="changeArticleFontSize('base')" 
                    class="font-size-btn active px-2.5 py-1 rounded-lg bg-japan-600 text-white text-xs font-bold transition shadow-sm"
                    data-size="base"
                >
                    Normal
                </button>
                <button 
                    type="button" 
                    onclick="changeArticleFontSize('lg')" 
                    class="font-size-btn px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-100 transition"
                    data-size="lg"
                >
                    A+
                </button>
            </div>
        </div>

        <!-- Featured Image -->
        @if($article->thumbnail)
            <div class="rounded-3xl overflow-hidden shadow-xl aspect-[16/9] bg-slate-100 border border-slate-200">
                <img src="{{ $article->thumbnail }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Article Content Body -->
        <div id="articleContentBody" class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4 text-base sm:text-lg border-b border-slate-100 pb-12 transition-all duration-200">
            {!! $article->content !!}
        </div>

        <!-- Author Bio & Accreditation Card -->
        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center sm:items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-japan-600 text-white font-black text-xl flex items-center justify-center flex-shrink-0 shadow-md">
                SJI
            </div>
            <div class="space-y-1 text-center sm:text-left flex-1">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                    <h4 class="font-extrabold text-slate-900 text-base">Tim Sensei & Konselor SJI</h4>
                    <span class="px-2 py-0.5 rounded-full bg-red-100 text-japan-700 text-[10px] font-bold">Terverifikasi Kemnaker</span>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Artikel ini disusun dan ditinjau oleh instruktur bahasa Jepang berlisensi JLPT N2/N1 serta praktisi Sending Organization resmi LPK Sahabat Jepang Indonesia untuk memberikan panduan akurat bagi calon tenaga kerja Indonesia di Jepang.
                </p>
            </div>
        </div>

        <!-- Share & Call To Action Box -->
        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-red-50 via-white to-red-100 border border-red-200 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm">
            <div class="space-y-1 text-center sm:text-left">
                <h4 class="text-lg font-black text-slate-900">Tertarik Berkarir ke Jepang?</h4>
                <p class="text-xs sm:text-sm text-slate-600">Konsultasikan pilihan program kerja dan jadwal kelas bersama konselor kami secara gratis.</p>
            </div>
            <button 
                onclick="openModal('consultationModal')" 
                class="btn-red-primary px-6 py-3.5 rounded-2xl text-xs sm:text-sm font-bold shadow-lg flex-shrink-0 flex items-center gap-2 hover:scale-105 active:scale-95 transition-transform"
            >
                <i data-lucide="sparkles" class="w-4 h-4 text-amber-200"></i>
                <span>Konsultasi Sekarang</span>
            </button>
        </div>

        <!-- Related Articles -->
        @if($relatedArticles->count() > 0)
            <div class="pt-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-extrabold text-slate-900 text-xl">Artikel Terkait Lainnya</h3>
                    <a href="{{ route('articles.index') }}" class="text-xs font-bold text-japan-600 hover:text-japan-700 flex items-center gap-1">
                        <span>Lihat Semua Artikel</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                        <a href="{{ route('articles.show', $rel->slug) }}" class="group bg-slate-50 rounded-2xl p-4 border border-slate-200 hover:border-japan-300 transition space-y-3 flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="h-32 rounded-xl overflow-hidden bg-slate-200">
                                    <img src="{{ $rel->thumbnail }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                </div>
                                <span class="text-[10px] font-bold text-japan-600 uppercase">{{ $rel->category }}</span>
                                <h4 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-japan-700 transition line-clamp-2">
                                    {{ $rel->title }}
                                </h4>
                            </div>
                            <div class="pt-2 text-[11px] text-slate-400 flex items-center justify-between border-t border-slate-200/60">
                                <span>{{ $rel->reading_time }} menit baca</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400 group-hover:translate-x-0.5 transition"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</article>

<!-- Floating Sticky Share Bar (Mobile & Desktop Capsule) -->
<div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-slate-900/90 backdrop-blur-md text-white px-4 py-2.5 rounded-full shadow-2xl border border-slate-700/60 flex items-center gap-3 animate-fade-in">
    <span class="text-xs font-bold text-slate-300 hidden sm:inline">Bagikan:</span>
    <a 
        href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . url()->current()) }}" 
        target="_blank"
        rel="noopener noreferrer"
        class="w-8 h-8 rounded-full bg-emerald-600 hover:bg-emerald-500 flex items-center justify-center text-white transition shadow-sm hover:scale-110"
        title="WhatsApp"
    >
        <i data-lucide="message-circle" class="w-4 h-4"></i>
    </a>
    <a 
        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
        target="_blank"
        rel="noopener noreferrer"
        class="w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-500 flex items-center justify-center text-white transition shadow-sm hover:scale-110"
        title="Facebook"
    >
        <i data-lucide="facebook" class="w-4 h-4"></i>
    </a>
    <button 
        type="button" 
        onclick="copyArticleLink()" 
        class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-slate-200 transition shadow-sm hover:scale-110"
        title="Salin Tautan"
    >
        <i data-lucide="copy" class="w-4 h-4"></i>
    </button>
    <div class="w-px h-5 bg-slate-700"></div>
    <button 
        type="button" 
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" 
        class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-slate-200 transition shadow-sm hover:scale-110"
        title="Kembali ke Atas"
    >
        <i data-lucide="arrow-up" class="w-4 h-4"></i>
    </button>
</div>

<!-- Inline Scripts for Article UX -->
<script>
    // 1. Reading Progress Bar
    window.addEventListener('scroll', function() {
        const article = document.querySelector('article');
        const progressBar = document.getElementById('readingProgressBar');
        if (!article || !progressBar) return;

        const totalHeight = article.clientHeight;
        const windowHeight = window.innerHeight;
        const scrollPosition = window.scrollY - article.offsetTop;

        let progress = 0;
        if (scrollPosition > 0) {
            progress = Math.min(100, Math.max(0, (scrollPosition / (totalHeight - windowHeight + 200)) * 100));
        }
        progressBar.style.width = progress + '%';
    });

    // 2. Copy Link with Tooltip
    function copyArticleLink() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const textEl = document.getElementById('copyLinkText');
                if (textEl) {
                    const original = textEl.textContent;
                    textEl.textContent = 'Tersalin! ✓';
                    setTimeout(() => textEl.textContent = original, 2000);
                }
                if (window.showToast) {
                    window.showToast('Tautan artikel berhasil disalin!');
                }
            });
        }
    }

    // 3. Font Size Adjuster
    function changeArticleFontSize(size) {
        const content = document.getElementById('articleContentBody');
        const buttons = document.querySelectorAll('.font-size-btn');
        if (!content) return;

        buttons.forEach(btn => {
            btn.classList.remove('active', 'bg-japan-600', 'text-white', 'shadow-sm');
            btn.classList.add('bg-white', 'text-slate-700');
        });

        const activeBtn = document.querySelector(`.font-size-btn[data-size="${size}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active', 'bg-japan-600', 'text-white', 'shadow-sm');
            activeBtn.classList.remove('bg-white', 'text-slate-700');
        }

        content.classList.remove('text-sm', 'text-base', 'text-lg', 'text-xl');
        if (size === 'sm') {
            content.classList.add('text-base');
            content.style.fontSize = '15px';
            content.style.lineHeight = '1.7';
        } else if (size === 'base') {
            content.classList.add('text-base', 'sm:text-lg');
            content.style.fontSize = '';
            content.style.lineHeight = '';
        } else if (size === 'lg') {
            content.classList.add('text-xl');
            content.style.fontSize = '21px';
            content.style.lineHeight = '1.8';
        }
    }
</script>
@endsection
