@extends('admin.layouts.admin')

@section('title', 'Manajemen Leads Pendaftar')
@section('page_title', 'Data Leads Calon Siswa & Konsultasi')

@section('content')
<div class="space-y-6">

    <!-- KPI Metrics Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendaftar</p>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">{{ $stats['total'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Keseluruhan calon siswa</p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-amber-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Perlu Dihubungi</p>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-amber-600 mt-2">{{ $stats['pending'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Status: Pending</p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-blue-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Sudah Dikontak</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-blue-600 mt-2">{{ $stats['contacted'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Tahap konsultasi berjalan</p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-emerald-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Resmi Mendaftar</p>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-2">{{ $stats['registered'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Masuk kelas pelatihan</p>
        </div>

    </div>

    <!-- Search, Filter & Export Bar -->
    <div class="p-4 sm:p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
        
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
            
            <!-- Search & Filters Form -->
            <form action="{{ route('admin.consultations.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
                
                <div class="relative flex-1 min-w-[200px]">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama, WhatsApp, kota..." 
                        class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"
                    >
                </div>

                <select name="status" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 focus:outline-none focus:border-japan-600">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Registered</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <select name="program" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 focus:outline-none focus:border-japan-600">
                    <option value="all" {{ request('program') === 'all' ? 'selected' : '' }}>Semua Program</option>
                    <option value="Tokutei Ginou" {{ request('program') === 'Tokutei Ginou' ? 'selected' : '' }}>Tokutei Ginou (SSW)</option>
                    <option value="Magang" {{ request('program') === 'Magang' ? 'selected' : '' }}>Ginou Jisshusei (Magang)</option>
                    <option value="Kursus" {{ request('program') === 'Kursus' ? 'selected' : '' }}>Kursus Bahasa Jepang</option>
                    <option value="Engineer" {{ request('program') === 'Engineer' ? 'selected' : '' }}>Engineer / Profesional</option>
                </select>

                <button type="submit" class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold shadow-sm">
                    Filter
                </button>

                @if(request()->hasAny(['search', 'status', 'program']))
                    <a href="{{ route('admin.consultations.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition">
                        Reset
                    </a>
                @endif

            </form>

            <!-- Export to Excel/CSV -->
            <a 
                href="{{ route('admin.consultations.export') }}" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-emerald-300 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold transition shadow-sm"
            >
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                <span>Export Data (Excel/CSV)</span>
            </a>

        </div>

    </div>

    <!-- Leads Data Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Calon Siswa</th>
                        <th class="py-3.5 px-4">Kontak WhatsApp</th>
                        <th class="py-3.5 px-4">Program Minat</th>
                        <th class="py-3.5 px-4">Profil & Asal</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Tanggal Daftar</th>
                        <th class="py-3.5 px-4 text-right">Aksi & Follow-Up</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($consultations as $lead)
                        <tr class="hover:bg-slate-50 transition">
                            
                            <!-- Calon Siswa -->
                            <td class="py-3.5 px-4">
                                <div class="font-extrabold text-slate-900">{{ $lead->name }}</div>
                                @if($lead->admin_notes)
                                    <div class="text-[11px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md mt-1 inline-block line-clamp-1 max-w-xs">
                                        📝 {{ $lead->admin_notes }}
                                    </div>
                                @endif
                            </td>

                            <!-- WhatsApp -->
                            <td class="py-3.5 px-4">
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $lead->phone);
                                    if(str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    }
                                @endphp
                                <a 
                                    href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text=Halo%20kak%20{{ urlencode($lead->name) }},%20kami%20dari%20LPK%20Sahabat%20Jepang%20Indonesia.%20Terima%20kasih%20telah%20mendaftar%20konsultasi%20program%20{{ urlencode($lead->program) }}." 
                                    target="_blank" 
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold text-xs transition"
                                >
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                    <span>{{ $lead->phone }}</span>
                                </a>
                            </td>

                            <!-- Program -->
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-japan-700 border border-red-100">
                                    {{ $lead->program }}
                                </span>
                            </td>

                            <!-- Profil & Asal -->
                            <td class="py-3.5 px-4 text-xs text-slate-600">
                                <div class="font-semibold">{{ $lead->age ? $lead->age . ' Th' : '-' }} • {{ $lead->education ?? '-' }}</div>
                                <div class="text-slate-400 text-[11px]">{{ $lead->city ?? 'Kota belum diisi' }}</div>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-3.5 px-4">
                                @if($lead->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-800">Pending</span>
                                @elseif($lead->status === 'contacted')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-blue-100 text-blue-800">Contacted</span>
                                @elseif($lead->status === 'registered')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800">Registered</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-slate-100 text-slate-600">{{ ucfirst($lead->status) }}</span>
                                @endif
                            </td>

                            <!-- Tanggal -->
                            <td class="py-3.5 px-4 text-xs text-slate-500">
                                {{ $lead->created_at->format('d M Y') }}
                                <div class="text-[10px] text-slate-400">{{ $lead->created_at->format('H:i') }} WIB</div>
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-4 text-right space-x-1.5">
                                
                                <!-- Detail & Follow-up Modal Trigger -->
                                <button 
                                    type="button" 
                                    onclick="openLeadDetail({{ json_encode($lead) }})" 
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition"
                                >
                                    <i data-lucide="eye" class="w-3.5 h-3.5 text-slate-500"></i>
                                    <span>Detail</span>
                                </button>

                                <form action="{{ route('admin.consultations.destroy', $lead->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pendaftar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus Data">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400 mb-2">
                                    <i data-lucide="inbox" class="w-6 h-6"></i>
                                </div>
                                <p class="font-bold text-slate-700">Belum ada data pendaftar</p>
                                <p class="text-xs">Data dari form pendaftaran landing page akan tampil di sini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($consultations->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $consultations->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Lead Detail & Follow-Up Modal -->
<div id="leadDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('leadDetailModal')"></div>
    <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10 flex flex-col max-h-[90vh]">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 id="modalLeadName" class="text-base font-black text-white">Detail Calon Siswa</h3>
                    <p id="modalLeadTime" class="text-xs text-slate-400">Pendaftaran Online</p>
                </div>
            </div>
            <button onclick="closeModal('leadDetailModal')" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                &times;
            </button>
        </div>

        <div class="p-6 overflow-y-auto space-y-5 flex-1">
            
            <!-- Lead Profile Grid -->
            <div class="grid grid-cols-2 gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Nomor WhatsApp</p>
                    <p id="modalLeadPhone" class="font-black text-slate-900 mt-0.5">-</p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Program Minat</p>
                    <p id="modalLeadProgram" class="font-black text-japan-700 mt-0.5">-</p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Usia & Pendidikan</p>
                    <p id="modalLeadProfile" class="font-bold text-slate-800 mt-0.5">-</p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Domisili Kota</p>
                    <p id="modalLeadCity" class="font-bold text-slate-800 mt-0.5">-</p>
                </div>
                <div class="col-span-2 pt-2 border-t border-slate-200/60">
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Pesan Pendaftar</p>
                    <p id="modalLeadMessage" class="text-slate-700 italic mt-0.5">Tidak ada pesan tambahan.</p>
                </div>
            </div>

            <!-- WhatsApp Template Quick Actions -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">⚡ 1-Click WhatsApp Quick Follow-Up</label>
                <div class="grid grid-cols-1 gap-2">
                    <button type="button" onclick="sendQuickWa(1)" class="p-2.5 rounded-xl border border-emerald-200 hover:bg-emerald-50 text-left transition flex items-center justify-between text-xs text-emerald-800 font-bold">
                        <span>💬 Sapaan Awal & Penjelasan Alur</span>
                        <i data-lucide="send" class="w-3.5 h-3.5 text-emerald-600"></i>
                    </button>
                    <button type="button" onclick="sendQuickWa(2)" class="p-2.5 rounded-xl border border-blue-200 hover:bg-blue-50 text-left transition flex items-center justify-between text-xs text-blue-800 font-bold">
                        <span>📋 Info Syarat Berkas & Jadwal Kelas</span>
                        <i data-lucide="send" class="w-3.5 h-3.5 text-blue-600"></i>
                    </button>
                </div>
            </div>

            <!-- Update Status & Notes Form -->
            <form id="leadUpdateForm" method="POST" class="space-y-4 pt-2 border-t border-slate-100">
                @csrf
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Update Status Pendaftar</label>
                    <select name="status" id="modalLeadStatus" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:border-japan-600">
                        <option value="pending">Pending (Belum dihubungi)</option>
                        <option value="contacted">Contacted (Dalam proses follow-up)</option>
                        <option value="registered">Registered (Resmi masuk kelas)</option>
                        <option value="cancelled">Cancelled (Batal / Tidak berminat)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Catatan Internal Konselor / Admin</label>
                    <textarea name="admin_notes" id="modalLeadNotes" rows="3" placeholder="Tuliskan catatan follow-up (contoh: sudah ditelepon tgl 2 Sept, mau ikut tes seleksi minggu depan)..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('leadDetailModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
                        Tutup
                    </button>
                    <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Catatan & Status</span>
                    </button>
                </div>
            </form>

        </div>

    </div>
</div>

<script>
    let currentLeadData = null;

    function openLeadDetail(lead) {
        currentLeadData = lead;
        
        document.getElementById('modalLeadName').textContent = lead.name;
        document.getElementById('modalLeadTime').textContent = `Terdaftar: ${lead.created_at}`;
        document.getElementById('modalLeadPhone').textContent = lead.phone;
        document.getElementById('modalLeadProgram').textContent = lead.program;
        document.getElementById('modalLeadProfile').textContent = `${lead.age ? lead.age + ' Tahun' : '-'} • ${lead.education || '-'}`;
        document.getElementById('modalLeadCity').textContent = lead.city || 'Belum diisi';
        document.getElementById('modalLeadMessage').textContent = lead.message || 'Tidak ada pesan tambahan.';
        document.getElementById('modalLeadStatus').value = lead.status;
        document.getElementById('modalLeadNotes').value = lead.admin_notes || '';

        // Form action url
        const form = document.getElementById('leadUpdateForm');
        form.action = `/admin/leads/${lead.id}/status`;

        openModal('leadDetailModal');
    }

    function sendQuickWa(templateNum) {
        if (!currentLeadData) return;

        let cleanPhone = currentLeadData.phone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }

        let msg = '';
        if (templateNum === 1) {
            msg = `Halo Kak ${currentLeadData.name}, salam dari LPK Sahabat Jepang Indonesia (友好日本インドネシア) 🌸\n\nTerima kasih telah mendaftar formulir konsultasi karir program *${currentLeadData.program}*.\n\nApakah saat ini Kak ${currentLeadData.name} ada waktu untuk konsultasi singkat mengenai jadwal kelas dan persiapan seleksi ke Jepang?`;
        } else {
            msg = `Halo Kak ${currentLeadData.name}, berikut kami kirimkan informasi lengkap persyaratan dokumen, estimasi biaya, dan jadwal pembukaan angkatan baru program *${currentLeadData.program}* di LPK Sahabat Jepang Indonesia.\n\nSilakan dipelajari dan kabari kami jika ada hal yang ingin ditanyakan ya Kak.`;
        }

        const waUrl = `https://api.whatsapp.com/send?phone=${cleanPhone}&text=${encodeURIComponent(msg)}`;
        window.open(waUrl, '_blank');
    }
</script>
@endsection
