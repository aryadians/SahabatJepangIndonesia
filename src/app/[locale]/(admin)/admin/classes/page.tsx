'use client';

import { useState, useEffect } from 'react';
import { Plus, Trash2, Edit2, Save, X, Loader2, BookOpen, Star } from 'lucide-react';
import { showSuccess, showError, showConfirm } from '@/lib/swal';

export default function AdminClassesPage() {
  const [classes, setClasses] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [editingClass, setEditingClass] = useState<any>(null);
  const [isModalOpen, setIsOpen] = useState(false);

  useEffect(() => { fetchClasses(); }, []);

  const fetchClasses = async () => {
    try {
      const res = await fetch('/api/admin/classes');
      const data = await res.json();
      if (Array.isArray(data)) setClasses(data);
    } finally { setLoading(false); }
  };

  const handleSave = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const res = await fetch('/api/admin/classes', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(editingClass)
      });
      if (res.ok) {
        showSuccess("Berhasil", "Kelas telah diperbarui.");
        setIsOpen(false);
        fetchClasses();
      }
    } catch (error) { showError("Gagal", "Terjadi kesalahan."); }
  };

  const handleDelete = async (id: string) => {
    const confirm = await showConfirm("Hapus Kelas?", "Data ini akan dihapus permanen.");
    if (confirm.isConfirmed) {
      await fetch(`/api/admin/classes?id=${id}`, { method: 'DELETE' });
      showSuccess("Terhapus", "Kelas telah dihapus.");
      fetchClasses();
    }
  };

  return (
    <div className="space-y-10">
      <div className="flex justify-between items-end">
        <div>
          <h2 className="text-3xl font-black text-slate-900 tracking-tighter">Manajemen Daftar Kelas</h2>
          <p className="text-slate-500 font-medium">Kelola daftar kelas, biaya, dan durasi pelatihan.</p>
        </div>
        <button 
          onClick={() => { setEditingClass({ title: '', category: 'SSW', price: '', duration: '', features: '', isPopular: false }); setIsOpen(true); }}
          className="px-8 py-4 bg-[var(--sji-blue)] text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-blue-700 transition-all flex items-center gap-2"
        >
          <Plus size={20} /> Tambah Kelas
        </button>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {loading ? <div className="col-span-full"><Loader2 className="animate-spin mx-auto text-[var(--sji-blue)]" /></div> : classes.map((c) => (
          <div key={c.id} className="bg-white p-8 rounded-[3rem] border border-slate-100 flex items-start justify-between group hover:shadow-md transition-all relative overflow-hidden">
            {c.isPopular && <div className="absolute top-4 right-[-30px] bg-[var(--sji-red)] text-white text-[8px] font-black uppercase tracking-widest py-1 px-10 rotate-45 shadow-lg">Popular</div>}
            <div className="flex gap-6">
              <div className="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-[var(--sji-blue)] transition-colors shrink-0">
                <BookOpen size={28} />
              </div>
              <div className="space-y-2">
                <span className="text-[10px] font-black uppercase text-[var(--sji-red)] tracking-widest bg-red-50 px-2 py-0.5 rounded">{c.category}</span>
                <h4 className="font-bold text-slate-900 text-xl leading-tight">{c.title}</h4>
                <div className="flex gap-4 text-xs font-bold text-slate-400">
                  <span className="text-slate-900">{c.price}</span>
                  <span>•</span>
                  <span>{c.duration}</span>
                </div>
              </div>
            </div>
            <div className="flex gap-2 relative z-10">
              <button onClick={() => { setEditingClass(c); setIsOpen(true); }} className="p-3 bg-blue-50 text-[var(--sji-blue)] rounded-xl hover:bg-[var(--sji-blue)] hover:text-white transition-all"><Edit2 size={18} /></button>
              <button onClick={() => handleDelete(c.id)} className="p-3 bg-red-50 text-[var(--sji-red)] rounded-xl hover:bg-[var(--sji-red)] hover:text-white transition-all"><Trash2 size={18} /></button>
            </div>
          </div>
        ))}
      </div>

      {isModalOpen && (
        <div className="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] flex items-center justify-center p-4">
          <form onSubmit={handleSave} className="bg-white rounded-[3rem] p-10 max-w-2xl w-full space-y-6 shadow-2xl relative max-h-[90vh] overflow-y-auto">
            <button type="button" onClick={() => setIsOpen(false)} className="absolute top-8 right-8 text-slate-400 hover:text-slate-900"><X size={24} /></button>
            <h3 className="text-2xl font-black text-slate-900 tracking-tight">Setup Kelas</h3>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div className="space-y-2">
                <label className="text-xs font-black uppercase text-slate-400 ml-1">Nama Kelas</label>
                <input required type="text" className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all font-bold" value={editingClass.title} onChange={e => setEditingClass({...editingClass, title: e.target.value})} />
              </div>
              <div className="space-y-2">
                <label className="text-xs font-black uppercase text-slate-400 ml-1">Kategori</label>
                <select className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white transition-all font-bold" value={editingClass.category} onChange={e => setEditingClass({...editingClass, category: e.target.value})}>
                  <option>SSW</option>
                  <option>Magang</option>
                  <option>Kursus</option>
                </select>
              </div>
              <div className="space-y-2">
                <label className="text-xs font-black uppercase text-slate-400 ml-1">Biaya (String)</label>
                <input required type="text" className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all font-bold" value={editingClass.price} placeholder="Rp 5.500.000" onChange={e => setEditingClass({...editingClass, price: e.target.value})} />
              </div>
              <div className="space-y-2">
                <label className="text-xs font-black uppercase text-slate-400 ml-1">Durasi</label>
                <input required type="text" className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all font-bold" value={editingClass.duration} placeholder="4 Bulan" onChange={e => setEditingClass({...editingClass, duration: e.target.value})} />
              </div>
            </div>

            <div className="space-y-2">
              <label className="text-xs font-black uppercase text-slate-400 ml-1">Fitur/Benefit (Pisahkan dengan koma)</label>
              <textarea rows={3} className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all font-bold resize-none" value={editingClass.features} onChange={e => setEditingClass({...editingClass, features: e.target.value})} />
            </div>

            <label className="flex items-center gap-3 cursor-pointer group">
              <input type="checkbox" checked={editingClass.isPopular} onChange={e => setEditingClass({...editingClass, isPopular: e.target.checked})} className="w-5 h-5 rounded-lg text-[var(--sji-blue)] focus:ring-[var(--sji-blue)]" />
              <span className="font-bold text-slate-700">Tandai sebagai Terpopuler</span>
            </label>

            <button type="submit" className="w-full py-4 bg-[var(--sji-blue)] text-white font-black rounded-2xl shadow-xl hover:bg-blue-700 transition-all">Simpan Kelas</button>
          </form>
        </div>
      )}
    </div>
  );
}
