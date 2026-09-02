@extends('layouts.app')

@section('title', 'Artikel & Wawasan Karir Jepang - LPK Sahabat Jepang Indonesia')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-b from-red-50/60 to-white py-14 sm:py-20 border-b border-red-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-red-200 text-xs font-bold text-japan-700 shadow-sm">
            <i data-lucide="book-open" class="w-4 h-4"></i>
            <span>Pusat Informasi & Edukasi Karir</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">
            Artikel & Panduan <span class="text-japan-600">Kerja di Jepang</span>
        </h1>
        <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto">
            Informasi lengkap seputar program Tokutei Ginou (SSW), Magang Kerja, tips wawancara, simulasi gaji, dan kehidupan di Jepang.
        </p>

        <!-- Search & Filter Bar -->
        <div class="max-w-xl mx-auto pt-4">
            <form action="{{ route('articles.index') }}" method="GET" class="flex items-center gap-2">
                <div class="relative flex-1">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Cari artikel, topik, atau kata kunci..."
                        class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 shadow-sm text-sm focus:outline-none focus:border-japan-600 focus:ring-2 focus:ring-red-500/20"
                    >
                </div>
                <button type="submit" class="btn-red-primary px-6 py-3 rounded-2xl text-xs font-bold shadow-md">
                    Cari
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Main Articles Container -->
<section class="py-12 sm:py-16 bg-white min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Category Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2">
            <a 
                href="{{ route('articles.index') }}" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ !request('category') || request('category') === 'all' ? 'bg-japan-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
            >
                Semua Topik
            </a>
            @foreach($categories as $cat)
                <a 
                    href="{{ route('articles.index', ['category' => $cat]) }}" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ request('category') === $cat ? 'bg-japan-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($articles as $art)
                <article class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 flex flex-col overflow-hidden group">
                    
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img 
                            src="{{ $art->thumbnail }}" 
                            alt="{{ $art->title }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                        >
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white font-bold text-[11px]">
                            {{ $art->category }}
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-3 text-[11px] text-slate-400 font-medium">
                                <span>{{ $art->created_at->format('d M Y') }}</span>
                                <span>•</span>
                                <span>{{ $art->reading_time }} mnt baca</span>
                            </div>

                            <h3 class="font-extrabold text-slate-900 text-base group-hover:text-japan-700 transition leading-snug">
                                <a href="{{ route('articles.show', $art->slug) }}">
                                    {{ $art->title }}
                                </a>
                            </h3>

                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $art->excerpt }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-400">
                                {{ $art->author }}
                            </span>
                            <a 
                                href="{{ route('articles.show', $art->slug) }}" 
                                class="text-xs font-bold text-japan-600 hover:text-japan-700 inline-flex items-center gap-1 group-hover:underline"
                            >
                                <span>Baca Selengkapnya</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>

                </article>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400 space-y-3">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                        <i data-lucide="inbox" class="w-6 h-6"></i>
                    </div>
                    <p class="font-bold text-slate-700">Tidak ada artikel ditemukan</p>
                    <a href="{{ route('articles.index') }}" class="text-xs font-bold text-japan-600 underline">
                        Lihat semua artikel
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="pt-8">
                {{ $articles->links() }}
            </div>
        @endif

    </div>
</section>
@endsection
