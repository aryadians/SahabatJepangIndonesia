@extends('admin.layouts.admin')

@section('title', 'Kelola Testimoni Alumni')
@section('page_title', 'Kelola Testimoni & Kisah Sukses Alumni')

@section('content')
<div class="space-y-8">
    
    <!-- Add Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 max-w-4xl">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-red-50 text-japan-600 flex items-center justify-center font-bold">
                <i data-lucide="plus" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Tambah Testimoni Alumni Baru</h3>
                <p class="text-xs text-slate-400">Kisah nyata alumni yang telah sukses bekerja di Jepang</p>
            </div>
        </div>

        <form action="{{ route('admin.testimonials.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nama Alumni *</label>
                <input type="text" name="name" required placeholder="Ahmad Rizky Pratama" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kota Asal</label>
                <input type="text" name="origin" placeholder="Surabaya, Jawa Timur" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Prefektur / Kota di Jepang *</label>
                <input type="text" name="prefecture" required placeholder="Tokyo / 東京都" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Program *</label>
                <input type="text" name="program" required placeholder="Tokutei Ginou - Food Industry" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Perusahaan Penerima (Kaisha) *</label>
                <input type="text" name="company" required placeholder="Tokyo Foods Co., Ltd." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Penghasilan / Gaji *</label>
                <input type="text" name="salary" required placeholder="¥ 220.000 / bln (± Rp 23,5 Juta)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600 font-bold text-japan-700">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">URL Foto Avatar / Profil</label>
                <input type="text" name="avatar" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="space-y-1.5 sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kutipan / Cerita Pengalaman (Quote) *</label>
                <textarea name="quote" rows="3" required placeholder="Ceritakan bagaimana pengalaman belajar di LPK SJI dan kerja di Jepang..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Tag / Angkatan</label>
                <input type="text" name="tag" value="Alumni 2026" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-japan-600">
            </div>

            <div class="sm:col-span-2 pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="submit" class="btn-red-primary px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tambah Testimoni</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Testimonials List with Edit & Delete -->
    <div class="space-y-4">
        <h3 class="font-extrabold text-slate-900 text-base">Daftar Testimoni ({{ $testimonials->count() }})</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @forelse($testimonials as $testi)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ $testi->avatar }}" alt="{{ $testi->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-red-200">
                                <div>
                                    <h4 class="font-extrabold text-slate-900 text-sm">{{ $testi->name }}</h4>
                                    <p class="text-[11px] text-slate-400">{{ $testi->origin }} • {{ $testi->tag }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-red-50 text-japan-700 font-bold text-xs">
                                {{ $testi->prefecture }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-600 italic bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            "{{ $testi->quote }}"
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-800">{{ $testi->company }}</span>
                            <span class="text-[11px] text-japan-600 font-semibold block">{{ $testi->salary }}</span>
                        </div>

                        <div class="flex items-center gap-1.5">
                            <button 
                                type="button" 
                                data-testi='@json($testi)'
                                onclick="openEditTestimonial(JSON.parse(this.getAttribute('data-testi')))" 
                                class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1 transition"
                            >
                                <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                <span>Edit</span>
                            </button>

                            <form action="{{ route('admin.testimonials.destroy', $testi->id) }}" method="POST" onsubmit="return confirm('Hapus testimoni {{ $testi->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 rounded-lg text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">Belum ada testimoni.</div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Edit Testimoni -->
<div id="editTestimonialModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('editTestimonialModal')"></div>
    <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10 max-h-[90vh] flex flex-col">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-5 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-black text-white">Edit Data Testimoni Alumni</h3>
            </div>
            <button onclick="closeModal('editTestimonialModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="editTestimonialForm" method="POST" class="p-6 space-y-4 overflow-y-auto flex-1">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Nama Alumni *</label>
                    <input type="text" name="name" id="editTestiName" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kota Asal</label>
                    <input type="text" name="origin" id="editTestiOrigin" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Prefektur Jepang *</label>
                    <input type="text" name="prefecture" id="editTestiPrefecture" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Program *</label>
                    <input type="text" name="program" id="editTestiProgram" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Perusahaan (Kaisha) *</label>
                    <input type="text" name="company" id="editTestiCompany" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Gaji / Penghasilan *</label>
                    <input type="text" name="salary" id="editTestiSalary" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-japan-600 focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">URL Foto Avatar</label>
                    <input type="text" name="avatar" id="editTestiAvatar" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Tag / Angkatan</label>
                    <input type="text" name="tag" id="editTestiTag" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Kutipan Pengalaman (Quote) *</label>
                <textarea name="quote" id="editTestiQuote" rows="3" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-japan-600"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('editTestimonialModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
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
    function openEditTestimonial(testi) {
        document.getElementById('editTestiName').value = testi.name;
        document.getElementById('editTestiOrigin').value = testi.origin || '';
        document.getElementById('editTestiPrefecture').value = testi.prefecture;
        document.getElementById('editTestiProgram').value = testi.program;
        document.getElementById('editTestiCompany').value = testi.company;
        document.getElementById('editTestiSalary').value = testi.salary;
        document.getElementById('editTestiAvatar').value = testi.avatar || '';
        document.getElementById('editTestiTag').value = testi.tag || '';
        document.getElementById('editTestiQuote').value = testi.quote;

        const form = document.getElementById('editTestimonialForm');
        form.action = `/admin/testimonials/${testi.id}`;

        openModal('editTestimonialModal');
    }
</script>
@endsection
