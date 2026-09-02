<!-- Trusted Kaisha & Kumiai Partners Marquee Banner -->
<section class="py-10 bg-white border-b border-red-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 text-center">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center justify-center gap-2">
            <span class="w-8 h-px bg-slate-200"></span>
            <span>Dipercaya oleh 50+ Organisasi Pengawas (Kumiai) & Perusahaan Penerima (Kaisha) di Jepang</span>
            <span class="w-8 h-px bg-slate-200"></span>
        </p>
    </div>

    <!-- Infinite Scrolling Logo Marquee -->
    <div class="relative w-full overflow-hidden mask-fade-edges">
        <div class="flex items-center gap-6 sm:gap-10 animate-marquee whitespace-nowrap">
            
            @if(isset($partners) && count($partners) > 0)
                @foreach($partners as $partner)
                    <div class="inline-flex items-center gap-2.5 px-5 py-2.5 rounded-2xl bg-slate-50 border border-slate-100/80 text-slate-700 font-bold text-xs sm:text-sm hover:border-red-200 transition">
                        <span class="w-2.5 h-2.5 rounded-full bg-japan-600"></span>
                        <span>{{ $partner->name }} {{ $partner->prefecture ? "({$partner->prefecture})" : '' }}</span>
                    </div>
                @endforeach
                <!-- Duplicate for continuous infinite seamless scroll -->
                @foreach($partners as $partner)
                    <div class="inline-flex items-center gap-2.5 px-5 py-2.5 rounded-2xl bg-slate-50 border border-slate-100/80 text-slate-700 font-bold text-xs sm:text-sm hover:border-red-200 transition">
                        <span class="w-2.5 h-2.5 rounded-full bg-japan-600"></span>
                        <span>{{ $partner->name }} {{ $partner->prefecture ? "({$partner->prefecture})" : '' }}</span>
                    </div>
                @endforeach
            @else
                <div class="inline-flex items-center gap-2.5 px-5 py-2.5 rounded-2xl bg-slate-50 border border-slate-100/80 text-slate-700 font-bold text-xs sm:text-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-japan-600"></span>
                    <span>Tokyo Foods Industry Co., Ltd. (東京都)</span>
                </div>
                <div class="inline-flex items-center gap-2.5 px-5 py-2.5 rounded-2xl bg-slate-50 border border-slate-100/80 text-slate-700 font-bold text-xs sm:text-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-japan-600"></span>
                    <span>Kansai Social Welfare Caregiver (大阪府)</span>
                </div>
            @endif

        </div>
    </div>
</section>
