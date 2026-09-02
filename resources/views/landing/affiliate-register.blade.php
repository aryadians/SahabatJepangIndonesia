@extends('layouts.app')

@section('title', 'Program Kemitraan Sekolah & Afiliasi - LPK Sahabat Jepang Indonesia')

@section('content')
<div class="bg-slate-900 text-white min-h-screen py-12 relative overflow-hidden">

    <!-- Japanese Red Glow Accents -->
    <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-red-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 rounded-full bg-blue-600/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-10">

        <!-- Top Header -->
        <div class="text-center space-y-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold font-japanese">
                <span>学校・同窓会パートナーシップ • Affiliate Program</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Program Kemitraan Sekolah (BKK), Kampus & Alumni
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto">
                Dapatkan insentif reward hingga <strong>Rp 750.000 / siswa</strong> dengan mereferensikan siswa, lulusan SMK, atau rekan Anda untuk berkarir ke Jepang melalui LPK Sahabat Jepang Indonesia.
            </p>
        </div>

        <!-- Benefits Value Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-5 rounded-3xl bg-slate-800/80 border border-slate-700/80 space-y-2 text-center">
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto">
                    <i data-lucide="gift" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-white text-sm">Reward Insentif Resmi</h4>
                <p class="text-[11px] text-slate-400">Komisi cair langsung ke rekening Anda saat siswa resmi masuk kelas pelatihan.</p>
            </div>

            <div class="p-5 rounded-3xl bg-slate-800/80 border border-slate-700/80 space-y-2 text-center">
                <div class="w-10 h-10 rounded-2xl bg-blue-500/20 text-blue-400 flex items-center justify-center mx-auto">
                    <i data-lucide="link" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-white text-sm">Link Referral Otomatis</h4>
                <p class="text-[11px] text-slate-400">Dapatkan tautan unik yang langsung melacak setiap pendaftar dari sekolah/komunitas Anda.</p>
            </div>

            <div class="p-5 rounded-3xl bg-slate-800/80 border border-slate-700/80 space-y-2 text-center">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center mx-auto">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-white text-sm">LPK & SO Resmi Kemenaker</h4>
                <p class="text-[11px] text-slate-400">Jaminan proses 100% legal, amanah, dan terpercaya bagi alumni dan siswa Anda.</p>
            </div>
        </div>

        <!-- Registration Form Card -->
        <div class="bg-white text-slate-900 rounded-3xl p-7 sm:p-10 shadow-2xl border border-red-100 space-y-6">
            
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-xl font-black text-slate-900">Formulir Pendaftaran Mitra Afiliasi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Isi data diri atau institusi Anda untuk mendapatkan kode referral resmi</p>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs space-y-3 animate-fadeIn">
                    <div class="flex items-center gap-2 font-bold text-emerald-800 text-sm">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @if(session('referral_link'))
                        <div class="p-3.5 rounded-xl bg-white border border-emerald-200 space-y-1.5">
                            <span class="text-slate-500 font-bold block">Tautan Pendaftaran Referral Anda:</span>
                            <div class="flex items-center gap-2">
                                <input type="text" id="refLinkInput" readonly value="{{ session('referral_link') }}" class="w-full font-mono text-xs text-blue-600 bg-slate-50 p-2 rounded-lg border border-slate-200">
                                <button type="button" onclick="navigator.clipboard.writeText('{{ session('referral_link') }}'); alert('Link referral berhasil disalin!');" class="px-4 py-2 rounded-lg bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition">
                                    Salin
                                </button>
                            </div>
                            <span class="text-[10px] text-emerald-700 block">
                                💡 Bagikan link ini kepada siswa / rekan Anda. Setiap pendaftaran yang masuk melalui link ini akan otomatis tercatat atas nama Anda.
                            </span>
                        </div>
                    @endif
                </div>
            @endif

            <form action="{{ route('affiliates.public.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase">Nama Lengkap / Penanggung Jawab *</label>
                        <input type="text" name="name" required placeholder="Contoh: Budi Santoso, S.Pd" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 focus:outline-none focus:border-japan-600 font-bold">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase">Kategori Kemitraan *</label>
                        <select name="type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 focus:outline-none focus:border-japan-600 font-bold">
                            <option value="guru_bk">Guru BK / Koordinator BKK SMK</option>
                            <option value="sekolah">Institusi Sekolah (SMK / SMA / Universitas)</option>
                            <option value="alumni">Alumni LPK Sahabat Jepang Indonesia</option>
                            <option value="komunitas">Komunitas / Lembaga Kursus Bahasa</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase">Nama Sekolah / Kampus / Instansi</label>
                        <input type="text" name="institution_name" placeholder="Contoh: SMK Negeri 1 Bandung" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 focus:outline-none focus:border-japan-600">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-slate-700 uppercase">Nomor WhatsApp Aktif *</label>
                        <input type="tel" name="phone" required placeholder="081234567890" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 focus:outline-none focus:border-japan-600 font-bold">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase">Alamat Email</label>
                    <input type="email" name="email" placeholder="email@sekolah.sch.id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 focus:outline-none focus:border-japan-600">
                </div>

                <!-- Rekening Reward -->
                <div class="pt-2 border-t border-slate-100">
                    <p class="font-bold text-slate-800 text-xs mb-3">Informasi Rekening Bank (Untuk Pencairan Reward Komisi):</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">Nama Bank</label>
                            <input type="text" name="bank_name" placeholder="BCA / Mandiri / BNI / BRI" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-900 focus:outline-none focus:border-japan-600">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">Nomor Rekening</label>
                            <input type="text" name="bank_account_number" placeholder="1234567890" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-900 focus:outline-none focus:border-japan-600">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">Nama Pemilik Rekening</label>
                            <input type="text" name="bank_account_holder" placeholder="Nama Sesuai Buku Tabungan" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-900 focus:outline-none focus:border-japan-600">
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full btn-red-primary py-3 rounded-2xl text-xs sm:text-sm font-black shadow-lg shadow-red-600/30 flex items-center justify-center gap-2">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Daftar & Dapatkan Link Referral</span>
                    </button>
                </div>
            </form>

        </div>

    </div>
</div>
@endsection
