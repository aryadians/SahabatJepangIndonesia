@extends('layouts.app')

@section('title', 'Unduh Brosur Resmi & Panduan Biaya Transparan - LPK Sahabat Jepang Indonesia')

@section('content')
<div class="bg-slate-950 text-white min-h-screen py-10 sm:py-16 relative overflow-hidden">
    
    <!-- Ambient Japanese Red Glow Background -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-red-600/15 blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-96 h-96 rounded-full bg-rose-600/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-10">

        <!-- Top Header Hero -->
        <div class="text-center space-y-4 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold font-japanese shadow-xs">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span>公式パンフレット・Brosur Resmi LPK SJI 2026</span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                Brosur Resmi Kurikulum & Panduan Biaya Transparan
            </h1>
            
            <p class="text-xs sm:text-sm md:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto">
                Pelajari rincian lengkap kurikulum intensif bahasa Jepang, tahapan seleksi kerja, estimasi gaji bersih di Jepang, serta transparansi rincian biaya pelatihan tanpa pungutan liar.
            </p>
        </div>

        @if(request('unlocked') === 'true' || session('success'))
            
            <!-- ========================================================
                 UNLOCKED OFFICIAL BROCHURE (FULL PRINTABLE DOCUMENT)
                 ======================================================== -->
            <div class="space-y-6">
                
                <!-- Action Controls Bar (No-Print) -->
                <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 text-emerald-400 text-xs font-bold">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span>Brosur Resmi Telah Terbuka Sepenuhnya</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="window.print()" class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5">
                            <i data-lucide="printer" class="w-4 h-4"></i>
                            <span>Cetak / Simpan PDF</span>
                        </button>
                        <a href="https://api.whatsapp.com/send?phone=6281234567890&text=Halo%20Admin%20LPK%20SJI,%20saya%20sudah%20membaca%20brosur%20resmi%20dan%20ingin%20konsultasi%20pendaftaran" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-1.5">
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
                                EDISI RESMI 2026
                            </span>
                        </div>
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

                    <!-- 2. Kurikulum Pelatihan -->
                    <div class="space-y-4">
                        <h3 class="text-base font-black text-slate-900 border-l-4 border-red-600 pl-3 uppercase">
                            2. Kurikulum Pelatihan Intensif (Standar JLPT N4 / JFT A2)
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5">
                                <span class="text-[10px] font-bold text-red-600 uppercase">Bulan 1 - 2</span>
                                <h4 class="font-black text-slate-900 text-sm">Dasar Bahasa & Kanji</h4>
                                <p class="text-slate-500 text-[11px]">Hiragana, Katakana, 150 Kanji dasar, tata bahasa Minna no Nihongo bab 1-25 (JLPT N5).</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5">
                                <span class="text-[10px] font-bold text-red-600 uppercase">Bulan 3 - 4</span>
                                <h4 class="font-black text-slate-900 text-sm">Kemahiran Kerja (N4 / A2)</h4>
                                <p class="text-slate-500 text-[11px]">300 Kanji lanjutan, kosakata bidang kerja (Kaigo/Food/Manufaktur), Kaiwa percakapan sehari-hari.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5">
                                <span class="text-[10px] font-bold text-red-600 uppercase">Bulan 5 - 6</span>
                                <h4 class="font-black text-slate-900 text-sm">Wawancara Kaisha & CoE</h4>
                                <p class="text-slate-500 text-[11px]">Simulasi wawancara kerja (Mensaetsu), etika kerja Jepang (Hou-Ren-So), pengajuan CoE & Visa.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Perbandingan Program Karir & Gaji -->
                    <div class="space-y-4">
                        <h3 class="text-base font-black text-slate-900 border-l-4 border-red-600 pl-3 uppercase">
                            3. Pilihan Program Karir & Estimasi Penghasilan
                        </h3>
                        <div class="overflow-x-auto rounded-2xl border border-slate-200 text-xs">
                            <table class="w-full text-left">
                                <thead class="bg-slate-100 text-slate-600 font-bold uppercase text-[10px]">
                                    <tr>
                                        <th class="py-3 px-4">Program Karir</th>
                                        <th class="py-3 px-4">Durasi Kontrak</th>
                                        <th class="py-3 px-4">Standar Gaji Bulanan</th>
                                        <th class="py-3 px-4">Potensi Bersih / Bulan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr>
                                        <td class="py-3 px-4 font-bold text-slate-900">Tokutei Ginou (SSW)</td>
                                        <td class="py-3 px-4 text-slate-600">5 Tahun (Bisa Perpanjang)</td>
                                        <td class="py-3 px-4 font-bold text-emerald-600 font-mono">¥200,000 - ¥250,000 (~Rp 22-27 Juta)</td>
                                        <td class="py-3 px-4 text-slate-700 font-mono">Rp 14.000.000 - Rp 18.000.000</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-bold text-slate-900">Ginou Jisshusei (Magang)</td>
                                        <td class="py-3 px-4 text-slate-600">3 Tahun</td>
                                        <td class="py-3 px-4 font-bold text-emerald-600 font-mono">¥165,000 - ¥195,000 (~Rp 18-21 Juta)</td>
                                        <td class="py-3 px-4 text-slate-700 font-mono">Rp 10.000.000 - Rp 14.000.000</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-bold text-slate-900">Engineer & Profesional</td>
                                        <td class="py-3 px-4 text-slate-600">Jangka Panjang / Tetap</td>
                                        <td class="py-3 px-4 font-bold text-emerald-600 font-mono">¥250,000 - ¥350,000 (~Rp 27-38 Juta)</td>
                                        <td class="py-3 px-4 text-slate-700 font-mono">Rp 20.000.000 - Rp 28.000.000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 4. Rincian Biaya Transparan Tanpa Pungli -->
                    <div class="space-y-4">
                        <h3 class="text-base font-black text-slate-900 border-l-4 border-red-600 pl-3 uppercase">
                            4. Struktur Rincian Biaya Transparan (Zero Hidden Cost)
                        </h3>
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                            <div class="space-y-2 text-xs">
                                <div class="flex justify-between items-center py-1.5 border-b border-slate-200">
                                    <span class="text-slate-700 font-semibold">1. Biaya Pelatihan Intensif Bahasa & Modul Belajar (6 Bulan)</span>
                                    <span class="font-bold font-mono text-slate-900">Termasuk</span>
                                </div>
                                <div class="flex justify-between items-center py-1.5 border-b border-slate-200">
                                    <span class="text-slate-700 font-semibold">2. Fasilitas Asrama Putra/Putri, Listrik, Air & Wi-Fi Selama Pelatihan</span>
                                    <span class="font-bold font-mono text-slate-900">Termasuk</span>
                                </div>
                                <div class="flex justify-between items-center py-1.5 border-b border-slate-200">
                                    <span class="text-slate-700 font-semibold">3. Bimbingan Ujian JLPT / JFT-Basic & Ujian Keahlian SSW Prometric</span>
                                    <span class="font-bold font-mono text-slate-900">Termasuk</span>
                                </div>
                                <div class="flex justify-between items-center py-1.5 border-b border-slate-200">
                                    <span class="text-slate-700 font-semibold">4. Biaya Administrasi Pengurusan Certificate of Eligibility (CoE) Imigrasi Jepang</span>
                                    <span class="font-bold font-mono text-slate-900">Termasuk</span>
                                </div>
                                <div class="flex justify-between items-center py-1.5 border-b border-slate-200">
                                    <span class="text-slate-700 font-semibold">5. Pengurusan Visa Kerja Kedutaan Besar Jepang & BPJS Ketenagakerjaan</span>
                                    <span class="font-bold font-mono text-slate-900">Termasuk</span>
                                </div>
                                <div class="flex justify-between items-center py-1.5 border-b border-slate-200">
                                    <span class="text-slate-700 font-semibold">6. Tiket Pesawat Penerbangan Resmi Indonesia ➔ Bandara Jepang</span>
                                    <span class="font-bold font-mono text-emerald-600">Ditanggung Kaisha / LPK</span>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 space-y-1">
                                <p class="font-bold">Skema Pembayaran Fleksibel:</p>
                                <p>• Pembayaran dapat dicicil 3 termin selama masa pelatihan intensif.</p>
                                <p>• Tersedia program <b>Dana Talangan Kerja</b> bagi calon siswa yang membutuhkan kemudahan pembiayaan hingga berangkat ke Jepang.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Signature & Legal Stamp -->
                    <div class="border-t-2 border-slate-900 pt-6 flex items-end justify-between">
                        <div class="text-[11px] text-slate-400">
                            Dokumen resmi terverifikasi LPK SJI • Tanggal unduh: {{ date('d F Y') }}
                        </div>
                        <div class="text-center w-56 space-y-1">
                            <p class="text-xs text-slate-500">Direktur Utama</p>
                            <div class="h-14 flex items-center justify-center">
                                <span class="text-xs font-bold text-red-600 font-japanese">[Stempel Resmi LPK SJI]</span>
                            </div>
                            <p class="text-xs font-black text-slate-900 underline underline-offset-4">LPK Sahabat Jepang Indonesia</p>
                        </div>
                    </div>

                </div>

            </div>

        @else

            <!-- ========================================================
                 LEAD CAPTURE FORM (TO UNLOCK BROCHURE)
                 ======================================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Left: Brochure Features Preview -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="space-y-4">
                        <h2 class="text-2xl sm:text-3xl font-black text-white leading-snug">
                            Dapatkan Brosur Lengkap & Estimasi Biaya Resmi Langsung di Layar Anda
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Brosur resmi ini mencakup panduan langkah demi langkah dari pendaftaran, asrama, kurikulum bahasa, hingga penempatan resmi di perusahaan Jepang.
                        </p>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800">
                            <div class="w-8 h-8 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center font-bold flex-shrink-0">
                                <i data-lucide="book-open" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white">Silabus Lengkap 6 Bulan</h4>
                                <p class="text-slate-400 text-[11px]">Kurikulum resmi N5, N4, dan keahlian SSW Kaigo, Makanan, & Manufaktur.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800">
                            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold flex-shrink-0">
                                <i data-lucide="calculator" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white">Simulasi Gaji & Tabungan</h4>
                                <p class="text-slate-400 text-[11px]">Rincian potongan pajak, asuransi, dan potensi tabungan bersih Rp 15-20 Juta/bulan.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800">
                            <div class="w-8 h-8 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold flex-shrink-0">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white">Biaya Transparan & Dana Talangan</h4>
                                <p class="text-slate-400 text-[11px]">Struktur biaya tanpa pungli serta opsi cicilan dan dana talangan kerja.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Instant Unlock Form -->
                <div class="lg:col-span-6">
                    <div class="bg-white text-slate-900 rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-6">
                        <div class="border-b border-slate-100 pb-4">
                            <h3 class="text-lg font-black text-slate-900">Formulir Akses Brosur Resmi</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Isi data singkat berikut untuk langsung membuka brosur</p>
                        </div>

                        <form action="{{ route('brochure.download') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Nama Lengkap -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" required placeholder="Contoh: Budi Prasetyo" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                            </div>

                            <!-- No WhatsApp -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                                <input type="tel" name="phone" required placeholder="Contoh: 08123456789" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600 font-mono">
                            </div>

                            <!-- Program yang Diminati -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Program yang Diminati <span class="text-rose-500">*</span></label>
                                <select name="program" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                                    <option value="Tokutei Ginou (SSW)">Tokutei Ginou (SSW) - Visa Kerja Berkeahlian</option>
                                    <option value="Ginou Jisshusei (Magang)">Ginou Jisshusei (Magang Jepang 3 Tahun)</option>
                                    <option value="Engineer & Profesional">Engineer / Profesional (Lulusan D3/S1)</option>
                                    <option value="Kursus Bahasa Jepang">Kursus Persiapan Bahasa Jepang</option>
                                </select>
                            </div>

                            <!-- Kota Domisili -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Kota Domisili Saat Ini</label>
                                <input type="text" name="city" placeholder="Contoh: Surabaya, Semarang, Medan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                            </div>

                            <button type="submit" class="btn-red-primary w-full py-3 rounded-xl text-xs font-black shadow-lg shadow-red-600/30 flex items-center justify-center gap-2 mt-2">
                                <i data-lucide="download" class="w-4 h-4"></i>
                                <span>Buka & Unduh Brosur Sekarang</span>
                            </button>
                        </form>

                        <p class="text-[10px] text-slate-400 text-center">
                            Data Anda dijamin kerahasiaannya dan hanya digunakan oleh tim konsultan resmi LPK SJI.
                        </p>
                    </div>
                </div>

            </div>

        @endif

    </div>

</div>
@endsection
