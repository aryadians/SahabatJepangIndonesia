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
                    <option value="guru_bk">Guru BK / Koordinator BKK</option>
                    <option value="sekolah">Institusi Sekolah (SMK/SMA)</option>
                    <option value="alumni">Alumni LPK</option>
                    <option value="komunitas">Komunitas / Lembaga</option>
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
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Daftar Mitra Afiliasi & Kinerja Referral ({{ $affiliates->total() }})</h3>
                <p class="text-xs text-slate-400">Pantau jumlah pendaftar dan total komisi per mitra sekolah</p>
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
                                <div class="text-[11px] text-slate-400">{{ $a->institution_name ?: ucfirst($a->type) }} • {{ $a->phone }}</div>
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
                                    <button 
                                        type="button" 
                                        data-aff='@json($a)'
                                        onclick="openEditAffiliate(JSON.parse(this.getAttribute('data-aff')))" 
                                        class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1 transition"
                                    >
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </button>

                                    <form action="{{ route('admin.affiliates.destroy', $a->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data mitra {{ $a->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus">
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
                        <option value="guru_bk">Guru BK / BKK</option>
                        <option value="sekolah">Sekolah (SMK/SMA)</option>
                        <option value="alumni">Alumni</option>
                        <option value="komunitas">Komunitas</option>
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
</script>
@endsection
