<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - {{ $consultation->name }} - LPK Sahabat Jepang Indonesia</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-page {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-900 p-4 sm:p-8 antialiased">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <a href="{{ route('admin.consultations.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Data Leads
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Document Sheet (A4) -->
    <div class="max-w-3xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-slate-200 print-page space-y-6">
        
        <!-- Document Header (Kop Surat LPK) -->
        <div class="flex items-center justify-between border-b-2 border-slate-900 pb-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-red-600 text-white flex items-center justify-center font-black text-2xl">
                    友
                </div>
                <div>
                    <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-tight">LPK SAHABAT JEPANG INDONESIA</h1>
                    <p class="text-xs font-bold text-red-600">友好日本インドネシア • SENDING ORGANIZATION (SO)</p>
                    <p class="text-[10px] text-slate-500 mt-0.5">Izin Kemenaker RI No. 2/123/HK.01/V/2026 • Akreditasi Kemnaker A</p>
                </div>
            </div>

            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded bg-slate-100 border border-slate-300 text-[10px] font-mono font-black text-slate-800">
                    REG-SJI-{{ str_pad($consultation->id, 5, '0', STR_PAD_LEFT) }}
                </span>
                <p class="text-[10px] text-slate-400 mt-1">Tgl: {{ $consultation->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Document Title -->
        <div class="text-center py-2">
            <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide underline underline-offset-4">
                FORMULIR PENDAFTARAN & BIODATA CALON PESERTA
            </h2>
            <p class="text-xs text-slate-500 mt-1">Program Pelatihan Bahasa & Penyaluran Kerja ke Jepang</p>
        </div>

        <!-- Two Columns: Photo Box + Primary Meta -->
        <div class="grid grid-cols-12 gap-6 items-start">
            
            <!-- Bio Table (Left) -->
            <div class="col-span-9 space-y-3">
                <table class="w-full text-xs text-left">
                    <tr class="border-b border-slate-100">
                        <td class="py-2 font-bold text-slate-500 w-40">Nama Lengkap</td>
                        <td class="py-2 font-black text-slate-900 uppercase">: {{ $consultation->name }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-2 font-bold text-slate-500">Nomor WhatsApp / HP</td>
                        <td class="py-2 font-bold text-slate-900">: {{ $consultation->phone }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-2 font-bold text-slate-500">Usia Calon Siswa</td>
                        <td class="py-2 font-semibold text-slate-900">: {{ $consultation->age ? $consultation->age . ' Tahun' : '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-2 font-bold text-slate-500">Pendidikan Terakhir</td>
                        <td class="py-2 font-semibold text-slate-900">: {{ $consultation->education ?? '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-2 font-bold text-slate-500">Domisili / Kota Asal</td>
                        <td class="py-2 font-semibold text-slate-900">: {{ $consultation->city ?? '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-2 font-bold text-slate-500">Pilihan Program Karir</td>
                        <td class="py-2 font-black text-red-600">: {{ $consultation->program }}</td>
                    </tr>
                </table>
            </div>

            <!-- Pasfoto Box (Right) -->
            <div class="col-span-3 flex flex-col items-center justify-center">
                <div class="w-28 h-36 border-2 border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center text-center p-2 text-slate-400 bg-slate-50">
                    <span class="text-[11px] font-bold">Pasfoto 3x4</span>
                    <span class="text-[9px] mt-1 text-slate-400">(Latar Merah)</span>
                </div>
            </div>

        </div>

        <!-- Pesan / Motivasi Calon Siswa -->
        <div class="space-y-1.5 p-4 rounded-2xl bg-slate-50 border border-slate-200">
            <h3 class="text-xs font-bold text-slate-700 uppercase">Motivasi & Pesan Pendaftar:</h3>
            <p class="text-xs text-slate-700 italic leading-relaxed">
                "{{ $consultation->message ?: 'Tidak ada catatan tambahan saat pengisian formulir online.' }}"
            </p>
        </div>

        <!-- Catatan Hasil Konsultasi Awal (Internal LPK) -->
        <div class="space-y-1.5 p-4 rounded-2xl bg-slate-50 border border-slate-200">
            <h3 class="text-xs font-bold text-slate-700 uppercase">Catatan Verifikasi & Hasil Wawancara Awal Konselor:</h3>
            <p class="text-xs text-slate-700 leading-relaxed min-h-[40px]">
                {{ $consultation->admin_notes ?: 'Belum ada catatan verifikasi tambahan.' }}
            </p>
            <div class="flex items-center gap-4 text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                <span>Status Saat Ini: <strong>{{ strtoupper($consultation->status) }}</strong></span>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="pt-8 grid grid-cols-2 gap-8 text-center text-xs">
            <div class="space-y-16">
                <p class="font-bold text-slate-600">Calon Peserta Pelatihan,</p>
                <div>
                    <p class="font-black text-slate-900 underline">{{ $consultation->name }}</p>
                    <p class="text-[10px] text-slate-400">Tanda Tangan & Nama Terang</p>
                </div>
            </div>

            <div class="space-y-16">
                <p class="font-bold text-slate-600">Konselor / Administrator LPK,</p>
                <div>
                    <p class="font-black text-slate-900 underline">{{ auth()->user()->name ?? 'Tim Konselor LPK SJI' }}</p>
                    <p class="text-[10px] text-slate-400">Petugas Penerimaan Siswa</p>
                </div>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="pt-6 border-t border-slate-100 text-center text-[10px] text-slate-400">
            Dokumen resmi penerimaan calon peserta LPK Sahabat Jepang Indonesia • Dicetak otomatis pada {{ date('d/m/Y H:i') }} WIB
        </div>

    </div>

</body>
</html>
