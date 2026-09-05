@extends('admin.layouts.admin')

@section('title', 'Program Kemitraan & Referral Afiliasi')
@section('page_title', 'Manajemen Kemitraan Sekolah (BKK), Kampus & Afiliasi')

@section('content')
<div class="space-y-8">
    
    <!-- KPI Summary Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <i data-lucide="handshake" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Mitra Aktif</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalAffiliates }} Mitra</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Leads dari Referral</p>
                <h3 class="text-2xl font-black text-purple-600 mt-0.5">{{ $totalReferredLeads }} Pendaftar</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Siswa Masuk Kelas</p>
                <h3 class="text-2xl font-black text-emerald-600 mt-0.5">{{ $totalReferredStudents }} Siswa</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Halaman Pendaftaran</p>
                <a href="{{ route('affiliates.public.register') }}" target="_blank" class="text-xs font-black text-japan-600 hover:underline flex items-center gap-1 mt-1">
                    <span>Buka Link Publik</span>
                    <i data-lucide="external-link" class="w-3 h-3"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Add New Affiliate Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <i data-lucide="plus" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Tambah Mitra Afiliasi / BKK Sekolah Baru</h3>
                <p class="text-xs text-slate-400">Buat kode referral khusus untuk guru BK, sekolah mitra, atau alumni</p>
            </div>
        </div>

        <form action="{{ route('admin.affiliates.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            @csrf

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Nama Penanggung Jawab *</label>
                <input type="text" name="name" required placeholder="Contoh: Drs. Bambang Hariyanto" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Kode Referral Unik *</label>
                <input type="text" name="code" required placeholder="Contoh: SMKN1JKT" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600 font-mono font-bold uppercase">
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Kategori Mitra *</label>
                <select name="type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600 font-bold">
                    <option value="smk_bkk">SMK & Bursa Kerja Khusus (BKK)</option>
                    <option value="sekolah">Institusi Sekolah (SMK/SMA)</option>
                    <option value="kampus_poltekkes">Perguruan Tinggi / Poltekkes</option>
                    <option value="guru_bk">Guru BK / Koordinator BKK</option>
                    <option value="alumni">Ikatan Alumni Jepang</option>
                    <option value="komunitas">Komunitas & Umum</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Nama Sekolah / Lembaga</label>
                <input type="text" name="institution_name" placeholder="Contoh: SMK Negeri 1 Jakarta" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Nomor WhatsApp *</label>
                <input type="text" name="phone" required placeholder="081234567890" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Reward Komisi per Siswa (Rp) *</label>
                <input type="number" name="reward_per_lead" value="500000" step="50000" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase">Nama Bank</label>
                    <input type="text" name="bank_name" placeholder="BCA / Mandiri / BNI" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase">No Rekening</label>
                    <input type="text" name="bank_account_number" placeholder="1234567890" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase">Pemilik Rekening</label>
                    <input type="text" name="bank_account_holder" placeholder="Nama Pemilik" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="sm:col-span-2 flex items-center justify-between pt-3 border-t border-slate-100">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded text-japan-600 focus:ring-red-500">
                    <span class="text-xs font-bold text-slate-700">Mitra Aktif</span>
                </label>
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Simpan Mitra Baru</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Affiliates List Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Daftar Mitra Afiliasi & Kinerja Referral ({{ $affiliates->total() }})</h3>
                <p class="text-xs text-slate-400">Pantau jumlah pendaftar, status seleksi siswa, dan total komisi per mitra BKK/SMK</p>
            </div>
            <div class="flex items-center gap-2">
                <a 
                    href="{{ route('admin.affiliates.export.csv') }}" 
                    class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5"
                    title="Unduh format spreadsheet CSV"
                >
                    <i data-lucide="download" class="w-4 h-4 text-slate-600"></i>
                    <span>Export CSV</span>
                </a>
                <a 
                    href="{{ route('admin.affiliates.export.pdf') }}" 
                    target="_blank" 
                    class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs"
                    title="Cetak lembar rekapitulasi kemitraan resmi A4"
                >
                    <i data-lucide="printer" class="w-4 h-4 text-red-400"></i>
                    <span>Export PDF</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Nama Mitra & Instansi</th>
                        <th class="py-3.5 px-4">Kode Referral & Link</th>
                        <th class="py-3.5 px-4 text-center">Leads Mendaftar</th>
                        <th class="py-3.5 px-4 text-center">Siswa Masuk</th>
                        <th class="py-3.5 px-4">Reward / Siswa</th>
                        <th class="py-3.5 px-4">Total Komisi</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($affiliates as $a)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-extrabold text-slate-900">{{ $a->name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $a->institution_name ?: '-' }} • {{ $a->phone }}</div>
                                <div class="mt-1">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black border {{ $a->type_badge['bg'] }}">
                                        <i data-lucide="{{ $a->type_badge['icon'] }}" class="w-3 h-3"></i>
                                        <span>{{ $a->type_label }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-800 font-mono font-black text-xs">
                                        {{ $a->code }}
                                    </span>
                                    <button 
                                        type="button" 
                                        onclick="navigator.clipboard.writeText('{{ url('/?ref=' . $a->code) }}'); alert('Link referral disalin!');" 
                                        class="p-1 rounded text-blue-600 hover:bg-blue-50 transition" 
                                        title="Salin Link Referral"
                                    >
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-purple-700">
                                {{ $a->consultations_count }} Leads
                            </td>
                            <td class="py-3.5 px-4 text-center font-black text-emerald-700">
                                {{ $a->students_count }} Siswa
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-semibold font-mono">
                                Rp {{ number_format($a->reward_per_lead) }}
                            </td>
                            <td class="py-3.5 px-4 font-black text-emerald-600 font-mono">
                                Rp {{ number_format($a->total_reward_earned) }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Detail Siswa Rujukan -->
                                    <button 
                                        type="button" 
                                        onclick="openAffiliateStudentsModal({{ $a->id }})" 
                                        class="px-2.5 py-1 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs flex items-center gap-1 transition"
                                        title="Lihat Daftar Siswa Rujukan & Status Karir"
                                    >
                                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5"></i>
                                        <span>Siswa ({{ $a->students_count }})</span>
                                    </button>

                                    <!-- Kirim Sapaan WhatsApp -->
                                    <button 
                                        type="button" 
                                        onclick="openAffiliateWaModal({{ $a->id }}, '{{ addslashes($a->name) }}', '{{ $a->phone }}', '{{ addslashes($a->institution_name ?: $a->name) }}')" 
                                        class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold transition"
                                        title="Kirim Sapaan / Rekap WA via Fonnte"
                                    >
                                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                                    </button>

                                    <!-- Edit -->
                                    <button 
                                        type="button" 
                                        data-aff='@json($a)'
                                        onclick="openEditAffiliate(JSON.parse(this.getAttribute('data-aff')))" 
                                        class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1 transition"
                                    >
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Hapus -->
                                    <form action="{{ route('admin.affiliates.destroy', $a->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data mitra {{ $a->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs">Belum ada data mitra afiliasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($affiliates->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $affiliates->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Edit Affiliate -->
<div id="editAffiliateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('editAffiliateModal')"></div>
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-black text-white">Edit Data Mitra Afiliasi</h3>
            </div>
            <button onclick="closeModal('editAffiliateModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="editAffiliateForm" method="POST" class="p-6 space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Nama Lengkap *</label>
                <input type="text" name="name" id="editAffName" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 font-bold focus:outline-none focus:border-japan-600">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase">Kategori *</label>
                    <select name="type" id="editAffType" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 font-bold focus:outline-none focus:border-japan-600">
                        <option value="smk_bkk">SMK & Bursa Kerja Khusus (BKK)</option>
                        <option value="sekolah">Institusi Sekolah (SMK/SMA)</option>
                        <option value="kampus_poltekkes">Perguruan Tinggi / Poltekkes</option>
                        <option value="guru_bk">Guru BK / Koordinator BKK</option>
                        <option value="alumni">Ikatan Alumni Jepang</option>
                        <option value="komunitas">Komunitas & Umum</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase">WhatsApp *</label>
                    <input type="text" name="phone" id="editAffPhone" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Nama Sekolah / Lembaga</label>
                <input type="text" name="institution_name" id="editAffInst" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase">Email</label>
                    <input type="email" name="email" id="editAffEmail" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block font-bold text-slate-700 uppercase">Reward / Siswa (Rp)</label>
                    <input type="number" name="reward_per_lead" id="editAffReward" step="50000" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 font-bold focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" id="editAffActive" value="1" class="rounded text-japan-600 focus:ring-red-500">
                    <span class="text-xs font-bold text-slate-700">Mitra Aktif</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('editAffiliateModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md flex items-center gap-1.5">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Modal 2: Detail Siswa Referral SMK / BKK -->
<div id="affiliateStudentsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" onclick="closeAffiliateStudentsModal()"></div>
    <div class="relative w-full max-w-3xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden z-10 animate-in fade-in zoom-in-95 duration-200 flex flex-col max-h-[85vh]">
        <div class="bg-slate-900 text-white p-5 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 id="affModalTitle" class="text-sm sm:text-base font-black text-white">Siswa Rujukan SMK & BKK</h3>
                    <p id="affModalSubtitle" class="text-xs text-slate-400">Daftar siswa dan progres karir</p>
                </div>
            </div>
            <button onclick="closeAffiliateStudentsModal()" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="p-6 overflow-y-auto space-y-5 flex-1 text-xs">
            <!-- 3 Mini Stats -->
            <div class="grid grid-cols-3 gap-3">
                <div class="p-3.5 rounded-2xl bg-indigo-50/70 border border-indigo-100">
                    <p class="text-[10px] font-black uppercase text-indigo-700">Total Siswa</p>
                    <h4 id="affModalStatStudents" class="text-lg font-black text-indigo-950 mt-0.5">0</h4>
                </div>
                <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-100">
                    <p class="text-[10px] font-black uppercase text-emerald-700">Lolos Kaisha / Terbang</p>
                    <h4 id="affModalStatPassed" class="text-lg font-black text-emerald-950 mt-0.5">0</h4>
                </div>
                <div class="p-3.5 rounded-2xl bg-purple-50/70 border border-purple-100">
                    <p class="text-[10px] font-black uppercase text-purple-700">Total Komisi Mitra</p>
                    <h4 id="affModalStatReward" class="text-lg font-black text-purple-950 mt-0.5">Rp 0</h4>
                </div>
            </div>

            <!-- Table of Students -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[10px] uppercase font-black">
                            <th class="py-2.5 px-3">Nama Siswa</th>
                            <th class="py-2.5 px-3">Program</th>
                            <th class="py-2.5 px-3">Status Seleksi</th>
                            <th class="py-2.5 px-3">Tanggal Daftar</th>
                            <th class="py-2.5 px-3 text-right">Insentif</th>
                        </tr>
                    </thead>
                    <tbody id="affModalStudentTableBody" class="divide-y divide-slate-100">
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400 italic">Memuat data siswa...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Kirim Sapaan / Rekap WhatsApp ke BKK -->
<div id="affiliateWaModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" onclick="closeAffiliateWaModal()"></div>
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden z-10 animate-in fade-in zoom-in-95 duration-200">
        <div class="bg-emerald-600 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-white">Kirim Pesan WhatsApp ke BKK / Mitra</h3>
                    <p class="text-[10px] text-emerald-100 font-semibold">Integrasi Gateway Fonnte</p>
                </div>
            </div>
            <button onclick="closeAffiliateWaModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="affiliateWaForm" method="POST" class="p-6 space-y-4 text-xs">
            @csrf
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                <div class="flex justify-between">
                    <span class="text-slate-500">Penerima:</span>
                    <span id="waModalRecipient" class="font-bold text-slate-800">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Instansi / SMK:</span>
                    <span id="waModalInst" class="font-bold text-slate-800">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Nomor WhatsApp:</span>
                    <span id="waModalPhone" class="font-mono font-bold text-emerald-700">-</span>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Isi Pesan WhatsApp</label>
                <textarea 
                    name="message" 
                    id="waModalMessage" 
                    rows="5" 
                    required 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 font-sans focus:outline-none focus:border-emerald-600 leading-relaxed"
                ></textarea>
                <p class="text-[10px] text-slate-400">Pesan otomatis terformat dengan kode referral, link registrasi, dan rekap jumlah siswa.</p>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeAffiliateWaModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md flex items-center gap-1.5">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Kirim Pesan WhatsApp</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditAffiliate(a) {
        document.getElementById('editAffName').value = a.name;
        document.getElementById('editAffType').value = a.type;
        document.getElementById('editAffPhone').value = a.phone || '';
        document.getElementById('editAffInst').value = a.institution_name || '';
        document.getElementById('editAffEmail').value = a.email || '';
        document.getElementById('editAffReward').value = a.reward_per_lead || 500000;
        document.getElementById('editAffActive').checked = !!a.is_active;

        const form = document.getElementById('editAffiliateForm');
        form.action = `/admin/affiliates/${a.id}`;

        openModal('editAffiliateModal');
    }

    async function openAffiliateStudentsModal(id) {
        const modal = document.getElementById('affiliateStudentsModal');
        const tbody = document.getElementById('affModalStudentTableBody');
        modal.classList.remove('hidden');
        tbody.innerHTML = '<tr><td colspan="5" class="py-6 text-center text-slate-400 italic">Memuat data siswa rujukan...</td></tr>';

        try {
            const res = await fetch(`/admin/affiliates/${id}/students`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            if (data.success) {
                const aff = data.affiliate;
                const counts = data.counts;

                document.getElementById('affModalTitle').textContent = `Siswa Rujukan: ${aff.name}`;
                document.getElementById('affModalSubtitle').textContent = `${aff.institution_name || aff.type_label} • Kode: ${aff.code}`;
                document.getElementById('affModalStatStudents').textContent = `${counts.students} Siswa`;
                document.getElementById('affModalStatPassed').textContent = `${counts.passed} Siswa`;
                document.getElementById('affModalStatReward').textContent = 'Rp ' + Number(aff.total_reward_earned).toLocaleString('id-ID');

                if (data.students && data.students.length > 0) {
                    tbody.innerHTML = '';
                    data.students.forEach(s => {
                        const tr = document.createElement('tr');
                        tr.className = 'hover:bg-slate-50 transition';
                        tr.innerHTML = `
                            <td class="py-2.5 px-3">
                                <div class="font-bold text-slate-900">${s.name}</div>
                                <div class="text-[10px] text-slate-400 font-mono">NIS: ${s.nis}</div>
                            </td>
                            <td class="py-2.5 px-3 font-semibold text-slate-700">${s.program}</td>
                            <td class="py-2.5 px-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${
                                    s.status === 'passed_interview' || s.status === 'departed'
                                        ? 'bg-emerald-100 text-emerald-800'
                                        : (s.status === 'interview' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-700')
                                }">
                                    ${s.status_label}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-slate-500 font-mono">${s.date}</td>
                            <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-600">Rp ${Number(s.commission).toLocaleString('id-ID')}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="5" class="py-8 text-center text-slate-400 italic">Belum ada siswa rujukan yang mendaftar menggunakan kode referral ini.</td></tr>';
                }
            }
        } catch (err) {
            tbody.innerHTML = '<tr><td colspan="5" class="py-6 text-center text-rose-500">Gagal memuat data siswa.</td></tr>';
        }
        if (window.lucide) lucide.createIcons();
    }

    function closeAffiliateStudentsModal() {
        document.getElementById('affiliateStudentsModal').classList.add('hidden');
    }

    function openAffiliateWaModal(id, name, phone, institution) {
        const form = document.getElementById('affiliateWaForm');
        form.action = `/admin/affiliates/${id}/send-wa`;

        document.getElementById('waModalRecipient').textContent = name;
        document.getElementById('waModalInst').textContent = institution;
        document.getElementById('waModalPhone').textContent = phone;

        document.getElementById('waModalMessage').value = 
            `Konnichiwa, Bapak/Ibu ${name} (${institution}) 🌸\n\n` +
            `Salam hangat dari manajemen LPK Sahabat Jepang Indonesia.\n\n` +
            `Berikut kami informasikan pembaruan kemitraan dan program penyaluran alumni ke Jepang:\n` +
            `• Link pendaftaran rujukan: ${window.location.origin}/?ref=${id}\n` +
            `• Pelatihan intensif bahasa & budaya Jepang (SO Resmi Kemenaker RI)\n\n` +
            `Terima kasih atas kerjasama dan dedikasi baik Bapak/Ibu.`;

        document.getElementById('affiliateWaModal').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeAffiliateWaModal() {
        document.getElementById('affiliateWaModal').classList.add('hidden');
    }
</script>
@endsection
