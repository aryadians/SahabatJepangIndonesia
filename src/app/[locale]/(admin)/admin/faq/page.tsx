'use client';

import { useState, useEffect } from 'react';
import { Plus, Trash2, Edit2, Save, X, Loader2, HelpCircle } from 'lucide-react';
import { showSuccess, showError, showConfirm } from '@/lib/swal';

export default function AdminFAQPage() {
  const [faqs, setFaqs] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [editingFaq, setEditingFaq] = useState<any>(null);
  const [isModalOpen, setIsOpen] = useState(false);

  useEffect(() => { fetchFaqs(); }, []);

  const fetchFaqs = async () => {
    try {
      const res = await fetch('/api/admin/faq');
      const data = await res.json();
      if (Array.isArray(data)) setFaqs(data);
    } finally { setLoading(false); }
  };

  const handleSave = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const res = await fetch('/api/admin/faq', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(editingFaq)
      });
      if (res.ok) {
        showSuccess("Berhasil", "FAQ telah diperbarui.");
        setIsOpen(false);
        fetchFaqs();
      }
    } catch (error) { showError("Gagal", "Terjadi kesalahan."); }
  };

  const handleDelete = async (id: string) => {
    const confirm = await showConfirm("Hapus FAQ?", "Data ini akan dihapus permanen.");
    if (confirm.isConfirmed) {
      await fetch(`/api/admin/faq?id=${id}`, { method: 'DELETE' });
      showSuccess("Terhapus", "FAQ telah dihapus.");
      fetchFaqs();
    }
  };

  return (
    <div className="space-y-10">
      <div className="flex justify-between items-end">
        <div>
          <h2 className="text-3xl font-black text-slate-900 tracking-tighter">Manajemen FAQ</h2>
          <p className="text-slate-500 font-medium">Kelola tanya jawab untuk calon siswa.</p>
        </div>
        <button 
          onClick={() => { setEditingFaq({ question: '', answer: '', order: 0 }); setIsOpen(true); }}
          className="px-8 py-4 bg-[var(--sji-blue)] text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-blue-700 transition-all flex items-center gap-2"
        >
          <Plus size={20} /> Tambah FAQ
        </button>
      </div>

      <div className="grid grid-cols-1 gap-4">
        {loading ? <Loader2 className="animate-spin mx-auto text-[var(--sji-blue)]" /> : faqs.map((faq) => (
          <div key={faq.id} className="bg-white p-8 rounded-[2.5rem] border border-slate-100 flex items-start justify-between group hover:shadow-md transition-all">
            <div className="flex gap-6">
              <div className="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:text-[var(--sji-blue)] transition-colors shrink-0">
                <HelpCircle size={24} />
              </div>
              <div className="space-y-2">
                <h4 className="font-bold text-slate-900 text-lg leading-tight">{faq.question}</h4>
                <p className="text-slate-500 text-sm leading-relaxed">{faq.answer}</p>
              </div>
            </div>
            <div className="flex gap-2">
              <button onClick={() => { setEditingFaq(faq); setIsOpen(true); }} className="p-3 bg-blue-50 text-[var(--sji-blue)] rounded-xl hover:bg-[var(--sji-blue)] hover:text-white transition-all"><Edit2 size={18} /></button>
              <button onClick={() => handleDelete(faq.id)} className="p-3 bg-red-50 text-[var(--sji-red)] rounded-xl hover:bg-[var(--sji-red)] hover:text-white transition-all"><Trash2 size={18} /></button>
            </div>
          </div>
        ))}
      </div>

      {isModalOpen && (
        <div className="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] flex items-center justify-center p-4">
          <form onSubmit={handleSave} className="bg-white rounded-[3rem] p-10 max-w-2xl w-full space-y-6 shadow-2xl relative">
            <button type="button" onClick={() => setIsOpen(false)} className="absolute top-8 right-8 text-slate-400 hover:text-slate-900"><X size={24} /></button>
            <h3 className="text-2xl font-black text-slate-900 tracking-tight">Edit FAQ</h3>
            <div className="space-y-4">
              <div className="space-y-2">
                <label className="text-xs font-black uppercase text-slate-400 ml-1">Pertanyaan</label>
                <input required type="text" className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all font-bold" value={editingFaq.question} onChange={e => setEditingFaq({...editingFaq, question: e.target.value})} />
              </div>
              <div className="space-y-2">
                <label className="text-xs font-black uppercase text-slate-400 ml-1">Jawaban</label>
                <textarea required rows={4} className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all font-bold resize-none" value={editingFaq.answer} onChange={e => setEditingFaq({...editingFaq, answer: e.target.value})} />
              </div>
            </div>
            <button type="submit" className="w-full py-4 bg-[var(--sji-blue)] text-white font-black rounded-2xl shadow-xl hover:bg-blue-700 transition-all">Simpan FAQ</button>
          </form>
        </div>
      )}
    </div>
  );
}
