@extends('layouts.app')

@section('title', 'Portal Cek Status Mandiri Siswa & Tracking Berkas - LPK Sahabat Jepang Indonesia')
@section('meta_description', 'Portal mandiri siswa dan orang tua untuk memantau progres berkas, hasil MCU, jadwal wawancara Kaisha, status CoE & visa, serta unduh kwitansi pembayaran resmi.')
@section('meta_keywords', 'cek status siswa lpk jepang, tracking berkas visa jepang, unduh kwitansi lpk sahabat jepang, portal siswa sji')

@section('content')
@php
    $cleanWa = preg_replace('/[^0-9]/', '', $settings['contact_whatsapp'] ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) $cleanWa = '62' . substr($cleanWa, 1);
@endphp
<div class="bg-slate-950 text-white min-h-screen py-10 sm:py-16 relative overflow-hidden">

    <!-- Ambient Japanese Red Glow Background -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-red-600/15 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-96 h-96 rounded-full bg-rose-600/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-10">

        <!-- Header Section -->
        <div class="text-center space-y-3 max-w-2xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold uppercase tracking-wider font-mono">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                <span>Portal Siswa & Tracking Mandiri</span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Cek Progres & Status Berkas Siswa
            </h1>

            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Pantau tahapan seleksi, pelatihan bahasa, hasil MCU, jadwal wawancara Kaisha, penerbitan CoE/Visa, serta unduh kwitansi resmi secara mandiri.
            </p>
        </div>

        <!-- Search Card -->
        <div class="bg-slate-900/90 rounded-3xl p-6 sm:p-8 border border-slate-800 shadow-2xl space-y-4">
            <form action="{{ route('student.portal') }}" method="GET" class="space-y-3">
                <label class="block text-xs font-bold text-slate-300">
                    Masukkan NIS (Nomor Induk Siswa), NIK KTP, atau Nomor WhatsApp Terdaftar:
                </label>
                
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative flex-1 w-full">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="text" 
                            id="studentSearchInput"
                            name="keyword" 
                            value="{{ $keyword }}" 
                            placeholder="Contoh: SJI-2026-001 atau 081234567890" 
                            required 
                            class="w-full pl-11 pr-4 py-3 rounded-2xl bg-slate-800/80 border border-slate-700 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-japan-500 focus:ring-1 focus:ring-japan-500 transition font-mono"
                        >
                    </div>

                    <button 
                        type="button" 
                        onclick="openQrScanModal()" 
                        class="w-full sm:w-auto px-4 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-xs font-bold flex items-center justify-center gap-2 transition whitespace-nowrap active:scale-[0.97]"
                        title="Pindai QR Code Dokumen atau Kartu Siswa"
                    >
                        <i data-lucide="qr-code" class="w-4 h-4 text-japan-500"></i>
                        <span>Pindai QR Dokumen</span>
                    </button>

                    <button 
                        type="submit" 
                        class="btn-red-primary w-full sm:w-auto px-6 py-3 rounded-2xl text-xs font-extrabold flex items-center justify-center gap-2 shadow-lg shadow-red-600/30 whitespace-nowrap active:scale-[0.97]"
                    >
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span>Cek Status Sekarang</span>
                    </button>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-2 pt-1 text-[11px] text-slate-400">
                    <span>💡 Tips: NIS tertera pada kartu siswa atau tanda terima awal.</span>
                    <a href="https://api.whatsapp.com/send?phone={{ $cleanWa }}&text=Halo%20Admin%20LPK%20SJI,%20saya%20lupa%20NIS%20saya,%20mohon%20bantuannya" target="_blank" class="text-red-400 hover:text-red-300 font-bold inline-flex items-center gap-1">
                        <span>Lupa NIS? Hubungi Admin</span>
                        <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
                    </a>
                </div>
            </form>
        </div>

        @if($searched && $student)
            
            <!-- ========================================================
                 STUDENT DETAILS & PROGRESS TRACKER
                 ======================================================== -->
            <div class="space-y-8 animate-fade-in">
                
                <!-- Student Profile Card -->
                <div class="bg-white text-slate-900 rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div class="flex items-start sm:items-center gap-4 sm:gap-5">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-japan-50 border border-red-200 text-japan-600 flex items-center justify-center font-black text-2xl overflow-hidden flex-shrink-0 shadow-xs">
                            @if($student->photo)
                                <img src="{{ $student->photo }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                            @else
                                <span>友</span>
                            @endif
                        </div>

                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                    {{ $student->name }}
                                </h3>
                                @if($student->japanese_name)
                                    <span class="text-xs font-japanese font-bold text-japan-600 px-2 py-0.5 rounded-md bg-red-50 border border-red-200">
                                        {{ $student->japanese_name }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-500 font-mono font-bold flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 bg-slate-100 px-2.5 py-1 rounded-lg">
                                    <span>NIS: {{ $student->nis }}</span>
                                    <button type="button" onclick="copyToClipboard('{{ $student->nis }}', 'NIS Siswa tersalin!')" class="text-slate-400 hover:text-japan-600 transition" title="Salin NIS">
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    </button>
                                </span>
                                <span class="text-slate-300">•</span>
                                <span>Angkatan: {{ $student->batch ?: 'Aktif' }}</span>
                            </p>

                            <div class="flex flex-wrap items-center gap-2 pt-1">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $student->status_badge['class'] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $student->status_label ?? strtoupper($student->status) }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $student->registration_category_badge['badge_class'] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $student->registration_category_badge['label'] ?? 'Jalur Reguler' }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-800">
                                    {{ $student->program }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Direct Official Print Actions -->
                    <div class="flex flex-wrap items-center gap-2.5 self-stretch md:self-auto justify-end border-t md:border-t-0 pt-4 md:pt-0 border-slate-100">
                        <a 
                            href="{{ route('public.flight.tracking', $student->nis) }}" 
                            target="_blank" 
                            class="flex-1 sm:flex-initial px-4 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-800 border border-red-200 text-xs font-black transition flex items-center justify-center gap-1.5 shadow-2xs"
                            title="Buka Kartu Tanda Siswa Digital 3D & Status Kesiapan Dokumen Terbang"
                        >
                            <i data-lucide="badge-check" class="w-4 h-4 text-red-600"></i>
                            <span>Kartu Siswa 3D & Kesiapan</span>
                        </a>

                        <a 
                            href="{{ route('student.public.receipt', $student->nis) }}" 
                            target="_blank" 
                            class="flex-1 sm:flex-initial px-4 py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-black transition flex items-center justify-center gap-1.5 shadow-2xs"
                            title="Buka dan Cetak Kwitansi Resmi dengan Stempel Hanko"
                        >
                            <i data-lucide="receipt" class="w-4 h-4 text-emerald-600"></i>
                            <span>Unduh Kwitansi</span>
                        </a>

                        <a 
                            href="{{ route('student.public.invoice', $student->nis) }}" 
                            target="_blank" 
                            class="flex-1 sm:flex-initial px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200 text-xs font-black transition flex items-center justify-center gap-1.5 shadow-2xs"
                            title="Buka Faktur Tagihan Pelatihan"
                        >
                            <i data-lucide="file-text" class="w-4 h-4 text-slate-600"></i>
                            <span>Unduh Invoice</span>
                        </a>
                    </div>
                </div>

                <!-- Step-by-Step Road to Japan Progress Tracker -->
                <div class="bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-800 shadow-xl space-y-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-slate-800 pb-4">
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-red-400 block">Road to Japan Timeline</span>
                            <h4 class="text-base sm:text-lg font-black text-white mt-0.5">
                                Tahapan Proses Pemberangkatan Siswa
                            </h4>
                        </div>

                        @php
                            $doneSteps = count(array_filter($progressSteps, fn($s) => $s['is_done']));
                            $totalSteps = count($progressSteps);
                            $timelinePct = round(($doneSteps / $totalSteps) * 100);
                        @endphp
                        <div class="sm:text-right">
                            <span class="text-xs font-bold text-emerald-400 bg-emerald-950/60 border border-emerald-500/30 px-3 py-1 rounded-full font-mono">
                                {{ $doneSteps }} / {{ $totalSteps }} Tahap Selesai ({{ $timelinePct }}%)
                            </span>
                        </div>
                    </div>

                    <!-- Cumulative Progress Gauge Bar -->
                    <div class="space-y-1.5">
                        <div class="w-full h-2.5 bg-slate-800 rounded-full overflow-hidden shadow-inner">
                            <div style="width: {{ max(6, $timelinePct) }}%" class="h-full bg-gradient-to-r from-red-600 via-amber-500 to-emerald-500 rounded-full transition-all duration-700 shadow-xs"></div>
                        </div>
                        <div class="flex justify-between text-[10px] text-slate-500 font-mono">
                            <span>Tahap 01: Pendaftaran</span>
                            <span>Tahap 03: MCU & Interview</span>
                            <span>Tahap 06: Terbang ke Jepang ✈️</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($progressSteps as $step)
                            <div class="p-4 rounded-2xl border {{ $step['is_current'] ? 'border-red-500 bg-red-950/30 ring-1 ring-red-500/50' : ($step['is_done'] ? 'border-emerald-500/40 bg-emerald-950/20' : 'border-slate-800 bg-slate-950/40 opacity-70') }} space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-mono font-black uppercase px-2 py-0.5 rounded-md {{ $step['is_current'] ? 'bg-red-500 text-white animate-pulse' : ($step['is_done'] ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-800 text-slate-400') }}">
                                        Tahap 0{{ $step['step'] }}
                                    </span>
                                    
                                    @if($step['is_done'])
                                        <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                    @elseif($step['is_current'])
                                        <span class="w-6 h-6 rounded-full bg-red-500/20 text-red-400 flex items-center justify-center animate-spin">
                                            <i data-lucide="loader-2" class="w-3.5 h-3.5"></i>
                                        </span>
                                    @else
                                        <span class="w-6 h-6 rounded-full bg-slate-800 text-slate-600 flex items-center justify-center">
                                            <i data-lucide="circle" class="w-3.5 h-3.5"></i>
                                        </span>
                                    @endif
                                </div>

                                <h5 class="text-xs sm:text-sm font-extrabold text-white">
                                    {{ $step['title'] }}
                                </h5>

                                <p class="text-[11px] text-slate-400 leading-tight">
                                    {{ $step['desc'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Financial & Key Data Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Financial Transparency Summary -->
                    <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 shadow-xl space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                            <h4 class="text-sm font-extrabold text-white flex items-center gap-2">
                                <i data-lucide="credit-card" class="w-4 h-4 text-japan-500"></i>
                                <span>Status Pembiayaan Siswa</span>
                            </h4>
                            <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $student->payment_badge['class'] ?? 'bg-slate-800 text-slate-300' }}">
                                {{ $student->payment_status }}
                            </span>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Total Biaya Program</span>
                                <span class="font-mono font-bold text-white">Rp {{ number_format($student->total_cost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Jumlah Telah Dibayar</span>
                                <span class="font-mono font-bold text-emerald-400">Rp {{ number_format($student->paid_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-slate-800 font-bold">
                                <span class="text-slate-300">Sisa Tanggungan</span>
                                <span class="font-mono text-sm {{ $student->remaining_balance > 0 ? 'text-amber-400' : 'text-emerald-400' }}">
                                    Rp {{ number_format($student->remaining_balance, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-slate-400 pt-1">
                                <span>Skema Pembiayaan</span>
                                <span class="capitalize text-slate-200 font-semibold">{{ str_replace('_', ' ', $student->payment_scheme) }}</span>
                            </div>
                        </div>

                        @if($student->remaining_balance == 0)
                            <div class="p-3 rounded-2xl bg-emerald-950/40 border border-emerald-500/30 text-[11px] text-emerald-300 flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                                <span>Pembayaran administrasi telah lunas penuh. Seluruh hak fasilitas pelatihan aktif.</span>
                            </div>
                        @else
                            <div class="p-3 rounded-2xl bg-amber-950/30 border border-amber-500/30 text-[11px] text-amber-200 flex items-center gap-2">
                                <i data-lucide="info" class="w-4 h-4 text-amber-400 flex-shrink-0"></i>
                                <span>Sisa pembayaran dapat dicicil atau dikonversi ke skema dana talangan perbankan mitra.</span>
                            </div>
                        @endif
                    </div>

                    <!-- Job Placement & Placement Info -->
                    <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 shadow-xl space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                            <h4 class="text-sm font-extrabold text-white flex items-center gap-2">
                                <i data-lucide="building" class="w-4 h-4 text-japan-500"></i>
                                <span>Perusahaan Penerima & Dokumen</span>
                            </h4>
                            <span class="text-xs text-slate-400 font-mono">SO Kemnaker RI</span>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Perusahaan Jepang (Kaisha)</span>
                                <span class="font-bold text-white text-right truncate max-w-[200px]">
                                    {{ $student->destination_company ?: 'Dalam Proses Matching' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Prefektur Penempatan</span>
                                <span class="font-bold text-white">{{ $student->destination_prefecture ?: '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Sektor Pekerjaan</span>
                                <span class="font-bold text-white">{{ $student->sector ?: $student->program }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Nomor Paspor RI</span>
                                <span class="font-mono font-bold text-slate-200">{{ $student->passport_number ?: 'Proses Imigrasi' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Nomor CoE Jepang</span>
                                <span class="font-mono font-bold text-slate-200">{{ $student->coe_number ?: 'Menunggu Rilis Imigrasi' }}</span>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a 
                                href="https://api.whatsapp.com/send?phone={{ $cleanWa }}&text={{ urlencode('Halo Sensei/Admin LPK SJI, saya ' . $student->name . ' (NIS: ' . $student->nis . ') ingin menanyakan update berkas keberangkatan saya.') }}" 
                                target="_blank"
                                class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs transition flex items-center justify-center gap-2 shadow-md shadow-emerald-900/30"
                            >
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                <span>Konsultasi Progres via WhatsApp Sensei</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        @elseif($searched && !$student)
            
            <!-- Not Found Alert -->
            <div class="bg-slate-900 rounded-3xl p-8 sm:p-12 border border-red-500/30 text-center space-y-4 shadow-2xl">
                <div class="w-14 h-14 rounded-2xl bg-red-500/20 text-red-400 flex items-center justify-center mx-auto border border-red-500/30">
                    <i data-lucide="user-x" class="w-7 h-7"></i>
                </div>
                
                <h3 class="text-lg sm:text-xl font-black text-white">Data Siswa Tidak Ditemukan</h3>
                
                <p class="text-xs sm:text-sm text-slate-400 max-w-md mx-auto leading-relaxed">
                    Tidak ditemukan data siswa dengan kata kunci <span class="font-bold text-white font-mono">"{{ $keyword }}"</span>. Pastikan Anda memasukkan NIS, NIK, atau nomor WhatsApp yang sama persis saat mendaftar.
                </p>

                <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('student.portal') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold transition">
                        Cari Ulang
                    </a>
                    <a href="https://api.whatsapp.com/send?phone={{ $cleanWa }}&text={{ urlencode('Halo Admin LPK SJI, saya mencari data siswa dengan kata kunci ' . $keyword . ' tetapi tidak ditemukan. Mohon dibantu.') }}" target="_blank" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition flex items-center gap-1.5">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Bantuan Admin via WhatsApp</span>
                    </a>
                </div>
            </div>

        @else

            <!-- Guidance Info Cards (When not searched yet) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4">
                <div class="bg-slate-900/60 rounded-3xl p-6 border border-slate-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-red-500/10 text-red-400 flex items-center justify-center font-bold border border-red-500/20">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <h4 class="text-sm font-bold text-white">Tracking Real-Time</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Data status pelatihan bahasa, medical check-up, dan penerbitan visa diperbarui secara langsung oleh tim penempatan.
                    </p>
                </div>

                <div class="bg-slate-900/60 rounded-3xl p-6 border border-slate-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold border border-emerald-500/20">
                        <i data-lucide="file-check" class="w-5 h-5"></i>
                    </div>
                    <h4 class="text-sm font-bold text-white">Unduh Kwitansi Asli</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Siswa dan wali murid dapat mengunduh bukti pembayaran resmi lengkap dengan stempel cap merah Jepang (*Hanko 判子*).
                    </p>
                </div>

                <div class="bg-slate-900/60 rounded-3xl p-6 border border-slate-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center font-bold border border-blue-500/20">
                        <i data-lucide="shield-alert" class="w-5 h-5"></i>
                    </div>
                    <h4 class="text-sm font-bold text-white">Transparansi Biaya</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Rincian sisa tagihan tercatat jelas tanpa ada biaya tersembunyi (*Zero Hidden Fees*) sesuai regulasi Kemenaker RI.
                    </p>
                </div>
            </div>

        @endif

    </div>

</div>

<!-- QR Code Scanner Modal -->
<div id="qrScanModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md transition-opacity">
    <div class="bg-slate-900 border border-slate-700 text-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 relative overflow-hidden animate-fadeIn">
        <button 
            type="button" 
            onclick="closeQrScanModal()" 
            class="absolute top-4 right-4 text-slate-400 hover:text-white p-2 rounded-xl bg-slate-800 hover:bg-slate-700 transition"
        >
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <div class="space-y-1 text-center">
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase text-white bg-japan-600 inline-block font-mono shadow-xs">
                QR Scanner & Verification
            </span>
            <h3 class="text-xl font-black text-white">Pindai QR Code Dokumen</h3>
            <p class="text-xs text-slate-400">Arahkan kamera ke QR Code pada Kwitansi atau Invoice resmi LPK SJI</p>
        </div>

        <!-- Viewfinder Box with Laser Animation -->
        <div class="relative w-64 h-64 mx-auto bg-slate-950 rounded-2xl border-2 border-dashed border-red-500/60 overflow-hidden flex items-center justify-center shadow-inner">
            <video id="qrVideoElement" class="w-full h-full object-cover hidden" playsinline muted></video>
            <div id="qrPlaceholderIcon" class="flex flex-col items-center justify-center space-y-2 text-slate-500 text-center px-4">
                <i data-lucide="camera" class="w-12 h-12 text-japan-500/70 animate-pulse"></i>
                <span class="text-xs font-mono" id="qrCameraStatusText">Kamera Siap Diaktifkan</span>
            </div>
            <!-- Red Laser Line Scan Effect -->
            <div id="qrLaserScanLine" class="hidden absolute inset-x-0 top-0 h-0.5 bg-red-500 shadow-md shadow-red-500 pointer-events-none" style="animation: scanLaser 2s infinite linear;"></div>
        </div>

        <!-- Camera Control & Upload Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-2">
            <button 
                type="button" 
                id="btnToggleCamera" 
                onclick="toggleCameraStream()" 
                class="px-4 py-2.5 rounded-xl bg-japan-600 hover:bg-japan-700 text-white font-bold text-xs flex items-center gap-1.5 shadow-md shadow-red-600/30 transition active:scale-[0.97]"
            >
                <i data-lucide="video" class="w-4 h-4"></i>
                <span id="cameraBtnLabel">Aktifkan Kamera</span>
            </button>

            <!-- Hidden File Input for QR Image Upload -->
            <input type="file" id="qrFileInput" accept="image/*" class="hidden" onchange="handleQrFileUpload(event)">
            <button 
                type="button" 
                onclick="document.getElementById('qrFileInput').click()" 
                class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-xs flex items-center gap-1.5 transition active:scale-[0.97]"
                title="Unggah foto atau tangkapan layar QR Code dari galeri perangkat"
            >
                <i data-lucide="image" class="w-4 h-4 text-emerald-400"></i>
                <span>Unggah Foto QR</span>
            </button>
        </div>

        <!-- Or Manual Paste Option -->
        <div class="pt-3 border-t border-slate-800 space-y-2">
            <label class="text-[11px] font-bold text-slate-400 block">Atau ketikkan nomor NIS / kode dokumen secara manual:</label>
            <div class="flex items-center gap-2">
                <input 
                    type="text" 
                    id="manualQrInput" 
                    placeholder="Contoh: SJI-2026-001 atau nomor telepon" 
                    class="flex-1 px-3.5 py-2.5 rounded-xl text-xs bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-japan-500 font-mono"
                >
                <button 
                    type="button" 
                    onclick="submitScannedQr()" 
                    class="btn-red-primary px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-1 shadow-sm active:scale-[0.97]"
                >
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                    <span>Cek</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes scanLaser {
    0% { top: 0%; opacity: 0.8; }
    50% { top: 96%; opacity: 1; }
    100% { top: 0%; opacity: 0.8; }
}
</style>

<script>
    let cameraStream = null;
    let qrScanAnimId = null;
    const offscreenCanvas = document.createElement('canvas');
    const offscreenCtx = offscreenCanvas.getContext('2d', { willReadFrequently: true });

    function openQrScanModal() {
        const modal = document.getElementById('qrScanModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeQrScanModal() {
        stopCameraStream();
        const modal = document.getElementById('qrScanModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    async function toggleCameraStream() {
        const video = document.getElementById('qrVideoElement');
        const placeholder = document.getElementById('qrPlaceholderIcon');
        const laser = document.getElementById('qrLaserScanLine');
        const label = document.getElementById('cameraBtnLabel');
        const statusText = document.getElementById('qrCameraStatusText');

        if (cameraStream) {
            stopCameraStream();
            return;
        }

        // Check if browser supports mediaDevices
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showCameraErrorModal('Browser Anda tidak mendukung akses kamera langsung atau halaman diakses melalui koneksi HTTP biasa. Kamera web memerlukan protokol HTTPS atau localhost.');
            return;
        }

        try {
            if (statusText) statusText.innerText = 'Menghubungkan kamera...';

            let stream = null;
            try {
                // Priority 1: Back camera for smartphone devices
                stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: { ideal: 'environment' }, width: { ideal: 1280 } }
                });
            } catch (e1) {
                // Priority 2: Any available camera (laptop webcam, front cam, USB cam)
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
            }

            cameraStream = stream;
            video.srcObject = stream;
            video.setAttribute('playsinline', 'true');
            video.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
            if (laser) laser.classList.remove('hidden');
            await video.play();

            if (label) label.innerText = 'Matikan Kamera';
            if (statusText) statusText.innerText = 'Arahkan kamera ke QR Code...';

            // Start live continuous scanning loop with jsQR
            startQrScanningLoop();

        } catch (err) {
            console.warn('Camera stream error:', err);
            stopCameraStream();

            let detailedMessage = 'Izin kamera belum diberikan atau diblokir di pengaturan browser Anda.';
            if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                detailedMessage = 'Akses kamera ditolak oleh browser. Silakan klik ikon gembok / perizinan di sebelah URL browser Anda, lalu aktifkan izin <strong>"Kamera / Camera"</strong>.';
            } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                detailedMessage = 'Tidak ada perangkat kamera yang terdeteksi pada komputer / laptop ini.';
            } else if (err.name === 'NotReadableError' || err.name === 'TrackStartError') {
                detailedMessage = 'Kamera sedang digunakan oleh aplikasi lain (seperti Zoom, Google Meet, atau tab browser lain).';
            }

            showCameraErrorModal(detailedMessage);
        }
    }

    function showCameraErrorModal(message) {
        if (window.Swal) {
            Swal.fire({
                icon: 'warning',
                title: 'Akses Kamera Terkendala',
                html: `
                    <div class="text-left text-xs space-y-2.5 text-slate-600">
                        <p>${message}</p>
                        <div class="bg-amber-50 p-3 rounded-2xl border border-amber-200 text-amber-900 space-y-1">
                            <p class="font-bold">💡 Solusi Cepat & Mudah:</p>
                            <p>1. Ketik kode <strong>NIS Siswa</strong> (contoh: <code>SJI-2026-001</code>) langsung di kolom manual.</p>
                            <p>2. Atau gunakan tombol <strong>"Unggah Foto QR"</strong> untuk memilih gambar dari galeri perangkat.</p>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Ketik NIS Manual',
                confirmButtonColor: '#DC2626',
                showCancelButton: true,
                cancelButtonText: '📷 Unggah Foto QR',
                cancelButtonColor: '#059669',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl p-6',
                    confirmButton: 'rounded-xl font-bold text-xs px-4 py-2.5',
                    cancelButton: 'rounded-xl font-bold text-xs px-4 py-2.5'
                }
            }).then((res) => {
                if (res.isConfirmed) {
                    document.getElementById('manualQrInput')?.focus();
                } else if (res.dismiss === Swal.DismissReason.cancel) {
                    document.getElementById('qrFileInput')?.click();
                }
            });
        } else {
            alert(message);
        }
    }

    function startQrScanningLoop() {
        const video = document.getElementById('qrVideoElement');
        if (!video) return;

        function scanFrame() {
            if (!cameraStream) return;

            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                offscreenCanvas.width = video.videoWidth;
                offscreenCanvas.height = video.videoHeight;
                offscreenCtx.drawImage(video, 0, 0, offscreenCanvas.width, offscreenCanvas.height);
                const imageData = offscreenCtx.getImageData(0, 0, offscreenCanvas.width, offscreenCanvas.height);

                if (window.jsQR) {
                    const code = jsQR(imageData.data, imageData.width, imageData.height, {
                        inversionAttempts: 'dontInvert'
                    });
                    if (code && code.data) {
                        processDetectedQr(code.data);
                        return;
                    }
                }
            }
            qrScanAnimId = requestAnimationFrame(scanFrame);
        }

        qrScanAnimId = requestAnimationFrame(scanFrame);
    }

    function stopCameraStream() {
        if (qrScanAnimId) {
            cancelAnimationFrame(qrScanAnimId);
            qrScanAnimId = null;
        }

        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }

        const video = document.getElementById('qrVideoElement');
        const placeholder = document.getElementById('qrPlaceholderIcon');
        const laser = document.getElementById('qrLaserScanLine');
        const label = document.getElementById('cameraBtnLabel');
        const statusText = document.getElementById('qrCameraStatusText');

        if (video) {
            video.classList.add('hidden');
            video.pause();
            video.srcObject = null;
        }
        if (placeholder) placeholder.classList.remove('hidden');
        if (laser) laser.classList.add('hidden');
        if (label) label.innerText = 'Aktifkan Kamera';
        if (statusText) statusText.innerText = 'Kamera Siap Diaktifkan';
    }

    function handleQrFileUpload(event) {
        const file = event.target.files && event.target.files[0];
        if (!file) return;

        if (window.Swal) {
            Swal.fire({
                title: 'Membaca QR Code...',
                text: 'Sedang memproses gambar dokumen...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                offscreenCanvas.width = img.width;
                offscreenCanvas.height = img.height;
                offscreenCtx.drawImage(img, 0, 0);
                const imageData = offscreenCtx.getImageData(0, 0, offscreenCanvas.width, offscreenCanvas.height);

                if (window.jsQR) {
                    const code = jsQR(imageData.data, imageData.width, imageData.height);
                    if (code && code.data) {
                        processDetectedQr(code.data);
                    } else {
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'error',
                                title: 'QR Code Tidak Terbaca',
                                text: 'Tidak ditemukan QR Code yang jelas pada foto yang diunggah. Pastikan foto tidak buram atau masukkan kode NIS secara manual.',
                                confirmButtonColor: '#DC2626',
                                confirmButtonText: 'Mengerti'
                            });
                        } else {
                            alert('QR Code tidak ditemukan pada gambar.');
                        }
                    }
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
        event.target.value = '';
    }

    function processDetectedQr(rawText) {
        stopCameraStream();
        if (!rawText) return;

        let nisOrCode = rawText.trim();
        if (nisOrCode.includes('/')) {
            const parts = nisOrCode.split('/');
            nisOrCode = parts[parts.length - 1];
        }

        const manualInput = document.getElementById('manualQrInput');
        if (manualInput) manualInput.value = nisOrCode;

        if (window.Swal) {
            Swal.fire({
                icon: 'success',
                title: 'QR Code Terdeteksi!',
                html: `Kode Dokumen: <strong class="text-japan-600 font-mono text-sm">${nisOrCode}</strong><br><span class="text-xs text-slate-500">Membuka database siswa...</span>`,
                timer: 1400,
                showConfirmButton: false,
                timerProgressBar: true
            });
        }

        const mainInput = document.getElementById('studentSearchInput');
        if (mainInput) {
            mainInput.value = nisOrCode;
            setTimeout(() => {
                closeQrScanModal();
                mainInput.closest('form').submit();
            }, 900);
        }
    }

    function submitScannedQr() {
        const val = (document.getElementById('manualQrInput')?.value || '').trim();
        if (!val) {
            if (window.Swal) {
                Swal.fire({
                    icon: 'info',
                    title: 'Masukkan Kode NIS',
                    text: 'Silakan ketik nomor NIS (contoh: SJI-2026-001) atau nomor telepon siswa terlebih dahulu.',
                    confirmButtonColor: '#DC2626',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('Silakan masukkan NIS terlebih dahulu.');
            }
            return;
        }

        processDetectedQr(val);
    }
</script>
@endsection
