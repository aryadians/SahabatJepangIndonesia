@extends('admin.layouts.admin')

@section('title', 'Manajemen Leads Pendaftar')
@section('page_title', 'Data Leads Calon Siswa & Konsultasi')

@section('content')
<div class="space-y-6">

    <!-- Live Influx Alert (Shown dynamically when a new lead enters) -->
    <div id="newLeadAlertBanner" class="hidden p-4 rounded-2xl bg-gradient-to-r from-red-600 via-japan-600 to-rose-700 text-white shadow-xl flex items-center justify-between animate-pulse">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                <i data-lucide="sparkles" class="w-5 h-5 text-amber-200"></i>
            </div>
            <div>
                <h5 class="text-xs font-bold leading-tight">Pendaftar Baru Baru Saja Masuk!</h5>
                <p class="text-[11px] text-red-100">Data calon siswa baru telah tercatat dan siap untuk dihubungi.</p>
            </div>
        </div>
        <button onclick="window.location.reload()" class="px-4 py-2 rounded-xl bg-white text-slate-900 font-extrabold text-xs hover:bg-red-50 transition shadow-md flex items-center gap-1.5">
            <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
            <span>Muat Ulang Halaman</span>
        </button>
    </div>

    <!-- KPI Metrics Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs hover:border-slate-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pendaftar</p>
                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="leads_total" class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">{{ number_format($stats['total']) }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Keseluruhan calon siswa</p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-amber-200 shadow-xs hover:border-amber-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">Perlu Dihubungi</p>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="leads_pending" id="kpiPendingCount" class="text-2xl sm:text-3xl font-black text-amber-600 mt-2">{{ number_format($stats['pending']) }}</p>
            <p class="text-[11px] text-amber-700/80 mt-0.5 font-medium">Status: Pending</p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-blue-200 shadow-xs hover:border-blue-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Sudah Dikontak</p>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="leads_contacted" class="text-2xl sm:text-3xl font-black text-blue-600 mt-2">{{ number_format($stats['contacted']) }}</p>
            <p class="text-[11px] text-blue-700/80 mt-0.5 font-medium">Tahap konsultasi berjalan</p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-emerald-200 shadow-xs hover:border-emerald-300 transition">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Resmi Mendaftar</p>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
            </div>
            <p data-admin-stat="leads_registered" class="text-2xl sm:text-3xl font-black text-emerald-600 mt-2">{{ number_format($stats['registered']) }}</p>
            <p class="text-[11px] text-emerald-700/80 mt-0.5 font-medium">Masuk kelas pelatihan</p>
        </div>

    </div>

    <!-- Search, Filter & Export Bar -->
    <div class="p-5 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-4">
        
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3.5">
            
            <!-- Search & Filters Form -->
            <form action="{{ route('admin.consultations.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 flex-1">
                
                <div class="relative flex-1 min-w-[220px]">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama, nomor WhatsApp, kota..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium focus:outline-none focus:border-japan-600 bg-slate-50 focus:bg-white transition"
                    >
                </div>

                <select name="status" class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:outline-none focus:border-japan-600 bg-slate-50 focus:bg-white transition">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                    <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>🔵 Contacted</option>
                    <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>🟢 Registered</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>⚪ Cancelled</option>
                </select>

                <select name="program" class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:outline-none focus:border-japan-600 bg-slate-50 focus:bg-white transition">
                    <option value="all" {{ request('program') === 'all' ? 'selected' : '' }}>Semua Program</option>
                    <option value="SMILE Project" {{ request('program') === 'SMILE Project' ? 'selected' : '' }}>★ SMILE Project (Khusus Poltekkes MoU)</option>
                    <option value="SMK Go Japan" {{ request('program') === 'SMK Go Japan' ? 'selected' : '' }}>★ SMK Go Japan (Vokasi SMK)</option>
                    <option value="Tokutei Ginou" {{ request('program') === 'Tokutei Ginou' ? 'selected' : '' }}>Tokutei Ginou (SSW)</option>
                    <option value="Magang" {{ request('program') === 'Magang' ? 'selected' : '' }}>Ginou Jisshusei (Magang)</option>
                    <option value="Kursus" {{ request('program') === 'Kursus' ? 'selected' : '' }}>Kursus Bahasa Jepang</option>
                    <option value="Engineer" {{ request('program') === 'Engineer' ? 'selected' : '' }}>Engineer / Profesional</option>
                </select>

                <button type="submit" class="btn-red-primary px-4 py-2.5 rounded-xl text-xs font-bold shadow-xs flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['search', 'status', 'program']))
                    <a href="{{ route('admin.consultations.index') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">
                        Reset
                    </a>
                @endif

            </form>

            <!-- Export to Excel/CSV -->
            <a 
                href="{{ route('admin.consultations.export') }}" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-emerald-200 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold transition shadow-xs whitespace-nowrap"
            >
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                <span>Export Excel / CSV</span>
            </a>

        </div>

    </div>

    <!-- Leads Data Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-black tracking-wider">
                        <th class="py-4 px-4">Calon Siswa</th>
                        <th class="py-4 px-4">Program Minat</th>
                        <th class="py-4 px-4">Profil & Asal</th>
                        <th class="py-4 px-4">Ubah Status Cepat</th>
                        <th class="py-4 px-4">Tanggal Masuk</th>
                        <th class="py-4 px-4 text-center">Aksi & Follow-Up</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($consultations as $lead)
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $lead->phone);
                            if(str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                            $waText = urlencode("Halo {$lead->name}, terima kasih telah mendaftar formulir konsultasi karir program {$lead->program} di LPK Sahabat Jepang Indonesia. Ada yang bisa kami bantu?");
                        @endphp
                        <tr id="leadRow-{{ $lead->id }}" class="hover:bg-slate-50/80 transition">
                            
                            <!-- Calon Siswa -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 font-black text-xs flex items-center justify-center flex-shrink-0 border border-slate-200">
                                        {{ strtoupper(substr($lead->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <button 
                                            type="button" 
                                            data-lead='@json($lead)'
                                            onclick="openLeadDetail(JSON.parse(this.getAttribute('data-lead')))" 
                                            class="font-black text-slate-900 hover:text-japan-600 transition text-left text-xs truncate block"
                                            title="Klik untuk melihat detail pendaftar"
                                        >
                                            {{ $lead->name }}
                                        </button>
                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" class="text-[11px] font-mono text-emerald-600 hover:underline flex items-center gap-1 mt-0.5">
                                            <i data-lucide="phone" class="w-3 h-3"></i>
                                            <span>{{ $lead->phone }}</span>
                                        </a>
                                        @if($lead->admin_notes)
                                            <div class="text-[10px] text-amber-800 bg-amber-50 border border-amber-200/60 px-2 py-0.5 rounded-md mt-1 inline-block truncate max-w-xs">
                                                📝 {{ $lead->admin_notes }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Program Minat -->
                            <td class="py-3.5 px-4">
                                @if(str_contains(strtolower($lead->program), 'smile'))
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200 inline-block shadow-2xs">
                                        ★ {{ $lead->program }}
                                    </span>
                                @elseif(str_contains(strtolower($lead->program), 'smk'))
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-blue-50 text-blue-800 border border-blue-200 inline-block shadow-2xs">
                                        ★ {{ $lead->program }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-50 text-japan-700 border border-red-100 inline-block">
                                        {{ $lead->program }}
                                    </span>
                                @endif
                            </td>

                            <!-- Profil & Asal -->
                            <td class="py-3.5 px-4 text-xs text-slate-600">
                                <p class="font-bold text-slate-800">{{ $lead->age ? $lead->age . ' Th' : '-' }} • {{ $lead->education ?? '-' }}</p>
                                <p class="text-slate-400 text-[11px] mt-0.5">{{ $lead->city ?? 'Belum diisi' }}</p>
                            </td>

                            <!-- Ubah Status Cepat (Button / Dropdown Selector) -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <select 
                                        data-lead-id="{{ $lead->id }}"
                                        onchange="changeLeadStatusAjax({{ $lead->id }}, this.value, this)" 
                                        class="text-[11px] font-black px-3 py-1.5 rounded-xl border cursor-pointer focus:outline-none transition shadow-2xs {{ $lead->status === 'pending' ? 'bg-amber-50 text-amber-800 border-amber-300' : ($lead->status === 'contacted' ? 'bg-blue-50 text-blue-800 border-blue-300' : ($lead->status === 'registered' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-slate-100 text-slate-700 border-slate-300')) }}"
                                        title="Klik untuk langsung mengubah status calon siswa"
                                    >
                                        <option value="pending" {{ $lead->status === 'pending' ? 'selected' : '' }}>🟡 Pending (Baru)</option>
                                        <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>🔵 Contacted (Dikontak)</option>
                                        <option value="registered" {{ $lead->status === 'registered' ? 'selected' : '' }}>🟢 Registered (Masuk)</option>
                                        <option value="cancelled" {{ $lead->status === 'cancelled' ? 'selected' : '' }}>⚪ Cancelled (Batal)</option>
                                    </select>
                                    <span id="statusSpinner-{{ $lead->id }}" class="hidden">
                                        <svg class="animate-spin h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                    </span>
                                </div>
                            </td>

                            <!-- Tanggal Masuk -->
                            <td class="py-3.5 px-4 text-xs text-slate-500 whitespace-nowrap">
                                <p class="font-semibold text-slate-800">{{ $lead->created_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-slate-400">{{ $lead->created_at->format('H:i') }} WIB</p>
                            </td>

                            <!-- Aksi & Follow-Up Buttons -->
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-center">
                                    
                                    <!-- Direct WhatsApp Chat -->
                                    <a 
                                        href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" 
                                        target="_blank" 
                                        class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold transition flex items-center gap-1 shadow-2xs"
                                        title="Chat WhatsApp Calon Siswa"
                                    >
                                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                        <span>Chat WA</span>
                                    </a>

                                    <!-- Detail Modal Button -->
                                    <button 
                                        type="button" 
                                        data-lead='@json($lead)'
                                        onclick="openLeadDetail(JSON.parse(this.getAttribute('data-lead')))" 
                                        class="p-1.5 rounded-lg text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 transition shadow-2xs"
                                        title="Lihat Detail & Catatan Follow Up"
                                    >
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.consultations.destroy', $lead->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pendaftar {{ $lead->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition shadow-2xs" title="Hapus Data">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400 mb-2">
                                    <i data-lucide="inbox" class="w-6 h-6"></i>
                                </div>
                                <p class="font-bold text-slate-700 text-sm">Belum ada data pendaftar</p>
                                <p class="text-xs text-slate-400 mt-0.5">Pendaftaran dari landing page akan otomatis tersinkronisasi di sini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($consultations->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/60">
                {{ $consultations->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Lead Detail & Follow-Up Modal -->
<div id="leadDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('leadDetailModal')"></div>
    <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10 flex flex-col max-h-[90vh]">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-5 px-6 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-japan-600 text-white flex items-center justify-center font-bold shadow-xs">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 id="modalLeadName" class="text-base font-black text-white leading-tight">Detail Calon Siswa</h3>
                    <p id="modalLeadTime" class="text-[11px] text-slate-300 font-mono mt-0.5">Pendaftaran Online</p>
                </div>
            </div>
            <button onclick="closeModal('leadDetailModal')" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                &times;
            </button>
        </div>

        <div class="p-6 overflow-y-auto space-y-5 flex-1 bg-slate-50/50">
            
            <!-- Lead Profile Grid -->
            <div class="grid grid-cols-2 gap-3 p-4 rounded-2xl bg-white border border-slate-200 text-xs shadow-2xs">
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Nomor WhatsApp</p>
                    <p id="modalLeadPhone" class="font-black text-slate-900 mt-0.5 text-sm">-</p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Program Minat</p>
                    <p id="modalLeadProgram" class="font-black text-japan-700 mt-0.5 text-sm">-</p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Usia & Pendidikan</p>
                    <p id="modalLeadProfile" class="font-bold text-slate-800 mt-0.5">-</p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Domisili Kota</p>
                    <p id="modalLeadCity" class="font-bold text-slate-800 mt-0.5">-</p>
                </div>
                <div class="col-span-2 pt-2.5 border-t border-slate-100">
                    <p class="text-slate-400 font-bold uppercase text-[10px]">Pesan / Pertanyaan Calon Siswa</p>
                    <p id="modalLeadMessage" class="text-slate-700 italic mt-0.5 font-medium">Tidak ada pesan tambahan.</p>
                </div>
            </div>

            <!-- WhatsApp Template Quick Actions -->
            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">⚡ 1-Click WhatsApp Quick Follow-Up</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <button type="button" onclick="sendQuickWa(1)" class="p-2.5 rounded-xl border border-emerald-200 bg-emerald-50/60 hover:bg-emerald-100/80 text-left transition flex items-center justify-between text-xs text-emerald-900 font-bold">
                        <span>💬 Sapaan & Penjelasan Alur</span>
                        <i data-lucide="send" class="w-3.5 h-3.5 text-emerald-600"></i>
                    </button>
                    <button type="button" onclick="sendQuickWa(2)" class="p-2.5 rounded-xl border border-blue-200 bg-blue-50/60 hover:bg-blue-100/80 text-left transition flex items-center justify-between text-xs text-blue-900 font-bold">
                        <span>📋 Info Syarat & Jadwal Kelas</span>
                        <i data-lucide="send" class="w-3.5 h-3.5 text-blue-600"></i>
                    </button>
                </div>
            </div>

            <!-- Update Status & Notes Form -->
            <form id="leadUpdateForm" method="POST" class="space-y-4 pt-4 border-t border-slate-200">
                @csrf
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Ubah Status Calon Siswa</label>
                    <select name="status" id="modalLeadStatus" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:border-japan-600 bg-white">
                        <option value="pending">🟡 Pending (Belum dihubungi)</option>
                        <option value="contacted">🔵 Contacted (Dalam proses follow-up)</option>
                        <option value="registered">🟢 Registered (Resmi masuk kelas)</option>
                        <option value="cancelled">⚪ Cancelled (Batal / Tidak berminat)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Catatan Internal Konselor / Admin</label>
                    <textarea name="admin_notes" id="modalLeadNotes" rows="3" placeholder="Tuliskan catatan follow-up (contoh: sudah ditelepon tgl 3 Sept, berminat program Kaigo gelombang 44)..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600 bg-white"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('leadDetailModal')" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Batal
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

    // Open Lead Detail Modal
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
        if (window.lucide) lucide.createIcons();
    }

    // Quick Change Status via AJAX
    function changeLeadStatusAjax(leadId, newStatus, selectElement) {
        const spinner = document.getElementById(`statusSpinner-${leadId}`);
        if (spinner) spinner.classList.remove('hidden');

        fetch(`/admin/leads/${leadId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(res => res.json())
        .then(data => {
            if (spinner) spinner.classList.add('hidden');

            if (data.success) {
                // Update select element colors
                selectElement.className = 'text-[11px] font-black px-3 py-1.5 rounded-xl border cursor-pointer focus:outline-none transition shadow-2xs';
                if (newStatus === 'pending') {
                    selectElement.classList.add('bg-amber-50', 'text-amber-800', 'border-amber-300');
                } else if (newStatus === 'contacted') {
                    selectElement.classList.add('bg-blue-50', 'text-blue-800', 'border-blue-300');
                } else if (newStatus === 'registered') {
                    selectElement.classList.add('bg-emerald-50', 'text-emerald-800', 'border-emerald-300');
                } else {
                    selectElement.classList.add('bg-slate-100', 'text-slate-700', 'border-slate-300');
                }

                // Sync mini dashboard immediately
                if (data.stats && window.updateAdminStatsDom) {
                    window.updateAdminStatsDom({ leads_kpi: data.stats });
                }

                // Show subtle toast
                showMiniToast(data.message);
            } else {
                alert('Gagal memperbarui status pendaftar.');
            }
        })
        .catch(err => {
            if (spinner) spinner.classList.add('hidden');
            console.error(err);
            alert('Terjadi kesalahan koneksi saat mengubah status.');
        });
    }

    // Mini Toast Helper
    function showMiniToast(msg) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-slate-900 text-white px-5 py-2.5 rounded-2xl shadow-xl text-xs font-bold border border-slate-700 flex items-center gap-2 animate-bounce';
        toast.innerHTML = `
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
            <span>${msg}</span>
        `;
        document.body.appendChild(toast);
        if (window.lucide) lucide.createIcons();

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.4s';
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    }

    // Send Quick WhatsApp Message
    function sendQuickWa(templateNum) {
        if (!currentLeadData) return;

        let cleanPhone = currentLeadData.phone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }

        let msg = '';
        if (templateNum === 1) {
            msg = `Halo Kak ${currentLeadData.name}, salam dari LPK Sahabat Jepang Indonesia (友好日本インドネシア) 🌸\n\nTerima kasih telah mendaftar formulir konsultasi karir program *${currentLeadData.program}*.\n\nApakah saat ini Kak ${currentLeadData.name} ada waktu untuk konsultasi singkat mengenai alur persiapan dan seleksi ke Jepang?`;
        } else {
            msg = `Halo Kak ${currentLeadData.name}, berikut kami kirimkan informasi lengkap persyaratan berkas, estimasi biaya, dan jadwal pembukaan angkatan baru program *${currentLeadData.program}* di LPK Sahabat Jepang Indonesia.\n\nSilakan dipelajari dan kabari kami jika ada hal yang ingin ditanyakan ya Kak.`;
        }

        const waUrl = `https://api.whatsapp.com/send?phone=${cleanPhone}&text=${encodeURIComponent(msg)}`;
        window.open(waUrl, '_blank');
    }
</script>
@endsection
