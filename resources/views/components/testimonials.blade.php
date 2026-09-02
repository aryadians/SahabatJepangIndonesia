<!-- Testimonials & Alumni Success Stories Section -->
<section id="testimoni" class="py-20 lg:py-28 bg-[#FFF8F8] relative overflow-hidden border-t border-red-100">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3 reveal-on-scroll">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-bold uppercase tracking-wider">
                <span class="font-japanese text-sm">卒業生の声</span>
                <span>• Kisah Sukses Alumni SJI</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                Cerita Nyata dari Alumni yang Telah <br class="hidden sm:inline">
                <span class="text-japan-600">Bekerja & Berpenghasilan di Jepang</span>
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Ribuan alumni telah membuktikan kemudahan, transparansi, dan keamanan proses bersama LPK Sahabat Jepang Indonesia.
            </p>
        </div>

        <!-- Testimonial Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($testimonials as $index => $testi)
                <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col justify-between border border-red-100/80 shadow-md hover:shadow-xl transition-all duration-300 reveal-on-scroll delay-{{ ($index + 1) * 100 }} relative group">
                    
                    <div>
                        <!-- Quote Icon & Japanese Prefecture Tag -->
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-red-100 text-japan-600 flex items-center justify-center font-bold">
                                <i data-lucide="quote" class="w-5 h-5"></i>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-white text-japan-700 border border-red-200 shadow-sm font-japanese">
                                📍 {{ $testi['prefecture'] }}
                            </span>
                        </div>

                        <!-- Quote Text -->
                        <p class="text-slate-700 text-sm sm:text-base leading-relaxed italic mb-6">
                            "{{ $testi['quote'] }}"
                        </p>
                    </div>

                    <!-- Author Info & Salary Card -->
                    <div class="pt-6 border-t border-slate-100 space-y-4">
                        
                        <div class="flex items-center gap-4">
                            <img 
                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%23fee2e2'/%3E%3C/svg%3E"
                                data-src="{{ $testi['avatar'] }}" 
                                alt="{{ $testi['name'] }}"
                                class="lazy-img w-14 h-14 rounded-2xl object-cover border-2 border-japan-600 shadow-sm"
                                loading="lazy"
                            >
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-base flex items-center gap-2">
                                    {{ $testi['name'] }}
                                    <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-100 text-emerald-700 font-bold">Terverifikasi</span>
                                </h4>
                                <p class="text-xs text-slate-500 font-medium">Asal: {{ $testi['origin'] }} • {{ $testi['tag'] }}</p>
                                <p class="text-xs font-semibold text-japan-700 mt-0.5">{{ $testi['program'] }}</p>
                            </div>
                        </div>

                        <div class="p-3 rounded-2xl bg-red-50/70 border border-red-100 flex items-center justify-between text-xs">
                            <span class="text-slate-600 font-medium">Penempatan: <strong>{{ $testi['company'] }}</strong></span>
                            <span class="font-extrabold text-japan-700">{{ $testi['salary'] }}</span>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>
