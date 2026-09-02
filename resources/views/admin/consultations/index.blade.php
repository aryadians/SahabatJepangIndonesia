<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Leads - LPK Sahabat Jepang Indonesia</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Zen+Maru+Gothic:wght@500;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        japan: {
                            50: '#FEF2F2',
                            100: '#FEE2E2',
                            600: '#DC2626',
                            700: '#B91C1C',
                            800: '#991B1B',
                            900: '#7F1D1D',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        japanese: ['"Zen Maru Gothic"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Admin Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-japan-700 text-white flex items-center justify-center font-japanese font-black text-base shadow-sm">
                        友
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-slate-900 text-sm sm:text-base">LPK SAHABAT JEPANG INDONESIA</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-red-100 text-japan-700 uppercase">Admin Leads</span>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium">Panel Manajemen Calon Siswa & Konsultasi</p>
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-3">
                    <a 
                        href="{{ route('home') }}" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-200 text-slate-700 hover:text-japan-600 hover:bg-red-50 text-xs font-bold transition"
                    >
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        <span>Lihat Website Utama</span>
                    </a>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Admin Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
            </div>
        @endif

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
                <p class="text-[11px] text-slate-500 mt-1">Seluruh data masuk</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-amber-500 uppercase tracking-wider">Menunggu Follow-up</p>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-black text-amber-600 mt-2">{{ $stats['pending'] }}</p>
                <p class="text-[11px] text-slate-500 mt-1">Status: Pending</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-blue-500 uppercase tracking-wider">Sedang Dihubungi</p>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i data-lucide="message-square" class="w-4 h-4"></i>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-black text-blue-600 mt-2">{{ $stats['contacted'] }}</p>
                <p class="text-[11px] text-slate-500 mt-1">Status: Dihubungi</p>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Resmi Terdaftar</p>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="user-check" class="w-4 h-4"></i>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-2">{{ $stats['registered'] }}</p>
                <p class="text-[11px] text-slate-500 mt-1">Status: Terdaftar / Aktif</p>
            </div>

        </div>

        <!-- Filter & Search Box -->
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm">
            <form action="{{ route('admin.consultations.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                
                <!-- Search Input -->
                <div class="sm:col-span-5 space-y-1">
                    <label class="block text-xs font-bold text-slate-600 uppercase">Cari Nama / No HP / Kota</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Ketik nama atau nomor HP..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600"
                        >
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="sm:col-span-2 space-y-1">
                    <label class="block text-xs font-bold text-slate-600 uppercase">Status</label>
                    <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600 font-medium">
                        <option value="all">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Dihubungi</option>
                        <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Terdaftar</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Program Filter -->
                <div class="sm:col-span-3 space-y-1">
                    <label class="block text-xs font-bold text-slate-600 uppercase">Program</label>
                    <select name="program" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:border-japan-600 font-medium">
                        <option value="all">Semua Program</option>
                        <option value="Tokutei Ginou" {{ request('program') === 'Tokutei Ginou' ? 'selected' : '' }}>Tokutei Ginou (SSW)</option>
                        <option value="Magang" {{ request('program') === 'Magang' ? 'selected' : '' }}>Magang (Jisshusei)</option>
                        <option value="Kursus" {{ request('program') === 'Kursus' ? 'selected' : '' }}>Kursus Bahasa</option>
                        <option value="Engineer" {{ request('program') === 'Engineer' ? 'selected' : '' }}>Engineer</option>
                    </select>
                </div>

                <!-- Filter & Export Buttons -->
                <div class="sm:col-span-2 flex items-center gap-2">
                    <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center justify-center gap-1.5">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Filter</span>
                    </button>
                    
                    <a href="{{ route('admin.consultations.export') }}" class="py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center justify-center gap-1 shadow-sm" title="Export Excel / CSV">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>CSV</span>
                    </a>
                </div>

            </form>
        </div>

        <!-- Consultations Data Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] font-extrabold uppercase tracking-wider">
                            <th class="py-3.5 px-4">Calon Siswa</th>
                            <th class="py-3.5 px-4">Kontak WhatsApp</th>
                            <th class="py-3.5 px-4">Program Minat</th>
                            <th class="py-3.5 px-4">Kota Asal</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Tanggal Daftar</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs sm:text-sm">
                        @forelse($consultations as $item)
                            <tr class="hover:bg-slate-50/80 transition">
                                
                                <!-- Nama & Bio -->
                                <td class="py-3.5 px-4">
                                    <div class="font-extrabold text-slate-900">{{ $item->name }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $item->age ? $item->age . ' Thn' : '-' }} • {{ $item->education ?? 'Pendidikan -' }}
                                    </div>
                                    @if($item->message)
                                        <div class="mt-1 text-[11px] text-slate-500 bg-slate-50 p-1.5 rounded-lg border border-slate-100 max-w-xs">
                                            "{{ Str::limit($item->message, 60) }}"
                                        </div>
                                    @endif
                                </td>

                                <!-- Phone & 1-Click WhatsApp -->
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-800">{{ $item->phone }}</div>
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $item->phone);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        }
                                        $waMsg = urlencode("Halo Kak {$item->name}, kami dari Tim Konselor LPK Sahabat Jepang Indonesia. Kami telah menerima formulir pendaftaran Anda untuk program {$item->program}. Apakah saat ini ada waktu untuk berkonsultasi seputar persiapan dan jadwal kelas?");
                                        $waLink = "https://api.whatsapp.com/send?phone={$cleanPhone}&text={$waMsg}";
                                    @endphp
                                    <a 
                                        href="{{ $waLink }}" 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1 mt-1 text-[11px] font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-2 py-0.5 rounded-md transition"
                                    >
                                        <i data-lucide="message-circle" class="w-3 h-3"></i>
                                        <span>Chat WhatsApp</span>
                                    </a>
                                </td>

                                <!-- Program -->
                                <td class="py-3.5 px-4 font-semibold text-slate-800">
                                    <span class="inline-block px-2.5 py-1 rounded-lg bg-red-50 text-japan-700 text-xs font-bold">
                                        {{ $item->program }}
                                    </span>
                                </td>

                                <!-- Kota -->
                                <td class="py-3.5 px-4 text-slate-600">
                                    {{ $item->city ?? '-' }}
                                </td>

                                <!-- Status Badge & Inline Update Form -->
                                <td class="py-3.5 px-4">
                                    <form action="{{ route('admin.consultations.status', $item->id) }}" method="POST">
                                        @csrf
                                        <select 
                                            name="status" 
                                            onchange="this.form.submit()" 
                                            class="text-xs font-bold rounded-lg px-2.5 py-1 border cursor-pointer focus:outline-none transition
                                                {{ $item->status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                                {{ $item->status === 'contacted' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                                {{ $item->status === 'registered' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                                {{ $item->status === 'cancelled' ? 'bg-slate-100 text-slate-600 border-slate-200' : '' }}
                                            "
                                        >
                                            <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="contacted" {{ $item->status === 'contacted' ? 'selected' : '' }}>💬 Dihubungi</option>
                                            <option value="registered" {{ $item->status === 'registered' ? 'selected' : '' }}>✅ Terdaftar</option>
                                            <option value="cancelled" {{ $item->status === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                                        </select>
                                    </form>
                                </td>

                                <!-- Date -->
                                <td class="py-3.5 px-4 text-slate-500 text-xs">
                                    {{ $item->created_at->format('d M Y') }}
                                    <div class="text-[10px] text-slate-400">{{ $item->created_at->format('H:i') }} WIB</div>
                                </td>

                                <!-- Delete Action -->
                                <td class="py-3.5 px-4 text-right">
                                    <form action="{{ route('admin.consultations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <i data-lucide="inbox" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-bold text-slate-600 text-sm">Belum Ada Data Pendaftar</p>
                                    <p class="text-xs text-slate-400 mt-1">Data pendaftaran dari landing page akan otomatis muncul di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($consultations->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    {{ $consultations->links() }}
                </div>
            @endif

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-400">
        LPK Sahabat Jepang Indonesia &copy; 2026 • Admin Management Panel
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
