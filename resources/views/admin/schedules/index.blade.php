@extends('admin.layouts.admin')

@section('title', 'Jadwal Gelombang Kelas & Kuota')
@section('page_title', 'Kelola Jadwal Angkatan Kelas & Kuota Kursi')

@section('content')
<div class="space-y-8">
    
    <!-- Add Schedule Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="calendar-plus" class="w-5 h-5 text-japan-600"></i>
            <h3 class="font-extrabold text-slate-900 text-base">Buka Gelombang / Angkatan Kelas Baru</h3>
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

            <div class="flex items-end justify-end">
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Buka Angkatan Baru</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Schedules Table List -->
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
                                {{ $sch->start_date->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-rose-600">
                                {{ $sch->registration_deadline->format('d M Y') }}
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
                                <form action="{{ route('admin.schedules.destroy', $sch->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal gelombang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
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
@endsection
