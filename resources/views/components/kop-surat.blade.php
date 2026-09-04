@php
    $siteSettings = \App\Models\SiteSetting::allCached();
    $companyName = $siteSettings['site_name'] ?? 'LPK SAHABAT JEPANG INDONESIA';
    $companyTagline = $siteSettings['site_tagline'] ?? '友好日本インドネシア • SENDING ORGANIZATION (SO)';
    $companyPhone = $siteSettings['contact_phone'] ?? '+62 812-3456-7890';
    $companyEmail = $siteSettings['contact_email'] ?? 'info@sahabatjepangindonesia.com';
    $companyAddress = $siteSettings['contact_address'] ?? 'Jl. Sakura Raya No. 88, Jakarta Selatan';
    $companyLogo = $siteSettings['site_logo'] ?? null;
    $docCode = $code ?? null;
    $docStatus = $status ?? null;
    $docDate = $date ?? date('d F Y');
@endphp

<div class="border-b-2 border-slate-900 pb-5 mb-5 flex items-start justify-between gap-6 relative">
    <!-- Brand Info (Left) -->
    <div class="flex items-start gap-4">
        @if(!empty($companyLogo))
            <div class="h-16 w-16 rounded-2xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-xs overflow-hidden flex-shrink-0">
                <img src="{{ $companyLogo }}" alt="{{ $companyName }}" class="max-h-full max-w-full object-contain">
            </div>
        @else
            <div class="w-16 h-16 rounded-2xl bg-red-600 text-white flex items-center justify-center font-black text-3xl font-japanese shadow-md flex-shrink-0">
                友
            </div>
        @endif
        
        <div class="space-y-0.5">
            <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-tight uppercase">
                {{ $companyName }}
            </h1>
            <p class="text-xs font-bold text-red-600 font-japanese">
                {{ $companyTagline }}
            </p>
            <p class="text-[10px] text-slate-500 leading-tight">
                Izin SO Kemnaker RI: <strong>KEP.224/LATTAS/XII/2023</strong> • Akreditasi Lembaga: <strong>LA-LPK A</strong><br>
                {{ $companyAddress }} • Telp: {{ $companyPhone }} • Email: {{ $companyEmail }}
            </p>
        </div>
    </div>

    <!-- Document Meta (Right) -->
    <div class="text-right flex-shrink-0">
        @if($docCode)
            <span class="inline-block px-3 py-1 rounded-lg bg-slate-900 text-white text-xs font-mono font-black tracking-wider shadow-2xs">
                {{ $docCode }}
            </span>
        @endif
        @if($docStatus)
            <p class="text-[10px] font-bold text-slate-500 mt-1 uppercase">
                Status: <span class="text-slate-800 font-black">{{ $docStatus }}</span>
            </p>
        @endif
        <p class="text-[10px] text-slate-400 mt-0.5">
            Tgl Cetak: {{ $docDate }}
        </p>
    </div>
</div>
