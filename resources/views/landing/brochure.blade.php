@extends('layouts.app')

@section('title', 'Katalog & Unduh Brosur Resmi Pelatihan Kerja Jepang - LPK Sahabat Jepang Indonesia')
@section('meta_description', 'Unduh resmi silabus kurikulum 6 bulan, rincian biaya transparan tanpa pungutan liar, standar gaji di Jepang, serta beasiswa SMILE Project Kemenkes 100% Gratis.')
@section('meta_keywords', 'unduh brosur lpk jepang, silabus pelatihan jepang, rincian biaya magang jepang, beasiswa kemenkes jepang, sahabat jepang indonesia brosur')

@section('content')
<div class="bg-slate-950 text-white min-h-screen py-10 sm:py-16 relative overflow-hidden">
    
    <!-- Ambient Japanese Red Glow Background -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-red-600/15 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-96 h-96 rounded-full bg-rose-600/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-12">

        <!-- Top Header Hero -->
        <div class="text-center space-y-4 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold font-japanese shadow-xs">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span>公式パンフレット・Katalog Brosur Resmi LPK SJI 2026</span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                Pilih & Unduh Brosur Program Pilihan Anda
            </h1>
            
            <p class="text-xs sm:text-sm md:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto">
                Dapatkan informasi resmi silabus pelatihan 6 bulan, rincian biaya tanpa pungutan liar, standar gaji bersih di Jepang, dan alur penempatan terpercaya.
            </p>

            <!-- Filter Pills by Program -->
            <div class="flex flex-wrap items-center justify-center gap-2 pt-4">
                <a 
                    href="{{ route('brochure.index') }}" 
                    class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $selectedProgram === 'all' ? 'bg-japan-600 text-white shadow-md shadow-red-600/30' : 'bg-slate-900 text-slate-300 hover:bg-slate-800 border border-slate-800' }}"
                >
                    Semua Brosur
                </a>
                <a 
                    href="{{ route('brochure.index', ['program' => 'Tokutei Ginou (SSW)']) }}" 
                    class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $selectedProgram === 'Tokutei Ginou (SSW)' ? 'bg-japan-600 text-white shadow-md shadow-red-600/30' : 'bg-slate-900 text-slate-300 hover:bg-slate-800 border border-slate-800' }}"
                >
                    Tokutei Ginou (SSW)
                </a>
                <a 
                    href="{{ route('brochure.index', ['program' => 'Ginou Jisshusei (Magang)']) }}" 
                    class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $selectedProgram === 'Ginou Jisshusei (Magang)' ? 'bg-japan-600 text-white shadow-md shadow-red-600/30' : 'bg-slate-900 text-slate-300 hover:bg-slate-800 border border-slate-800' }}"
                >
                    Magang (Jisshusei)
                </a>
                <a 
                    href="{{ route('brochure.index', ['program' => 'Engineer & Profesional']) }}" 
                    class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $selectedProgram === 'Engineer & Profesional' ? 'bg-japan-600 text-white shadow-md shadow-red-600/30' : 'bg-slate-900 text-slate-300 hover:bg-slate-800 border border-slate-800' }}"
                >
                    Engineer / Pro
                </a>
                <a 
                    href="{{ route('brochure.index', ['program' => 'Panduan Biaya & Umum']) }}" 
                    class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $selectedProgram === 'Panduan Biaya & Umum' ? 'bg-japan-600 text-white shadow-md shadow-red-600/30' : 'bg-slate-900 text-slate-300 hover:bg-slate-800 border border-slate-800' }}"
                >
                    Panduan Biaya & Umum
                </a>
            </div>
        </div>

        @if(request('unlocked') === 'true' && $unlockedBrochure)
            
            <!-- ========================================================
                 UNLOCKED OFFICIAL BROCHURE (FILE DOWNLOAD & PRINT VIEW)
                 ======================================================== -->
            <div class="space-y-6">
                
                <!-- Action Controls Bar (No-Print) -->
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-900 border border-slate-800 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 text-emerald-400 text-xs font-bold">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Brosur Terbuka: {{ $unlockedBrochure->title }}</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-0.5">Program: {{ $unlockedBrochure->program }} • Telah diunduh {{ number_format($unlockedBrochure->download_count) }} kali</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($unlockedBrochure->file_path)
                            <a 
                                href="{{ route('brochure.download.file', $unlockedBrochure->id) }}" 
                                class="btn-red-primary px-4 py-2 rounded-xl text-xs font-black shadow-md flex items-center gap-1.5"
                            >
                                <i data-lucide="download" class="w-4 h-4"></i>
                                <span>Unduh File Asli ({{ $unlockedBrochure->file_size ?: 'PDF' }})</span>
                            </a>
                        @endif
                        <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold transition flex items-center gap-1.5">
                            <i data-lucide="printer" class="w-4 h-4"></i>
                            <span>Cetak / PDF</span>
                        </button>
                        <a href="https://api.whatsapp.com/send?phone=6281234567890&text={{ urlencode('Halo Admin LPK SJI, saya sudah membaca ' . $unlockedBrochure->title . ' dan ingin konsultasi pendaftaran kelas ' . $unlockedBrochure->program) }}" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-1.5">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>Konsultasi WA</span>
                        </a>
                    </div>
                </div>

                <!-- Printable Paper Container -->
                <div class="bg-white text-slate-900 rounded-3xl p-8 sm:p-12 shadow-2xl border border-slate-200 space-y-10">
                    
                    <!-- Official Header -->
                    <div class="border-b-2 border-slate-900 pb-6 flex items-start justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-3xl shadow-md flex-shrink-0">
                                友
                            </div>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase tracking-tight">
                                    LPK SAHABAT JEPANG INDONESIA
                                </h2>
                                <p class="text-xs font-bold text-red-600 mt-1">
                                    Sending Organization (SO) Resmi Kemenaker RI • Izin No: KEP.224/LATTAS/XII/2023
                                </p>
                                <p class="text-[11px] text-slate-500 mt-1">
                                    Jl. Sakura Raya No. 88, Jakarta Selatan • Hotline: +62 812-3456-7890 • Website: sahabatjepangindonesia.com
                                </p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-black rounded-lg uppercase tracking-wider">
                                {{ $unlockedBrochure->badge_text ?: 'EDISI RESMI 2026' }}
                            </span>
                            <p class="text-[10px] text-slate-400 font-mono mt-1">Katalog: {{ $unlockedBrochure->program }}</p>
                        </div>
                    </div>

                    <!-- Judul Dokumen -->
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 text-center space-y-2">
                        <h3 class="text-xl sm:text-2xl font-black text-slate-900 uppercase tracking-tight">{{ $unlockedBrochure->title }}</h3>
                        <p class="text-xs text-slate-600 max-w-2xl mx-auto">{{ $unlockedBrochure->description }}</p>
                    </div>

                    <!-- 1. Visi & Legalitas -->
                    <div class="space-y-3">
                        <h3 class="text-base font-black text-slate-900 border-l-4 border-red-600 pl-3 uppercase">
                            1. Legalitas Resmi & Jaminan Perlindungan Siswa
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            LPK Sahabat Jepang Indonesia (SJI) adalah Lembaga Pelatihan Kerja sekaligus <b>Sending Organization (SO) resmi</b> yang telah terakreditasi oleh Kementerian Ketenagakerjaan Republik Indonesia. Seluruh proses penempatan tenaga kerja ke Jepang dilindungi payung hukum bilateral RI - Jepang (Ijin SO No. KEP.224/LATTAS/XII/2023).
                        </p>
                    </div>

                    <!-- 2. Kurikulum Pelatihan Sesuai Program -->
                    <div class="space-y-4">
                        <h3 class="text-base font-black text-slate-900 border-l-4 border-red-600 pl-3 uppercase">
                            2. Kurikulum Pelatihan Intensif (Standar JLPT N4 / JFT A2)
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5">
                                <span class="text-[10px] font-bold text-red-600 uppercase">Bulan 1 - 2</span>
                                <h4 class="font-bold text-slate-800 text-sm">Dasar Bahasa (JLPT N5)</h4>
                                <p class="text-slate-500 text-[11px] leading-relaxed">Penguasaan Hiragana, Katakana, 100 Kanji dasar, tata bahasa Minna no Nihongo I, serta percakapan harian (Aisatsu).</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5">
                                <span class="text-[10px] font-bold text-red-600 uppercase">Bulan 3 - 4</span>
                                <h4 class="font-bold text-slate-800 text-sm">Tingkat Kerja (JLPT N4 / JFT)</h4>
                                <p class="text-slate-500 text-[11px] leading-relaxed">Peningkatan 300 Kanji kerja, listening Choukai, pemahaman konteks kerja di Jepang, dan persiapan ujian kelulusan resmi.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5">
                                <span class="text-[10px] font-bold text-red-600 uppercase">Bulan 5 - 6</span>
                                <h4 class="font-bold text-slate-800 text-sm">Matching Kaisha & Fisik</h4>
                                <p class="text-slate-500 text-[11px] leading-relaxed">Simulasi wawancara dengan User Jepang (Mensetsu), pembekalan budaya kerja Horenso, kedisiplinan 5S, dan pengurusan CoE/Visa.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Rincian Pembiayaan Transparan -->
                    <div class="space-y-4">
                        <h3 class="text-base font-black text-slate-900 border-l-4 border-red-600 pl-3 uppercase">
                            3. Rincian Pembiayaan Transparan (Zero Hidden Fees)
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-slate-200 rounded-xl overflow-hidden">
                                <thead class="bg-slate-100 font-bold text-slate-700 text-[11px]">
                                    <tr>
                                        <th class="p-3">Komponen Biaya</th>
                                        <th class="p-3">Cakupan Fasilitas</th>
                                        <th class="p-3 text-right">Biaya Resmi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 text-slate-600">
                                    <tr>
                                        <td class="p-3 font-semibold text-slate-800">Biaya Pendaftaran & Tes Minat</td>
                                        <td class="p-3">Psikotes, tes fisik awal, konsultasi jurusan</td>
                                        <td class="p-3 text-right font-mono font-bold text-emerald-600">Rp 0 (Gratis)</td>
                                    </tr>
                                    <tr>
                                        <td class="p-3 font-semibold text-slate-800">Pelatihan Bahasa & Budaya (6 Bulan)</td>
                                        <td class="p-3">Modul buku, modul audio, guru native & sensei bersertifikat</td>
                                        <td class="p-3 text-right font-mono font-bold text-slate-800">Rp 5.500.000</td>
                                    </tr>
                                    <tr>
                                        <td class="p-3 font-semibold text-slate-800">Asrama & Fasilitas Pelatihan</td>
                                        <td class="p-3">Tempat tinggal ber-AC, wifi, listrik, air, dan lab komputer CBT</td>
                                        <td class="p-3 text-right font-mono font-bold text-slate-800">Rp 4.000.000</td>
                                    </tr>
                                    <tr>
                                        <td class="p-3 font-semibold text-slate-800">Pengurusan Berkas & Job Matching</td>
                                        <td class="p-3">Penerjemahan dokumen resmi, koordinasi Kaisha di Jepang</td>
                                        <td class="p-3 text-right font-mono font-bold text-slate-800">Rp 8.500.000</td>
                                    </tr>
                                    <!-- Jalur Beasiswa Pemerintah: SMILE Project Kemenkes & Poltekkes (100% GRATIS) -->
                                    <tr class="bg-emerald-50/80 border-y-2 border-emerald-300">
                                        <td class="p-3">
                                            <span class="font-bold text-emerald-900 flex items-center gap-1.5">
                                                <i data-lucide="award" class="w-4 h-4 text-emerald-600"></i>
                                                <span>Program Pemerintah: SMILE Project (Kemenkes & Poltekkes Kaigo)</span>
                                            </span>
                                            <p class="text-[10px] text-emerald-700 mt-0.5 font-medium">Khusus alumni Poltekkes Kemenkes & STIKes mitra se-Indonesia (Sukses 4 Gelombang)</p>
                                        </td>
                                        <td class="p-3 text-emerald-800 text-[11px]">
                                            Pelatihan bahasa intensif, modul, asrama, ujian sertifikasi Kaigo, CoE, visa & penempatan RS Jepang 100% dibiayai negara.
                                        </td>
                                        <td class="p-3 text-right whitespace-nowrap">
                                            <span class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-black text-xs uppercase shadow-xs inline-block">100% GRATIS</span>
                                        </td>
                                    </tr>
                                    <tr class="bg-slate-50 font-black text-slate-900">
                                        <td colspan="2" class="p-3 text-right uppercase">Estimasi Biaya Reguler Non-Beasiswa (Siap Terbang):</td>
                                        <td class="p-3 text-right text-red-600 text-sm font-mono">Rp 18.000.000 - Rp 25.000.000*</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-[11px] text-slate-400 italic">
                            *Catatan: Jalur Beasiswa Kemenkes <b>100% Bebas Biaya (Gratis)</b>. Untuk jalur reguler umum, biaya dapat dicicil per termin atau menggunakan skema <b>Dana Talangan Kerja</b> yang dipotong setelah siswa bekerja di Jepang.
                        </p>
                    </div>

                    <!-- Footer Stempel -->
                    <div class="border-t border-slate-200 pt-6 flex items-center justify-between text-xs text-slate-500">
                        <div>
                            <p class="font-bold text-slate-800">LPK Sahabat Jepang Indonesia</p>
                            <p class="text-[11px]">Direktorat Penempatan & Kerjasama Luar Negeri</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 text-emerald-700 font-bold border border-emerald-200 text-[10px]">
                                Dokumen Resmi Terverifikasi
                            </span>
                        </div>
                    </div>

                </div>

                <div class="text-center pt-4">
                    <a href="{{ route('brochure.index') }}" class="text-xs font-bold text-slate-400 hover:text-white transition inline-flex items-center gap-1.5">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        <span>Kembali ke Katalog Semua Brosur</span>
                    </a>
                </div>

            </div>

        @else

            <!-- ========================================================
                 GOVERNMENT PROGRAMS SPECIAL HIGHLIGHT BANNER
                 ======================================================== -->
            <div class="mb-8 p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-950/70 via-slate-900 to-slate-900 border border-emerald-500/30 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-black uppercase tracking-wider border border-emerald-500/30">
                        <i data-lucide="award" class="w-3.5 h-3.5"></i>
                        <span>Program Resmi Pemerintah RI & Kemitraan Kampus</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white">
                        SMILE Project (Beasiswa Kemenkes 100% Gratis) & SMK Go Japan
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        LPK SJI telah menuntaskan 4 gelombang keberangkatan Kaigo beasiswa Kemenkes dari Poltekkes & STIKes se-Indonesia serta program kemitraan BKK SMK. Unduh silabus dan petunjuk teknis resminya di bawah ini.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 flex-shrink-0">
                    <a href="{{ route('brochure.index', ['program' => 'Tokutei Ginou (SSW)']) }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition flex items-center gap-1.5 shadow-lg shadow-emerald-900/30">
                        <i data-lucide="award" class="w-4 h-4"></i>
                        <span>Brosur SMILE Project</span>
                    </a>
                    <a href="{{ route('brochure.index', ['program' => 'Ginou Jisshusei (Magang)']) }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-black text-xs transition flex items-center gap-1.5 shadow-lg shadow-blue-900/30">
                        <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                        <span>Brosur SMK Go Japan</span>
                    </a>
                </div>
            </div>

            <!-- ========================================================
                 BROCHURE CATALOG GRID WITH MODAL DOWNLOAD TRIGGER
                 ======================================================== -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($brochures as $b)
                    <div class="bg-slate-900/90 rounded-3xl p-6 border {{ $b->theme['border'] }} shadow-xl flex flex-col justify-between space-y-6 hover:shadow-2xl transition duration-300 group">
                        
                        <div class="space-y-4">
                            <!-- Top Badge & Program -->
                            <div class="flex items-center justify-between gap-2">
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider {{ $b->theme['badge_bg'] }}">
                                    {{ $b->program }}
                                </span>
                                @if($b->badge_text)
                                    <span class="px-2 py-0.5 rounded-lg text-[9px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                        {{ $b->badge_text }}
                                    </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h3 class="text-base sm:text-lg font-black text-white group-hover:text-red-400 transition leading-snug">
                                {{ $b->title }}
                            </h3>

                            <!-- Description -->
                            <p class="text-xs text-slate-300 leading-relaxed line-clamp-3">
                                {{ $b->description ?: 'Dapatkan panduan resmi persyaratan, modul pembelajaran, dan rincian alur kerja di Jepang.' }}
                            </p>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-slate-800">
                            <!-- Meta Info -->
                            <div class="flex items-center justify-between text-[11px] text-slate-400 font-mono">
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-red-400"></i>
                                    <span>{{ $b->file_size ?: 'PDF 2.5 MB' }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-emerald-400">
                                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                    <span data-live-brochure-downloads="{{ $b->id }}">{{ number_format($b->download_count) }} diunduh</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <button 
                                type="button" 
                                onclick="openDownloadBrochureModal({{ $b->id }}, '{{ addslashes($b->title) }}', '{{ addslashes($b->program) }}')" 
                                class="btn-red-primary w-full py-2.5 rounded-xl text-xs font-black shadow-md flex items-center justify-center gap-2"
                            >
                                <i data-lucide="download" class="w-4 h-4"></i>
                                <span>Unduh Brosur Ini</span>
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-500 space-y-2">
                        <i data-lucide="inbox" class="w-10 h-10 mx-auto opacity-40"></i>
                        <p class="text-sm font-semibold">Belum ada brosur untuk kategori program ini.</p>
                        <a href="{{ route('brochure.index') }}" class="text-xs text-japan-400 font-bold hover:underline block mt-2">Lihat semua brosur</a>
                    </div>
                @endforelse
            </div>

            <!-- Consultation Banner Bottom -->
            <div class="bg-gradient-to-r from-red-950/60 via-slate-900 to-slate-900 border border-red-500/20 rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
                <div class="space-y-1 text-center md:text-left">
                    <h4 class="text-base sm:text-lg font-black text-white">Butuh Bimbingan Memilih Program?</h4>
                    <p class="text-xs text-slate-300">Konsultasikan minat, latar belakang pendidikan, dan kesiapan finansial Anda bersama konsultan resmi LPK SJI secara gratis.</p>
                </div>
                <a href="https://api.whatsapp.com/send?phone=6281234567890&text=Halo%20LPK%20SJI,%20saya%20ingin%20konsultasi%20pemilihan%20program%20kerja%20Jepang" target="_blank" class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-2 flex-shrink-0 shadow-lg shadow-emerald-600/20">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Tanya Konsultan via WhatsApp</span>
                </a>
            </div>

        @endif

    </div>

</div>

<!-- ==============================================================
     MODAL: INSTANT UNLOCK & DOWNLOAD FORM
     ============================================================== -->
<div id="guestBrochureModal" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-white text-slate-900 rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-6">
        
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                    <i data-lucide="file-down" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Unduh Brosur Resmi</h3>
                    <p id="modalBrochureTitle" class="text-xs text-japan-600 font-bold truncate max-w-[220px]">Brosur Terpilih</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('guestBrochureModal')" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('brochure.download') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" id="modalBrochureId" name="brochure_id" value="">

            <!-- Nama Lengkap -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Budi Prasetyo" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
            </div>

            <!-- WhatsApp -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                <input type="tel" name="phone" required placeholder="Contoh: 08123456789" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600 font-mono">
                <p class="text-[10px] text-slate-400">File brosur & info jadwal seleksi akan dikirimkan juga ke nomor ini.</p>
            </div>

            <!-- Kota -->
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Kota Domisili</label>
                <input type="text" name="city" placeholder="Contoh: Surabaya, Semarang, Jakarta" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
            </div>

            <button type="submit" class="btn-red-primary w-full py-3 rounded-xl text-xs font-black shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 mt-2">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Buka & Unduh Brosur Sekarang</span>
            </button>
        </form>

        <p class="text-[10px] text-slate-400 text-center">
            Privasi Anda terjamin. LPK SJI tidak pernah membagikan kontak Anda kepada pihak ketiga.
        </p>

    </div>
</div>

<script>
    function openDownloadBrochureModal(id, title, program) {
        document.getElementById('modalBrochureId').value = id;
        document.getElementById('modalBrochureTitle').textContent = title;
        openModal('guestBrochureModal');
    }
</script>
@endsection
