@extends('admin.layouts.admin')

@section('title', 'Jadwal Gelombang Kelas & Kuota')
@section('page_title', 'Kelola Jadwal Angkatan Kelas & Kuota Kursi')

@section('content')
<div class="space-y-8">
    
    <!-- Add Schedule Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="plus" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Buka Gelombang / Angkatan Kelas Baru</h3>
                <p class="text-xs text-slate-400">Jadwal pembukaan kelas pelatihan persiapan kerja ke Jepang</p>
            </div>
        </div>

        <form action="{{ route('admin.schedules.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @csrf
            
            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Angkatan / Gelombang *</label>
                <input type="text" name="batch_name" required placeholder="Contoh: Angkatan 45 - Tokutei Ginou Kaigo Intensif" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Jenis Program *</label>
                <select name="program_type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                    <option value="Tokutei Ginou (SSW)">Tokutei Ginou (SSW)</option>
                    <option value="Ginou Jisshusei (Magang)">Ginou Jisshusei (Magang)</option>
                    <option value="Kursus Bahasa Jepang">Kursus Bahasa Jepang</option>
                    <option value="Engineer & Profesional">Engineer & Profesional</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Estimasi Periode Terbang</label>
                <input type="text" name="target_departure" placeholder="Contoh: April - Mei 2027" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Batas Akhir Pendaftaran *</label>
                <input type="date" name="registration_deadline" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Tanggal Mulai Masuk Kelas *</label>
                <input type="date" name="start_date" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Total Kuota *</label>
                    <input type="number" name="quota" value="25" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Sisa Kursi *</label>
                    <input type="number" name="remaining_seats" value="5" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-japan-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Status Pendaftaran *</label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-semibold">
                    <option value="open">Pendaftaran Dibuka (Open)</option>
                    <option value="limited">Kuota Terbatas (Limited)</option>
                    <option value="closed">Pendaftaran Ditutup (Closed)</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Urutan Tampil (Order)</label>
                <input type="number" name="order" value="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="sm:col-span-2 pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Buka Angkatan Baru</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Schedules Table List with Edit & Delete -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Daftar Gelombang Kelas Aktif ({{ $schedules->count() }})</h3>
                <p class="text-xs text-slate-500">Jadwal ini ditampilkan pada bagian jadwal & kuota pendaftaran di website</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Nama Angkatan & Program</th>
                        <th class="py-3.5 px-4">Mulai Belajar</th>
                        <th class="py-3.5 px-4">Batas Daftar</th>
                        <th class="py-3.5 px-4">Target Terbang</th>
                        <th class="py-3.5 px-4">Sisa Kuota</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($schedules as $sch)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <h4 class="font-black text-slate-900">{{ $sch->batch_name }}</h4>
                                <span class="text-xs font-bold text-japan-600">{{ $sch->program_type }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                {{ $sch->start_date ? $sch->start_date->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-rose-600">
                                {{ $sch->registration_deadline ? $sch->registration_deadline->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $sch->target_departure ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-black {{ $sch->remaining_seats <= 3 ? 'text-rose-600' : 'text-emerald-600' }}">
                                    {{ $sch->remaining_seats }}
                                </span> / {{ $sch->quota }} Kursi
                            </td>
                            <td class="py-3.5 px-4">
                                @if($sch->status === 'open')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Dibuka</span>
                                @elseif($sch->status === 'limited')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Sisa Sedikit</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">Ditutup</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button 
                                        type="button" 
                                        data-schedule='@json($sch)'
                                        data-start="{{ $sch->start_date ? $sch->start_date->format('Y-m-d') : '' }}"
                                        data-deadline="{{ $sch->registration_deadline ? $sch->registration_deadline->format('Y-m-d') : '' }}"
                                        onclick="openEditSchedule(JSON.parse(this.getAttribute('data-schedule')), this.getAttribute('data-start'), this.getAttribute('data-deadline'))" 
                                        class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1 transition"
                                    >
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </button>

                                    <form action="{{ route('admin.schedules.destroy', $sch->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal gelombang {{ $sch->batch_name }}?')">
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
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs">Belum ada jadwal angkatan kelas yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Edit Jadwal Angkatan -->
<div id="editScheduleModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('editScheduleModal')"></div>
    <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10 max-h-[90vh] flex flex-col">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-5 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-black text-white">Edit Jadwal Angkatan & Kuota</h3>
            </div>
            <button onclick="closeModal('editScheduleModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="editScheduleForm" method="POST" class="p-6 space-y-4 overflow-y-auto flex-1">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Angkatan / Gelombang *</label>
                <input type="text" name="batch_name" id="editSchBatchName" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-japan-600">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Jenis Program *</label>
                    <select name="program_type" id="editSchProgramType" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-japan-600">
                        <option value="Tokutei Ginou (SSW)">Tokutei Ginou (SSW)</option>
                        <option value="Ginou Jisshusei (Magang)">Ginou Jisshusei (Magang)</option>
                        <option value="Kursus Bahasa Jepang">Kursus Bahasa Jepang</option>
                        <option value="Engineer & Profesional">Engineer & Profesional</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Estimasi Terbang</label>
                    <input type="text" name="target_departure" id="editSchDeparture" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Batas Akhir Daftar *</label>
                    <input type="date" name="registration_deadline" id="editSchDeadline" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Mulai Belajar *</label>
                    <input type="date" name="start_date" id="editSchStartDate" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Total Kuota *</label>
                    <input type="number" name="quota" id="editSchQuota" required min="1" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Sisa Kursi *</label>
                    <input type="number" name="remaining_seats" id="editSchSeats" required min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-japan-600 focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Urutan</label>
                    <input type="number" name="order" id="editSchOrder" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Status Pendaftaran *</label>
                <select name="status" id="editSchStatus" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-japan-600">
                    <option value="open">Pendaftaran Dibuka (Open)</option>
                    <option value="limited">Kuota Terbatas (Limited)</option>
                    <option value="closed">Pendaftaran Ditutup (Closed)</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('editScheduleModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
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
    function openEditSchedule(sch, startDate, deadline) {
        document.getElementById('editSchBatchName').value = sch.batch_name;
        document.getElementById('editSchProgramType').value = sch.program_type;
        document.getElementById('editSchDeparture').value = sch.target_departure || '';
        document.getElementById('editSchDeadline').value = deadline || '';
        document.getElementById('editSchStartDate').value = startDate || '';
        document.getElementById('editSchQuota').value = sch.quota;
        document.getElementById('editSchSeats').value = sch.remaining_seats;
        document.getElementById('editSchStatus').value = sch.status;
        document.getElementById('editSchOrder').value = sch.order || 0;

        const form = document.getElementById('editScheduleForm');
        form.action = `/admin/schedules/${sch.id}`;

        openModal('editScheduleModal');
    }
</script>
@endsection
