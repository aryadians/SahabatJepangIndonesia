@extends('admin.layouts.admin')

@section('title', 'Kelola Program Karir')
@section('page_title', 'Kelola Program Karir ke Jepang')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-extrabold text-slate-900 text-lg">Daftar Program Karir Aktif</h3>
            <p class="text-xs text-slate-500">Program yang ditampilkan pada kartu katalog beranda</p>
        </div>
        <a href="{{ route('admin.programs.create') }}" class="btn-red-primary px-5 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Program Baru</span>
        </a>
    </div>

    <!-- Programs Grid Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Nama Program</th>
                        <th class="py-3.5 px-4">Bahasa Jepang</th>
                        <th class="py-3.5 px-4">Estimasi Gaji</th>
                        <th class="py-3.5 px-4">Badge</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($programs as $prog)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-extrabold text-slate-900">{{ $prog->title }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">{{ $prog->subtitle }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-japanese text-base font-bold text-japan-700">
                                {{ $prog->japanese_title ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900">{{ $prog->salary_yen }}</span>
                                <span class="block text-[11px] text-slate-500">{{ $prog->salary_idr }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $prog->badge_color }}">
                                    {{ $prog->badge }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($prog->is_active)
                                    <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-xs">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-bold text-xs">Non-aktif</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <a href="{{ route('admin.programs.edit', $prog->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('admin.programs.destroy', $prog->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">Belum ada program karir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
