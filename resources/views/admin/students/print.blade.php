<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Siswa Pelatihan - {{ $student->name }} ({{ $student->nis }}) - LPK Sahabat Jepang Indonesia</title>
    
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
            margin: 1.2cm;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-900 p-4 sm:p-8 antialiased">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <a href="{{ route('admin.students.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            &larr; Kembali ke Data Siswa
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Simpan PDF (A4)</span>
            </button>
        </div>
    </div>

    <!-- Official Student Dossier Sheet (A4) -->
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-slate-200 print-page space-y-5">
        
        <!-- Header Kop Surat -->
        <div class="flex items-center justify-between border-b-2 border-slate-900 pb-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-red-600 text-white flex items-center justify-center font-black text-2xl font-japanese">
                    友
                </div>
                <div>
                    <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-tight">LPK SAHABAT JEPANG INDONESIA</h1>
                    <p class="text-xs font-bold text-red-600 font-japanese">友好日本インドネシア • SENDING ORGANIZATION (SO)</p>
                    <p class="text-[10px] text-slate-500 mt-0.5">Izin Kemenaker RI No. 2/123/HK.01/V/2026 • Akreditasi Kemnaker A</p>
                </div>
            </div>

            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded bg-slate-900 text-white text-xs font-mono font-black">
                    {{ $student->nis }}
                </span>
                <p class="text-[10px] text-slate-400 mt-1">Status: {{ strtoupper($student->status) }}</p>
            </div>
        </div>

        <!-- Document Title -->
        <div class="text-center py-1">
            <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide underline underline-offset-4">
                LEMBAR BIODATA & PROFIL SISWA PELATIHAN KERJA JEPANG
            </h2>
            <p class="text-xs text-slate-500 mt-0.5 font-japanese">研修生・特定技能生 プロフィールシート</p>
        </div>

        <!-- Photo & Identity Section -->
        <div class="grid grid-cols-12 gap-5 items-start">
            
            <!-- Table Info (9 cols) -->
            <div class="col-span-9">
                <table class="w-full text-xs text-left">
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500 w-36">Nama Lengkap</td>
                        <td class="py-1.5 font-black text-slate-900 uppercase">: {{ $student->name }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Nama Katakana</td>
                        <td class="py-1.5 font-bold text-japan-600 font-japanese">: {{ $student->japanese_name ?: '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">NIK (KTP)</td>
                        <td class="py-1.5 font-mono text-slate-800">: {{ $student->nik ?: '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Jenis Kelamin / Usia</td>
                        <td class="py-1.5 text-slate-800">: {{ $student->gender }} • {{ $student->birth_date ? $student->birth_date->age . ' Tahun' : '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Tempat, Tgl Lahir</td>
                        <td class="py-1.5 text-slate-800">: {{ $student->birth_place ?: '-' }}, {{ $student->birth_date ? $student->birth_date->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">No. WhatsApp / HP</td>
                        <td class="py-1.5 font-semibold text-slate-900">: {{ $student->phone ?: '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Pendidikan Terakhir</td>
                        <td class="py-1.5 text-slate-800">: {{ $student->education ?: '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Alamat Domisili</td>
                        <td class="py-1.5 text-slate-800">: {{ $student->address ?: '-' }} ({{ $student->city ?: '-' }})</td>
                    </tr>
                </table>
            </div>

            <!-- Pasfoto Box (3 cols) -->
            <div class="col-span-3 flex flex-col items-center justify-center">
                <div class="w-28 h-36 border-2 border-slate-300 rounded-xl overflow-hidden shadow-sm flex items-center justify-center bg-slate-100">
                    @if($student->photo)
                        <img src="{{ $student->photo }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-[11px] text-slate-400 font-bold text-center">Pasfoto 3x4</span>
                    @endif
                </div>
            </div>

        </div>

        <!-- Training, Placement & Qualification Info -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 text-xs">
            <h3 class="font-black text-slate-900 uppercase text-[11px] border-b border-slate-200 pb-1">
                Data Program, Penempatan & Kualifikasi Jepang
            </h3>
            <div class="grid grid-cols-2 gap-x-6 gap-y-2">
                <div>
                    <span class="text-slate-500">Program Karir:</span>
                    <p class="font-black text-japan-600">{{ $student->program }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Sektor / Bidang Kerja:</span>
                    <p class="font-bold text-slate-800">{{ $student->sector ?: 'Umum' }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Perusahaan Jepang (Kaisha):</span>
                    <p class="font-bold text-slate-900">{{ $student->destination_company ?: 'Proses Penempatan' }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Prefektur / Kota:</span>
                    <p class="font-bold text-slate-800">{{ $student->destination_prefecture ?: '-' }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Kemampuan Bahasa Jepang:</span>
                    <p class="font-bold text-emerald-700">{{ $student->japanese_level ?: 'Belum Ada' }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Sertifikasi Keahlian SSW:</span>
                    <p class="font-semibold text-slate-800">{{ $student->ssw_certificate ?: '-' }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Tanggal Masuk Pelatihan:</span>
                    <p class="font-semibold text-slate-800">{{ $student->entry_date ? $student->entry_date->format('d/m/Y') : '-' }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Estimasi / Tanggal Terbang:</span>
                    <p class="font-bold text-japan-600">{{ $student->departure_date ? $student->departure_date->format('d/m/Y') : '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Medical MCU, CoE & Visa & Evaluasi Akademik -->
        <div class="grid grid-cols-2 gap-4 text-xs">
            <!-- Medikal & Legalitas Keberangkatan -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <h3 class="font-black text-slate-900 uppercase text-[11px] border-b border-slate-200 pb-1">
                    Rekam Medis (MCU) & Visa
                </h3>
                <div class="space-y-1.5">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Hasil MCU:</span>
                        <span class="font-bold {{ $student->mcu_result === 'fit' ? 'text-emerald-700' : 'text-slate-800' }}">
                            {{ $student->mcu_label }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Klinik / Tgl MCU:</span>
                        <span class="text-slate-800">{{ $student->mcu_clinic ?: '-' }} ({{ $student->mcu_date ? $student->mcu_date->format('d/m/Y') : '-' }})</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nomor Paspor:</span>
                        <span class="font-mono font-bold text-slate-800">{{ $student->passport_number ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nomor CoE:</span>
                        <span class="font-mono text-slate-800">{{ $student->coe_number ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nomor Visa:</span>
                        <span class="font-mono text-slate-800">{{ $student->visa_number ?: '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Evaluasi Akademik & Sikap -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <h3 class="font-black text-slate-900 uppercase text-[11px] border-b border-slate-200 pb-1">
                    Evaluasi Akademik & Disiplin
                </h3>
                <div class="space-y-1.5">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Rata-rata Nilai Ujian:</span>
                        <span class="font-black text-slate-900">{{ $student->exam_score ? $student->exam_score . ' / 100' : '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tingkat Kehadiran:</span>
                        <span class="font-bold text-emerald-700">{{ $student->attendance_percentage ?? 100 }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Grade Kedisiplinan:</span>
                        <span class="font-black text-japan-600">Grade {{ $student->discipline_grade ?? 'A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kelengkapan Berkas:</span>
                        <span class="font-bold text-slate-800">{{ $student->uploaded_documents_count }} dari 8 Dokumen</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checklist Dokumen Fisik / Digital -->
        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-1.5">
            <h3 class="font-black text-slate-900 uppercase text-[10px]">
                Status Arsip Berkas Dokumen Pribadi:
            </h3>
            <div class="grid grid-cols-4 gap-2 text-[10px]">
                <div class="flex items-center gap-1.5">
                    <span class="{{ !empty($student->document_ktp) ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ !empty($student->document_ktp) ? '✓' : '✗' }} e-KTP</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="{{ !empty($student->document_kk) ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ !empty($student->document_kk) ? '✓' : '✗' }} Kartu Keluarga</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="{{ !empty($student->document_ijazah) ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ !empty($student->document_ijazah) ? '✓' : '✗' }} Ijazah Asli</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="{{ !empty($student->document_passport) ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ !empty($student->document_passport) ? '✓' : '✗' }} Paspor RI</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="{{ !empty($student->document_certificate) ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ !empty($student->document_certificate) ? '✓' : '✗' }} JLPT / JFT</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="{{ !empty($student->document_ssw) ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ !empty($student->document_ssw) ? '✓' : '✗' }} Skill SSW</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="{{ !empty($student->document_mcu) ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ !empty($student->document_mcu) ? '✓' : '✗' }} Hasil MCU</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="{{ !empty($student->document_coe_visa) ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ !empty($student->document_coe_visa) ? '✓' : '✗' }} CoE & Visa</span>
                </div>
            </div>
        </div>

        <!-- Financial Status -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 text-xs">
            <h3 class="font-black text-slate-900 uppercase text-[11px] border-b border-slate-200 pb-1">
                Status Administrasi Biaya & Keuangan
            </h3>
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <span class="text-slate-500">Total Biaya:</span>
                    <p class="font-black text-slate-900">{{ $student->formatted_total_cost }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Jumlah Terbayar:</span>
                    <p class="font-black text-emerald-600">{{ $student->formatted_paid_amount }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Sisa Tanggungan:</span>
                    <p class="font-black {{ $student->remaining_balance > 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $student->formatted_remaining_balance }}</p>
                </div>
                <div>
                    <span class="text-slate-500">Status Pembayaran:</span>
                    <p class="font-bold uppercase text-slate-900">{{ strtoupper($student->payment_status) }}</p>
                </div>
            </div>
        </div>

        <!-- Catatan Evaluasi -->
        @if($student->admin_notes)
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
                <span class="font-bold text-slate-700 uppercase text-[10px]">Catatan Evaluasi Sensei / Admin:</span>
                <p class="text-slate-700 italic mt-0.5">{{ $student->admin_notes }}</p>
            </div>
        @endif

        <!-- Signatures Section -->
        <div class="pt-6 grid grid-cols-2 gap-8 text-center text-xs">
            <div class="space-y-16">
                <p class="font-bold text-slate-600">Siswa Pelatihan,</p>
                <div>
                    <p class="font-black text-slate-900 underline uppercase">{{ $student->name }}</p>
                    <p class="text-[10px] text-slate-400">NIS: {{ $student->nis }}</p>
                </div>
            </div>

            <div class="space-y-16">
                <p class="font-bold text-slate-600">Instruktur / Sensei Pembina,</p>
                <div>
                    <p class="font-black text-slate-900 underline uppercase">Budi Santoso, S.Pd., M.Hum.</p>
                    <p class="text-[10px] text-slate-400">Kepala Kurikulum LPK SJI</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-4 border-t border-slate-100 text-center text-[9px] text-slate-400">
            Dokumen arsip resmi LPK Sahabat Jepang Indonesia • Dicetak otomatis pada {{ date('d/m/Y H:i') }} WIB
        </div>

    </div>

</body>
</html>
