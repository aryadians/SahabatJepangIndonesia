@extends('layouts.app')

@section('title', $article->title . ' - LPK Sahabat Jepang Indonesia')

@section('content')
<!-- Article Detail Header -->
<article class="bg-white py-10 sm:py-16">
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
            <span class="inline-block px-3.5 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-bold">
                {{ $article->category }}
            </span>
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                {{ $article->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-2 border-y border-slate-100 py-3">
                <div class="flex items-center gap-2 font-semibold text-slate-700">
                    <i data-lucide="user" class="w-4 h-4 text-japan-600"></i>
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

        <!-- Featured Image -->
        @if($article->thumbnail)
            <div class="rounded-3xl overflow-hidden shadow-xl aspect-[16/9] bg-slate-100 border border-slate-200">
                <img src="{{ $article->thumbnail }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Article Content Body -->
        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4 text-base sm:text-lg border-b border-slate-100 pb-12">
            {!! $article->content !!}
        </div>

        <!-- Share & Call To Action Box -->
        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-red-50 via-white to-red-100 border border-red-200 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm">
            <div class="space-y-1 text-center sm:text-left">
                <h4 class="text-lg font-black text-slate-900">Tertarik Berkarir ke Jepang?</h4>
                <p class="text-xs sm:text-sm text-slate-600">Konsultasikan pilihan program kerja dan jadwal kelas bersama konselor kami secara gratis.</p>
            </div>
            <button 
                onclick="openModal('consultationModal')" 
                class="btn-red-primary px-6 py-3.5 rounded-2xl text-xs sm:text-sm font-bold shadow-lg flex-shrink-0 flex items-center gap-2"
            >
                <i data-lucide="sparkles" class="w-4 h-4 text-amber-200"></i>
                <span>Konsultasi Sekarang</span>
            </button>
        </div>

        <!-- Related Articles -->
        @if($relatedArticles->count() > 0)
            <div class="pt-8 space-y-6">
                <h3 class="font-extrabold text-slate-900 text-xl">Artikel Terkait Lainnya</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                        <a href="{{ route('articles.show', $rel->slug) }}" class="group bg-slate-50 rounded-2xl p-4 border border-slate-200 hover:border-japan-300 transition space-y-3">
                            <div class="h-32 rounded-xl overflow-hidden bg-slate-200">
                                <img src="{{ $rel->thumbnail }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <span class="text-[10px] font-bold text-japan-600 uppercase">{{ $rel->category }}</span>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-japan-700 transition line-clamp-2">
                                {{ $rel->title }}
                            </h4>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</article>
@endsection
