@extends('admin.layouts.admin')

@section('title', 'Dashboard Overview')
@section('page_title', 'Dashboard Ringkasan')

@section('content')
    <!-- KPI Summary Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendaftar</p>
                <div class="w-9 h-9 rounded-xl bg-red-50 text-japan-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-3xl sm:text-4xl font-black text-slate-900 mt-3">{{ $counts['leads_total'] }}</p>
            <a href="{{ route('admin.consultations.index') }}" class="text-xs font-bold text-japan-600 hover:text-japan-700 mt-2 inline-flex items-center gap-1">
                <span>Lihat Semua Data</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-amber-500 uppercase tracking-wider">Perlu Follow-up</p>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-3xl sm:text-4xl font-black text-amber-600 mt-3">{{ $counts['leads_pending'] }}</p>
            <span class="text-xs text-slate-500 mt-2">Pendaftar baru belum dihubungi</span>
        </div>

        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-blue-500 uppercase tracking-wider">Sedang Dihubungi</p>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-3xl sm:text-4xl font-black text-blue-600 mt-3">{{ $counts['leads_contacted'] }}</p>
            <span class="text-xs text-slate-500 mt-2">Dalam tahap konsultasi</span>
        </div>

        <div class="p-5 sm:p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Resmi Terdaftar</p>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-3xl sm:text-4xl font-black text-emerald-600 mt-3">{{ $counts['leads_registered'] }}</p>
            <span class="text-xs text-slate-500 mt-2">Siswa siap pelatihan</span>
        </div>

    </div>

    <!-- Quick Content CMS Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        
        <a href="{{ route('admin.programs.index') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-japan-400 transition flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-100 text-japan-700 flex items-center justify-center">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold">Program Karir</p>
                <p class="text-lg font-extrabold text-slate-900">{{ $counts['programs'] }} Program</p>
            </div>
        </a>

        <a href="{{ route('admin.facilities.index') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-japan-400 transition flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                <i data-lucide="building" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold">Fasilitas & Asrama</p>
                <p class="text-lg font-extrabold text-slate-900">{{ $counts['facilities'] }} Foto</p>
            </div>
        </a>

        <a href="{{ route('admin.testimonials.index') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-japan-400 transition flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                <i data-lucide="message-square" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold">Testimoni Alumni</p>
                <p class="text-lg font-extrabold text-slate-900">{{ $counts['testimonials'] }} Cerita</p>
            </div>
        </a>

        <a href="{{ route('admin.partners.index') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-japan-400 transition flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                <i data-lucide="handshake" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold">Mitra Kaisha</p>
                <p class="text-lg font-extrabold text-slate-900">{{ $counts['partners'] }} Mitra</p>
            </div>
        </a>

    </div>

    <!-- Latest 5 Leads Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Pendaftar Terbaru (5 Terakhir)</h3>
                <p class="text-xs text-slate-500">Calon siswa yang baru mengisi formulir konsultasi</p>
            </div>
            <a href="{{ route('admin.consultations.index') }}" class="btn-red-primary px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-1.5">
                <span>Kelola Semua Leads</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3 px-2">Nama</th>
                        <th class="py-3 px-2">WhatsApp</th>
                        <th class="py-3 px-2">Program</th>
                        <th class="py-3 px-2">Status</th>
                        <th class="py-3 px-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($latestLeads as $lead)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-2">
                                <span class="font-bold text-slate-900">{{ $lead->name }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $lead->city ?? 'Domisili -' }}</span>
                            </td>
                            <td class="py-3 px-2 font-medium">{{ $lead->phone }}</td>
                            <td class="py-3 px-2">
                                <span class="px-2 py-0.5 rounded-md bg-red-50 text-japan-700 font-semibold text-xs">
                                    {{ $lead->program }}
                                </span>
                            </td>
                            <td class="py-3 px-2">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold
                                    {{ $lead->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $lead->status === 'contacted' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $lead->status === 'registered' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $lead->status === 'cancelled' ? 'bg-slate-100 text-slate-600' : '' }}
                                ">
                                    {{ ucfirst($lead->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-2 text-right">
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $lead->phone);
                                    if (str_starts_with($cleanPhone, '0')) $cleanPhone = '62' . substr($cleanPhone, 1);
                                    $waMsg = urlencode("Halo Kak {$lead->name}, terima kasih telah mendaftar di LPK Sahabat Jepang Indonesia. Kami ingin mengonfirmasi konsultasi pilihan program Anda.");
                                @endphp
                                <a 
                                    href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text={{ $waMsg }}" 
                                    target="_blank" 
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-bold transition"
                                >
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                    <span>Chat</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400 text-xs">Belum ada data pendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
