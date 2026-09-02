@extends('admin.layouts.admin')

@section('title', 'WhatsApp Gateway & CRM Automation')
@section('page_title', 'Otomatisasi Notifikasi WhatsApp & CRM Follow-up')

@section('content')
<div class="space-y-8">
    
    <!-- Top KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="message-square" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Template CRM</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $templates->count() }} Template</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <i data-lucide="send" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Pesan Terkirim</p>
                <h3 class="text-2xl font-black text-blue-600 mt-0.5">{{ $totalLogs }} Pesan</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Leads Siap Follow Up</p>
                <h3 class="text-2xl font-black text-amber-600 mt-0.5">{{ $leads->count() }} Kontak</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Status Gateway</p>
                <h3 class="text-lg font-black text-emerald-600 mt-0.5 flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Direct API Ready</span>
                </h3>
            </div>
        </div>
    </div>

    <!-- 1-Click WhatsApp Quick Dispatch Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
        <div class="border-b border-slate-100 pb-3 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="send" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Kirim Pesan WhatsApp Langsung (1-Click Dispatch)</h3>
                <p class="text-xs text-slate-400">Pilih template pesan dan kontak siswa/leads untuk mengirim pesan otomatis</p>
            </div>
        </div>

        <form action="{{ route('admin.whatsapp.send') }}" method="POST" target="_blank" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @csrf

            <!-- Pilih Penerima Cepat -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Pilih Kontak Calon Siswa / Leads</label>
                <select id="quickSelectContact" onchange="handleContactSelect(this)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-600">
                    <option value="">-- Pilih dari Pendaftar Terbaru --</option>
                    @foreach($leads as $l)
                        <option value="lead_{{ $l->id }}" data-name="{{ $l->name }}" data-phone="{{ $l->phone }}" data-program="{{ $l->program }}" data-nis="-" data-sisa="0">
                            [Lead] {{ $l->name }} ({{ $l->phone }}) - {{ $l->program }}
                        </option>
                    @endforeach
                    @foreach($students as $s)
                        <option value="student_{{ $s->id }}" data-name="{{ $s->name }}" data-phone="{{ $s->phone }}" data-program="{{ $s->program }}" data-nis="{{ $s->nis }}" data-sisa="{{ number_format($s->remaining_balance) }}">
                            [Siswa] {{ $s->name }} ({{ $s->phone }}) - Sisa: Rp {{ number_format($s->remaining_balance) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nama & No WhatsApp Manual -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Nomor WhatsApp Tujuan *</label>
                <input type="text" name="phone" id="quickPhone" required placeholder="081234567890" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:border-emerald-600">
            </div>

            <!-- Pilih Template -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Gunakan Template Pesan</label>
                <select id="quickTemplateSelect" onchange="applyTemplate(this.value)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-600">
                    <option value="">-- Pilih Template --</option>
                    @foreach($templates as $t)
                        <option value="{{ $t->trigger_key }}" data-msg="{{ $t->message }}">
                            {{ $t->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="name" id="quickName" value="">
            <input type="hidden" name="template_key" id="quickTemplateKey" value="">

            <!-- Preview Pesan / Custom Pesan -->
            <div class="sm:col-span-3 space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Isi Pesan WhatsApp</label>
                <textarea name="custom_message" id="quickMessage" rows="4" required placeholder="Tuliskan pesan WhatsApp atau pilih template di atas..." class="w-full p-3.5 rounded-2xl border border-slate-200 text-xs leading-relaxed focus:outline-none focus:border-emerald-600 font-sans"></textarea>
            </div>

            <div class="sm:col-span-3 flex items-center justify-end gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/30 flex items-center gap-2 transition">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Kirim Pesan WhatsApp Langsung</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Template WhatsApp Manager -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i data-lucide="layout-template" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Kelola Template Pesan Otomatis (Merge Tags)</h3>
                    <p class="text-xs text-slate-400">Gunakan tag variabel: <code class="bg-slate-100 px-1 py-0.5 rounded text-blue-600 font-mono text-[11px]">{nama}</code>, <code class="bg-slate-100 px-1 py-0.5 rounded text-blue-600 font-mono text-[11px]">{program}</code>, <code class="bg-slate-100 px-1 py-0.5 rounded text-blue-600 font-mono text-[11px]">{nis}</code>, <code class="bg-slate-100 px-1 py-0.5 rounded text-blue-600 font-mono text-[11px]">{sisa_tanggungan}</code></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($templates as $t)
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $t->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                {{ $t->trigger_key }}
                            </span>
                            <button 
                                type="button" 
                                onclick="openEditTemplate({{ json_encode($t) }})" 
                                class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1"
                            >
                                <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                <span>Edit Template</span>
                            </button>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm">{{ $t->title }}</h4>
                        <div class="p-3 bg-white rounded-xl border border-slate-200 text-xs text-slate-700 whitespace-pre-line font-mono leading-relaxed">
                            {{ $t->message }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Pengiriman Pesan Log -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Riwayat Notifikasi WhatsApp CRM</h3>
                <p class="text-xs text-slate-400">Log pengiriman pesan otomatis dan follow-up pendaftar</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3.5 px-4">Waktu</th>
                        <th class="py-3.5 px-4">Penerima & Nomor WA</th>
                        <th class="py-3.5 px-4">Template / Tipe</th>
                        <th class="py-3.5 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 text-slate-400 font-mono text-xs">{{ $log->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $log->recipient_name }} ({{ $log->phone }})</td>
                            <td class="py-3.5 px-4 text-slate-600 font-mono text-xs">{{ $log->template_key ?? 'Direct Msg' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">Terkirim</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 text-xs">Belum ada riwayat pengiriman pesan WhatsApp.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Edit Template -->
<div id="editTemplateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 custom-modal">
    <div class="fixed inset-0 modal-backdrop-blur" onclick="closeModal('editTemplateModal')"></div>
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden modal-content-box z-10">
        
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-black text-white">Edit Template WhatsApp CRM</h3>
            </div>
            <button onclick="closeModal('editTemplateModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="editTemplateForm" method="POST" class="p-6 space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Judul Template *</label>
                <input type="text" name="title" id="editTplTitle" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 font-bold focus:outline-none focus:border-emerald-600">
            </div>

            <div class="space-y-1.5">
                <label class="block font-bold text-slate-700 uppercase">Isi Pesan Template *</label>
                <textarea name="message" id="editTplMessage" rows="6" required class="w-full p-3.5 rounded-xl border border-slate-200 font-mono leading-relaxed focus:outline-none focus:border-emerald-600"></textarea>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" id="editTplActive" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span class="text-xs font-bold text-slate-700">Template Aktif</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('editTemplateModal')" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md flex items-center gap-1.5">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Template</span>
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    let currentSelectedContact = null;

    function handleContactSelect(selectEl) {
        const opt = selectEl.options[selectEl.selectedIndex];
        if (!opt || !opt.value) {
            currentSelectedContact = null;
            return;
        }
        currentSelectedContact = {
            name: opt.getAttribute('data-name') || '',
            phone: opt.getAttribute('data-phone') || '',
            program: opt.getAttribute('data-program') || '',
            nis: opt.getAttribute('data-nis') || '-',
            sisa: opt.getAttribute('data-sisa') || '0',
        };
        document.getElementById('quickPhone').value = currentSelectedContact.phone;
        document.getElementById('quickName').value = currentSelectedContact.name;

        const tplSelect = document.getElementById('quickTemplateSelect');
        if (tplSelect && tplSelect.value) {
            applyTemplate(tplSelect.value);
        }
    }

    function applyTemplate(triggerKey) {
        const select = document.getElementById('quickTemplateSelect');
        const selectedOpt = select.options[select.selectedIndex];
        let msg = selectedOpt.getAttribute('data-msg') || '';

        document.getElementById('quickTemplateKey').value = triggerKey;

        if (currentSelectedContact && msg) {
            msg = msg.replace(/\{nama\}/g, currentSelectedContact.name || 'Kakak');
            msg = msg.replace(/\{program\}/g, currentSelectedContact.program || 'Tokutei Ginou SSW');
            msg = msg.replace(/\{nis\}/g, currentSelectedContact.nis || '-');
            msg = msg.replace(/\{sisa_tanggungan\}/g, currentSelectedContact.sisa || '0');
            msg = msg.replace(/\{link_brosur\}/g, "{{ url('/') }}#program");
        }

        document.getElementById('quickMessage').value = msg;
    }

    function openEditTemplate(tpl) {
        document.getElementById('editTplTitle').value = tpl.title;
        document.getElementById('editTplMessage').value = tpl.message;
        document.getElementById('editTplActive').checked = !!tpl.is_active;

        const form = document.getElementById('editTemplateForm');
        form.action = `/admin/whatsapp/templates/${tpl.id}`;

        openModal('editTemplateModal');
    }
</script>
@endsection
