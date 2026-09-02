<!-- News & Articles Preview Section -->
<section id="artikel" class="py-20 bg-slate-50 relative overflow-hidden border-b border-red-50">
    <!-- Background Decor -->
    <div class="absolute top-1/2 -right-40 -translate-y-1/2 w-96 h-96 rounded-full bg-red-100/50 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-red-200 text-xs font-extrabold text-japan-700 shadow-sm reveal-on-scroll">
                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                    <span>Edukasi & Informasi Karir</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight reveal-on-scroll delay-100">
                    Wawasan & Tips <span class="text-japan-600">Kerja di Jepang</span>
                </h2>
                <p class="text-sm sm:text-base text-slate-600 max-w-2xl reveal-on-scroll delay-200">
                    Pelajari panduan resmi, tips persiapan wawancara, simulasi finansial, dan informasi kehidupan terkini di Jepang.
                </p>
            </div>

            <div class="reveal-on-scroll delay-200 flex-shrink-0">
                <a 
                    href="{{ route('articles.index') }}" 
                    class="btn-white-outline px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-2 group"
                >
                    <span>Lihat Semua Artikel</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            @php
                $previewArticles = \App\Models\Article::where('is_published', true)->latest()->take(3)->get();
            @endphp

            @forelse($previewArticles as $art)
                <article class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300 flex flex-col overflow-hidden group reveal-on-scroll">
                    
                    <!-- Thumbnail Image -->
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

                    <!-- Article Body -->
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
                                Oleh {{ $art->author }}
                            </span>
                            <a 
                                href="{{ route('articles.show', $art->slug) }}" 
                                class="text-xs font-bold text-japan-600 hover:text-japan-700 inline-flex items-center gap-1 group-hover:underline"
                            >
                                <span>Baca</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>

                </article>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                    Belum ada artikel yang dipublikasikan.
                </div>
            @endforelse
        </div>

    </div>
</section>
