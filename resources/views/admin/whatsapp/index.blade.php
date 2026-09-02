@extends('admin.layouts.admin')

@section('title', 'WhatsApp Gateway & CRM Automation')
@section('page_title', 'Otomatisasi Notifikasi WhatsApp (CRM Engine)')

@section('content')
<div class="space-y-8">
    
    <!-- KPI Summary Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="message-square" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Template CRM Aktif</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $templates->where('is_active', true)->count() }} Template</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <i data-lucide="send" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Pesan Terkirim (Log)</p>
                <h3 class="text-2xl font-black text-blue-600 mt-0.5">{{ $logs->total() }} Pesan</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <i data-lucide="zap" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Status Integrasi</p>
                <h3 class="text-base font-black text-emerald-600 mt-0.5 flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Direct WhatsApp Ready</span>
                </h3>
            </div>
        </div>

    </div>

    <!-- Quick Send & Direct Dispatch Box -->
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
                <select id="quickSelectContact" onchange="autoFillContact(this.value)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-600">
                    <option value="">-- Pilih dari Pendaftar Terbaru --</option>
                    @foreach($leads as $l)
                        <option value='@json(["name" => $l->name, "phone" => $l->phone, "program" => $l->program])'>
                            [Lead] {{ $l->name }} ({{ $l->phone }}) - {{ $l->program }}
                        </option>
                    @endforeach
                    @foreach($students as $s)
                        <option value='@json(["name" => $s->name, "phone" => $s->phone, "program" => $s->program, "nis" => $s->nis, "sisa" => number_format($s->remaining_balance)])'>
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

            <input type="hidden" name="name" id="quickName">
            <input type="hidden" name="template_key" id="quickTemplateKey">

            <!-- Pesan WhatsApp Body -->
            <div class="sm:col-span-3 space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Isi Pesan WhatsApp</label>
                <textarea name="message" id="quickMessage" rows="4" required placeholder="Tuliskan pesan WhatsApp atau pilih template di atas..." class="w-full p-4 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 font-mono"></textarea>
            </div>

            <div class="sm:col-span-3 flex items-center justify-end">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black shadow-md flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Buka & Kirim WhatsApp Sekarang</span>
                </button>
            </div>
        </form>
    </div>

    <!-- WhatsApp Templates Grid -->
    <div class="space-y-4">
        <div>
            <h3 class="font-extrabold text-slate-900 text-lg">Kelola Template Pesan CRM WhatsApp</h3>
            <p class="text-xs text-slate-500">Edit isi template pesan otomatis dan tag dinamis seperti <code>{nama}</code>, <code>{program}</code>, <code>{sisa_tanggungan}</code></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($templates as $tpl)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-200">
                                {{ $tpl->trigger_key }}
                            </span>
                            @if($tpl->is_active)
                                <span class="text-emerald-600 font-bold text-xs flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span>Aktif</span>
                                </span>
                            @else
                                <span class="text-slate-400 font-bold text-xs">Non-aktif</span>
                            @endif
                        </div>

                        <h4 class="font-extrabold text-slate-900 text-sm">{{ $tpl->title }}</h4>
                        
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-700 text-xs font-mono whitespace-pre-line leading-relaxed max-h-40 overflow-y-auto">
                            {{ $tpl->message }}
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                        <button 
                            type="button" 
                            data-tpl='@json($tpl)'
                            onclick="openEditTemplate(JSON.parse(this.getAttribute('data-tpl')))" 
                            class="px-4 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-1.5 transition"
                        >
                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                            <span>Edit Template</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- WhatsApp Logs Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Riwayat Pesan Terkirim (Logs)</h3>
                <p class="text-xs text-slate-400">Pencatatan aktivitas pesan WhatsApp ke siswa dan pendaftar</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] uppercase font-bold">
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Penerima</th>
                        <th class="py-3 px-4">No WhatsApp</th>
                        <th class="py-3 px-4">Jenis Template</th>
                        <th class="py-3 px-4">Isi Pesan Ringkas</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 text-slate-400 whitespace-nowrap">{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $log->recipient_name ?: '-' }}</td>
                            <td class="py-3 px-4 font-mono text-emerald-700">{{ $log->recipient_phone }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-bold text-[10px]">
                                    {{ $log->template_key }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600 line-clamp-1 max-w-xs">{{ $log->message_body }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">Terkirim</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">Belum ada riwayat pesan dikirim.</td>
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
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                </div>
                <h3 class="text-sm font-black text-white">Edit Template Pesan WhatsApp</h3>
            </div>
            <button onclick="closeModal('editTemplateModal')" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm">
                &times;
            </button>
        </div>

        <form id="editTemplateForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Judul Template *</label>
                <input type="text" name="title" id="editTplTitle" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-emerald-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700 uppercase">Isi Pesan WhatsApp *</label>
                <p class="text-[11px] text-slate-400">Gunakan tag: <code>{nama}</code>, <code>{program}</code>, <code>{nis}</code>, <code>{nominal}</code>, <code>{sisa_tanggungan}</code>, <code>{link_brosur}</code></p>
                <textarea name="message" id="editTplMessage" rows="7" required class="w-full p-3.5 rounded-xl border border-slate-200 text-xs font-mono focus:outline-none focus:border-emerald-600"></textarea>
            </div>

            <div class="flex items-center gap-2 pt-2">
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
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    let currentSelectedContact = null;

    function autoFillContact(rawJson) {
        if (!rawJson) return;
        const data = JSON.parse(rawJson);
        currentSelectedContact = data;
        document.getElementById('quickPhone').value = data.phone || '';
        document.getElementById('quickName').value = data.name || '';
        
        // Refresh message with merge tags if template selected
        const tplSelect = document.getElementById('quickTemplateSelect');
        if (tplSelect.value) {
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
