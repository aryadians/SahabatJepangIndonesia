@extends('admin.layouts.admin')

@section('title', 'Dashboard Overview')
@section('page_title', 'Dashboard Ringkasan Eksekutif')

@section('content')
<div class="space-y-6">

    <!-- 1. Executive Welcome Banner -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="space-y-2 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/20 text-red-400 text-xs font-bold border border-red-500/30">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                <span>LPK Sahabat Jepang Indonesia • Portal Administrator</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                Selamat Datang, {{ auth()->user()->name ?? 'Administrator' }}! 👋
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 max-w-xl">
                Pantau perkembangan pendaftar calon siswa, status pelatihan, keberangkatan ke Jepang, serta pengelolaan administrasi keuangan lembaga secara terpadu.
            </p>
        </div>

        <div class="flex items-center gap-3 relative z-10 flex-shrink-0">
            <a 
                href="{{ route('admin.students.create') }}" 
                class="btn-red-primary px-5 py-2.5 rounded-xl text-xs font-bold shadow-lg flex items-center gap-1.5"
            >
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>+ Siswa Baru</span>
            </a>
            <a 
                href="{{ route('home') }}" 
                target="_blank" 
                class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition flex items-center gap-1.5"
            >
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Lihat Web</span>
            </a>
        </div>
    </div>

    <!-- 2. Primary KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Siswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center font-bold">
                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Siswa Terdata</p>
                <h3 data-admin-stat="students_total" class="text-2xl font-black text-slate-900 mt-0.5">{{ number_format($counts['students']) }}</h3>
                <a href="{{ route('admin.students.index') }}" class="text-[11px] font-bold text-japan-600 hover:underline">Kelola Data &rarr;</a>
            </div>
        </div>

        <!-- Siswa Aktif Belajar -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Aktif Belajar / Wawancara</p>
                <h3 data-admin-stat="students_active" class="text-2xl font-black text-blue-600 mt-0.5">{{ number_format($counts['students_active']) }}</h3>
                <span class="text-[11px] text-slate-400">Tahap persiapan</span>
            </div>
        </div>

        <!-- Sudah di Jepang -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="plane" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Sudah Berada di Jepang</p>
                <h3 data-admin-stat="students_departed" class="text-2xl font-black text-emerald-600 mt-0.5">{{ number_format($counts['students_departed']) }}</h3>
                <span class="text-[11px] text-slate-400">Resmi bekerja</span>
            </div>
        </div>

        <!-- Sisa Tanggungan / Piutang -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Sisa Tanggungan Biaya</p>
                <h3 data-admin-stat="receivables" class="text-base sm:text-lg font-black text-amber-600 mt-0.5">Rp {{ number_format($counts['receivables'], 0, ',', '.') }}</h3>
                <span class="text-[11px] text-slate-400">Belum lunas</span>
            </div>
        </div>

    </div>

    <!-- 3. Secondary Metrics (Leads & Academics) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Leads Pendaftar</p>
                <h4 data-admin-stat="leads_total" data-suffix=" Orang" class="text-xl font-black text-slate-900 mt-0.5">{{ $counts['leads_total'] }} Orang</h4>
            </div>
            <a href="{{ route('admin.consultations.index') }}" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200" title="Buka Leads">
                <i data-lucide="users" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-amber-500 uppercase">Perlu Dihubungi</p>
                <h4 data-admin-stat="leads_pending" data-suffix=" Leads" class="text-xl font-black text-amber-600 mt-0.5">{{ $counts['leads_pending'] }} Leads</h4>
            </div>
            <span class="w-3 h-3 rounded-full bg-amber-500 animate-ping"></span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Tenaga Pengajar</p>
                <h4 class="text-xl font-black text-slate-900 mt-0.5">{{ $counts['teachers'] }} Sensei</h4>
            </div>
            <a href="{{ route('admin.teachers.index') }}" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200" title="Kelola Pengajar">
                <i data-lucide="user-check" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase">Jadwal Angkatan</p>
                <h4 class="text-xl font-black text-slate-900 mt-0.5">{{ $counts['schedules'] }} Gelombang</h4>
            </div>
            <a href="{{ route('admin.schedules.index') }}" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200" title="Kelola Jadwal">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </a>
        </div>

    </div>

    <!-- 4. Side-by-Side Live Data Tables (Students + Leads) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Tabel 1: Siswa Terbaru Terdaftar -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                        <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm">Siswa Terbaru Terdaftar</h3>
                        <p class="text-[11px] text-slate-400">5 siswa pendaftaran terbaru</p>
                    </div>
                </div>
                <a href="{{ route('admin.students.index') }}" class="text-xs font-bold text-japan-600 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase font-bold border-b border-slate-100">
                            <th class="py-2">Siswa</th>
                            <th class="py-2">Program</th>
                            <th class="py-2">Status Biaya</th>
                            <th class="py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($latestStudents as $st)
                            <tr class="hover:bg-slate-50/80">
                                <td class="py-2.5">
                                    <p class="font-bold text-slate-900 leading-tight">{{ $st->name }}</p>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $st->nis }}</span>
                                </td>
                                <td class="py-2.5">
                                    <span class="text-[11px] font-semibold text-slate-700">{{ $st->program }}</span>
                                </td>
                                <td class="py-2.5">
                                    @if($st->remaining_balance > 0)
                                        <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold text-[10px]">
                                            Sisa: {{ $st->formatted_remaining_balance }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold text-[10px]">
                                            Lunas
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2.5 text-right">
                                    <a href="{{ route('admin.students.edit', $st->id) }}" class="p-1 rounded-lg text-blue-600 hover:bg-blue-50 inline-block" title="Edit">
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 text-xs">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel 2: Leads Pendaftar Konsultasi Terbaru -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <i data-lucide="message-square" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm">Leads Konsultasi Masuk</h3>
                        <p class="text-[11px] text-slate-400">5 pendaftar via website terbaru</p>
                    </div>
                </div>
                <a href="{{ route('admin.consultations.index') }}" class="text-xs font-bold text-japan-600 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase font-bold border-b border-slate-100">
                            <th class="py-2">Pendaftar</th>
                            <th class="py-2">Program Minat</th>
                            <th class="py-2">Status</th>
                            <th class="py-2 text-right">Hubungi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($latestLeads as $lead)
                            <tr class="hover:bg-slate-50/80">
                                <td class="py-2.5">
                                    <p class="font-bold text-slate-900 leading-tight">{{ $lead->name }}</p>
                                    <span class="text-[10px] text-slate-400">{{ $lead->phone }}</span>
                                </td>
                                <td class="py-2.5">
                                    <span class="text-[11px] font-semibold text-slate-700">{{ $lead->program }}</span>
                                </td>
                                <td class="py-2.5">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                        {{ $lead->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $lead->status === 'contacted' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $lead->status === 'registered' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $lead->status === 'cancelled' ? 'bg-slate-100 text-slate-600' : '' }}
                                    ">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </td>
                                <td class="py-2.5 text-right">
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $lead->phone);
                                        if (str_starts_with($cleanPhone, '0')) $cleanPhone = '62' . substr($cleanPhone, 1);
                                        $waMsg = urlencode("Halo Kak {$lead->name}, terima kasih telah mendaftar di LPK Sahabat Jepang Indonesia. Kami ingin mengonfirmasi konsultasi pilihan program {$lead->program}.");
                                    @endphp
                                    <a 
                                        href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text={{ $waMsg }}" 
                                        target="_blank" 
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold text-[11px] transition"
                                    >
                                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                        <span>WA</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 text-xs">Belum ada leads masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- 5. Quick CMS Navigation Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        
        <a href="{{ route('admin.programs.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-red-50 text-japan-600 group-hover:bg-japan-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="briefcase" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Program Karir</p>
            <span class="text-[10px] text-slate-400">{{ $counts['programs'] }} Program</span>
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Jadwal Kelas</p>
            <span class="text-[10px] text-slate-400">{{ $counts['schedules'] }} Angkatan</span>
        </a>

        <a href="{{ route('admin.facilities.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="building" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Fasilitas</p>
            <span class="text-[10px] text-slate-400">{{ $counts['facilities'] }} Foto</span>
        </a>

        <a href="{{ route('admin.testimonials.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="message-square" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Testimoni</p>
            <span class="text-[10px] text-slate-400">{{ $counts['testimonials'] }} Cerita</span>
        </a>

        <a href="{{ route('admin.articles.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="newspaper" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Artikel Blog</p>
            <span class="text-[10px] text-slate-400">{{ $counts['articles'] }} Post</span>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-japan-600 transition flex flex-col items-center text-center group">
            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 group-hover:bg-slate-900 group-hover:text-white flex items-center justify-center transition">
                <i data-lucide="sliders" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-bold text-slate-900 mt-2">Logo & Hero</p>
            <span class="text-[10px] text-slate-400">Pengaturan</span>
        </a>

    </div>

</div>
@endsection
