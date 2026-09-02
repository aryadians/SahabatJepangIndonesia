@extends('admin.layouts.admin')

@section('title', 'Data Pengajar & Sensei')
@section('page_title', 'Manajemen Pengajar & Instruktur (Sensei)')

@section('content')
<div class="space-y-6">

    <!-- 1. Top KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Tenaga Pengajar</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ number_format($stats['total_teachers']) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Sensei Aktif Mengajar</p>
                <h3 class="text-2xl font-black text-emerald-600 mt-0.5">{{ number_format($stats['active_teachers']) }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Kualifikasi JLPT N1 / Native</p>
                <h3 class="text-2xl font-black text-japan-600 mt-0.5">{{ number_format($stats['n1_teachers']) }}</h3>
            </div>
        </div>

    </div>

    <!-- 2. Action & Filter Bar -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        <form action="{{ route('admin.teachers.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 flex-1">
            <div class="relative min-w-[220px] flex-1">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Cari NIP, Nama Sensei, Spesialisasi..." 
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"
                >
            </div>

            <select name="status" class="px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:border-japan-600">
                <option value="all">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="leave" {{ request('status') === 'leave' ? 'selected' : '' }}>Cuti</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                Filter
            </button>

            @if(request()->anyFilled(['q', 'status']))
                <a href="{{ route('admin.teachers.index') }}" class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
            @endif
        </form>

        <a 
            href="{{ route('admin.teachers.create') }}" 
            class="btn-red-primary px-4 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5 flex-shrink-0"
        >
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Sensei Baru</span>
        </a>

    </div>

    <!-- 3. Teachers Grid List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($teachers as $tc)
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-japan-600 transition group space-y-4">
                
                <div class="space-y-3">
                    
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                @if($tc->photo)
                                    <img src="{{ $tc->photo }}" alt="{{ $tc->name }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="user" class="w-6 h-6 text-slate-400"></i>
                                @endif
                            </div>
                            <div>
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-[10px] font-mono font-bold text-slate-600">
                                    {{ $tc->nip }}
                                </span>
                                <h3 class="font-black text-slate-900 text-sm mt-0.5">{{ $tc->name }}</h3>
                                <p class="text-xs font-bold text-japan-600 font-japanese">{{ $tc->romaji_name ?: '-' }}</p>
                            </div>
                        </div>

                        <div>
                            @if($tc->status === 'active')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Non-Aktif</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5 text-xs">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Sertifikasi Bahasa:</span>
                            <p class="font-black text-slate-900">{{ $tc->jlpt_level }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Bidang Pengajaran:</span>
                            <p class="font-semibold text-japan-700">{{ $tc->specialization }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Pengalaman Jepang:</span>
                            <p class="text-slate-600 text-[11px]">{{ $tc->japan_experience ?: 'Instruktur Domestik' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                        <span><i data-lucide="phone" class="w-3.5 h-3.5 inline text-slate-400 mr-1"></i>{{ $tc->phone ?: '-' }}</span>
                        <span><i data-lucide="calendar" class="w-3.5 h-3.5 inline text-slate-400 mr-1"></i>{{ $tc->join_date ? $tc->join_date->format('M Y') : '-' }}</span>
                    </div>

                </div>

                <!-- Footer Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-1.5">
                    <a 
                        href="{{ route('admin.teachers.edit', $tc->id) }}" 
                        class="px-3 py-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-1"
                    >
                        <i data-lucide="edit" class="w-3.5 h-3.5 text-slate-500"></i>
                        <span>Edit</span>
                    </a>

                    <form action="{{ route('admin.teachers.destroy', $tc->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data sensei {{ $tc->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="col-span-3 py-12 text-center text-slate-400">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400 mb-2">
                    <i data-lucide="user-check" class="w-6 h-6"></i>
                </div>
                <p class="font-bold text-slate-700">Belum ada data pengajar / sensei</p>
            </div>
        @endforelse
    </div>

    @if($teachers->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200">
            {{ $teachers->links() }}
        </div>
    @endif

</div>
@endsection
