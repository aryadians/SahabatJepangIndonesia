<!-- Facilities & Training Center Gallery Section -->
<section id="fasilitas" class="py-20 lg:py-28 bg-white relative overflow-hidden">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3 reveal-on-scroll">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-japan-700 text-xs font-bold uppercase tracking-wider">
                <span class="font-japanese text-sm">施設案内</span>
                <span>• Fasilitas Pelatihan & Asrama</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                Fasilitas Terlengkap & Asrama Representatif <br class="hidden sm:inline">
                <span class="text-japan-600">Berstandar Industri Jepang</span>
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Kami menyediakan lingkungan belajar yang nyaman, disiplin, dan kondusif untuk mendukung percepatan penguasaan bahasa dan kesiapan mental para calon peserta.
            </p>
        </div>

        <!-- Facilities Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($facilities as $index => $facility)
                <div 
                    class="group rounded-3xl overflow-hidden bg-white border border-slate-200/80 shadow-md hover:shadow-2xl hover:border-red-300 transition-all duration-300 flex flex-col justify-between cursor-pointer reveal-on-scroll delay-{{ (($index % 3) + 1) * 100 }}"
                    onclick="previewFacility('{{ addslashes($facility['title']) }}', '{{ addslashes($facility['category']) }}', '{{ addslashes($facility['description']) }}', '{{ $facility['image'] }}')"
                >
                    <!-- Image Box with Zoom Effect & Overlay -->
                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                        <img 
                            src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 500'%3E%3Crect width='800' height='500' fill='%23f1f5f9'/%3E%3C/svg%3E" 
                            data-src="{{ $facility['image'] }}" 
                            alt="{{ $facility['title'] }}"
                            class="lazy-img w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            loading="lazy"
                        >
                        <!-- Category Badge in Image -->
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-japan-700 shadow-sm">
                                {{ $facility['category'] }}
                            </span>
                        </div>

                        <!-- Hover Icon Overlay -->
                        <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-white/90 backdrop-blur-md text-japan-600 flex items-center justify-center transform scale-75 group-hover:scale-100 transition-transform duration-300 shadow-xl">
                                <i data-lucide="zoom-in" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Facility Content -->
                    <div class="p-6 flex flex-col flex-1 justify-between">
                        <div>
                            <h3 class="font-extrabold text-lg text-slate-900 group-hover:text-japan-600 transition-colors">
                                {{ $facility['title'] }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                                {{ $facility['description'] }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-japan-600 group-hover:text-japan-700">
                            <span>Lihat Foto Detail</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>
