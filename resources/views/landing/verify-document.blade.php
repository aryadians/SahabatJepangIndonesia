@extends('layouts.app')

@section('title', 'Verifikasi Keaslian Dokumen Resmi & QR Code - LPK Sahabat Jepang Indonesia')
@section('meta_description', 'Sistem verifikasi publik keaslian kwitansi, invoice, dan dokumen resmi LPK Sahabat Jepang Indonesia berizin SO Kemnaker RI.')
@section('meta_keywords', 'verifikasi kwitansi lpk jepang, scan qr kwitansi sahabat jepang indonesia, cek keaslian dokumen resmi so kemnaker')

@section('content')
<div class="bg-slate-950 text-white min-h-screen py-10 sm:py-16 relative overflow-hidden">

    <!-- Ambient Japanese Red & Emerald Glow -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-red-600/15 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-96 h-96 rounded-full {{ $isValid ? 'bg-emerald-600/15' : 'bg-rose-600/15' }} blur-[120px] pointer-events-none"></div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-8">

        <!-- Header Title -->
        <div class="text-center space-y-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-slate-900 border border-slate-700 text-xs font-bold uppercase tracking-wider font-mono text-slate-300">
                <i data-lucide="qr-code" class="w-3.5 h-3.5 text-red-400"></i>
                <span>Sistem Verifikasi Digital Dokumen Resmi</span>
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                Verifikasi Keabsahan Dokumen
            </h1>

            <p class="text-xs sm:text-sm text-slate-400 max-w-lg mx-auto">
                Pindai QR code pada dokumen fisik untuk memvalidasi keaslian berkas yang diterbitkan oleh LPK Sahabat Jepang Indonesia.
            </p>
        </div>

        @if($isValid && $student)

            <!-- ========================================================
                 VALID & VERIFIED DOCUMENT CERTIFICATE
                 ======================================================== -->
            <div class="bg-white text-slate-900 rounded-3xl p-6 sm:p-10 shadow-2xl border border-slate-100 relative overflow-hidden space-y-8">
                
                <!-- Background Japanese Watermark -->
                <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
                    <span class="text-9xl font-black font-japanese">友好日本</span>
                </div>

                <!-- Verified Top Banner -->
                <div class="p-4 sm:p-5 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row items-center sm:items-start gap-4 text-center sm:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-emerald-600/30">
                        <i data-lucide="shield-check" class="w-7 h-7"></i>
                    </div>

                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <h3 class="text-sm sm:text-base font-black text-emerald-950 uppercase tracking-tight">
                                DOKUMEN RESMI TERVERIFIKASI
                            </h3>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-600 text-white font-mono">
                                VALID & SAH
                            </span>
                        </div>
                        <p class="text-xs text-emerald-800 leading-relaxed font-medium">
                            Dokumen ini tercatat sah di pangkalan data terpusat LPK Sahabat Jepang Indonesia (SO Kemnaker RI Izin: KEP.224/LATTAS/XII/2023).
                        </p>
                    </div>
                </div>

                <!-- Document Details Grid -->
                <div class="space-y-4">
                    <div class="border-b border-slate-200 pb-2 flex items-center justify-between">
                        <span class="text-xs font-black uppercase text-slate-400 tracking-wider">Rincian Dokumen Resmi</span>
                        <span class="text-[11px] font-mono text-slate-400">Timestamp: {{ now()->format('d M Y, H:i') }} WIB</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jenis Dokumen</span>
                            <p class="text-sm font-black text-slate-900">{{ $docType }}</p>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Dokumen</span>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-mono font-black text-japan-700">{{ $docNo }}</p>
                                <button type="button" onclick="copyToClipboard('{{ $docNo }}', 'Nomor dokumen tersalin!')" class="p-1 rounded-md text-slate-400 hover:text-japan-600 hover:bg-slate-200/50 transition" title="Salin Nomor Dokumen">
                                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Siswa / Pemilik</span>
                            <p class="text-sm font-black text-slate-900">{{ $student->name }}</p>
                            @if($student->japanese_name)
                                <p class="text-xs font-japanese font-bold text-slate-500">{{ $student->japanese_name }}</p>
                            @endif
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Induk Siswa (NIS)</span>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-mono font-black text-slate-900">{{ $student->nis }}</p>
                                <button type="button" onclick="copyToClipboard('{{ $student->nis }}', 'NIS tersalin!')" class="p-1 rounded-md text-slate-400 hover:text-japan-600 hover:bg-slate-200/50 transition" title="Salin NIS">
                                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Program & Angkatan</span>
                            <p class="text-xs font-bold text-slate-900">{{ $student->program }}</p>
                            <p class="text-[11px] text-slate-500">Angkatan: {{ $student->batch ?: 'Aktif' }} • {{ $student->registration_category_badge['label'] ?? 'Jalur Reguler' }}</p>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Status & Realisasi Pembayaran</span>
                            <p class="text-xs font-bold text-emerald-700">Telah Dibayar: Rp {{ number_format($student->paid_amount, 0, ',', '.') }}</p>
                            <p class="text-[11px] text-slate-500">Status: <span class="uppercase font-bold text-slate-700">{{ $student->payment_status }}</span> (Sisa: Rp {{ number_format($student->remaining_balance, 0, ',', '.') }})</p>
                        </div>
                    </div>
                </div>

                <!-- Digital Seal & Official Notice -->
                <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-[11px] text-slate-500 leading-relaxed max-w-md text-center sm:text-left">
                        <strong>Perhatian Anti-Pemalsuan:</strong> Pastikan seluruh data di atas (Nomor dokumen, nama siswa, dan nominal pembayaran) sama persis dengan yang tercetak pada lembaran fisik Anda.
                    </div>

                    <!-- Red Hanko Seal Graphic -->
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <div class="hanko-stamp w-28 h-14 rounded-full flex flex-col items-center justify-center select-none py-1">
                            <span class="tracking-widest uppercase text-[7px] font-black">LPK SAHABAT JEPANG</span>
                            <span class="text-[10px] font-black tracking-wider">VERIFIED SEAL</span>
                            <span class="text-[6px] tracking-tight font-japanese">送出機関 友好日本</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black uppercase text-red-700 block">Stempel Digital Resmi</span>
                            <span class="text-xs font-black text-slate-900">LPK SJI Jakarta</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a 
                        href="{{ route('student.public.receipt', $student->nis) }}" 
                        target="_blank" 
                        class="btn-red-primary w-full sm:w-auto px-5 py-2.5 rounded-xl text-xs font-black flex items-center justify-center gap-2 shadow-md shadow-red-600/20"
                    >
                        <i data-lucide="receipt" class="w-4 h-4"></i>
                        <span>Lihat Lembar Kwitansi Asli</span>
                    </a>

                    <a 
                        href="{{ route('student.portal', ['keyword' => $student->nis]) }}" 
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition flex items-center justify-center gap-2"
                    >
                        <i data-lucide="user-check" class="w-4 h-4 text-slate-600"></i>
                        <span>Buka Portal Siswa</span>
                    </a>
                </div>

            </div>

        @else

            <!-- ========================================================
                 INVALID / NOT FOUND VERIFICATION VIEW
                 ======================================================== -->
            <div class="bg-slate-900 rounded-3xl p-8 sm:p-10 border border-slate-800 shadow-2xl space-y-6 text-center">
                
                <div class="w-16 h-16 rounded-3xl bg-rose-500/20 border border-rose-500/30 text-rose-400 flex items-center justify-center mx-auto shadow-lg shadow-rose-950/40">
                    <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                </div>

                <div class="space-y-2 max-w-md mx-auto">
                    <h3 class="text-lg sm:text-xl font-black text-white">
                        Dokumen Tidak Terverifikasi
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                        @if(!empty($queryCode))
                            Kode dokumen <span class="font-mono font-bold text-white">"{{ $queryCode }}"</span> tidak ditemukan di pangkalan data resmi LPK Sahabat Jepang Indonesia.
                        @else
                            Silakan masukkan nomor dokumen atau pindai QR code yang tertera pada lembaran fisik kwitansi/invoice Anda.
                        @endif
                    </p>
                </div>

                <!-- Manual Verification Search Form -->
                <form action="{{ route('document.verify') }}" method="GET" class="max-w-md mx-auto space-y-3 pt-2">
                    <div class="relative">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="text" 
                            name="code" 
                            value="{{ $queryCode }}" 
                            placeholder="Masukkan No. Kwitansi (KW-SJI/...) atau NIS" 
                            required 
                            class="w-full pl-11 pr-4 py-3 rounded-2xl bg-slate-800/90 border border-slate-700 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-japan-500"
                        >
                    </div>

                    <button 
                        type="submit" 
                        class="btn-red-primary w-full py-3 rounded-2xl text-xs font-black flex items-center justify-center gap-2 shadow-md shadow-red-600/30"
                    >
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        <span>Verifikasi Dokumen Sekarang</span>
                    </button>
                </form>

                <div class="pt-4 border-t border-slate-800 text-xs text-slate-400 flex items-center justify-center gap-4">
                    <a href="{{ route('student.portal') }}" class="hover:text-white transition">
                        Portal Cek Status Siswa
                    </a>
                    <span>•</span>
                    <a href="https://api.whatsapp.com/send?phone=6281234567890&text=Halo%20Admin%20LPK%20SJI,%20saya%20ingin%20mengonfirmasi%20keaslian%20dokumen%20kwitansi%20saya" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-bold inline-flex items-center gap-1">
                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                        <span>Konfirmasi via WhatsApp Admin</span>
                    </a>
                </div>

            </div>

        @endif

    </div>

</div>
@endsection
