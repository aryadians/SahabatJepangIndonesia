'use client';

import { useState, useEffect } from 'react';
import { Plus, Trash2, Globe, Building2, Loader2, Image as ImageIcon } from 'lucide-react';
import { showSuccess, showError, showConfirm } from '@/lib/swal';
import Image from 'next/image';

export default function PartnerManagerPage() {
  const [partners, setPartners] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [adding, setAdding] = useState(false);
  const [newPartner, setNewPartner] = useState({ name: '', logoUrl: '', type: 'MITRA' });

  useEffect(() => {
    fetchPartners();
  }, []);

  const fetchPartners = async () => {
    try {
      const res = await fetch('/api/partners');
      const data = await res.json();
      if (Array.isArray(data)) setPartners(data);
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  const handleAdd = async (e: React.FormEvent) => {
    e.preventDefault();
    setAdding(true);
    try {
      const res = await fetch('/api/partners', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(newPartner)
      });
      if (res.ok) {
        showSuccess("Berhasil", "Mitra baru telah ditambahkan.");
        setNewPartner({ name: '', logoUrl: '', type: 'MITRA' });
        fetchPartners();
      }
    } catch (error) {
      showError("Gagal", "Terjadi kesalahan.");
    } finally {
      setAdding(false);
    }
  };

  const handleDelete = async (id: string) => {
    const confirm = await showConfirm("Hapus Mitra?", "Tindakan ini tidak dapat dibatalkan.");
    if (confirm.isConfirmed) {
      try {
        await fetch(`/api/partners?id=${id}`, { method: 'DELETE' });
        showSuccess("Terhapus", "Mitra telah dihapus.");
        fetchPartners();
      } catch (error) {
        showError("Gagal", "Gagal menghapus data.");
      }
    }
  };

  return (
    <div className="space-y-10 pb-20">
      <div>
        <h2 className="text-3xl font-black text-slate-900 tracking-tighter">Manajemen Mitra & SO</h2>
        <p className="text-slate-500 font-medium">Kelola logo perusahaan partner di Jepang dan Sending Organization.</p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {/* Form Add */}
        <div className="lg:col-span-1">
          <form onSubmit={handleAdd} className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 space-y-6 sticky top-28">
            <h3 className="font-black text-slate-900 uppercase tracking-widest text-xs mb-4">Tambah Mitra Baru</h3>
            
            <div className="space-y-4">
              <div className="space-y-2">
                <label className="text-xs font-black text-slate-400 uppercase ml-1">Nama Perusahaan</label>
                <input 
                  required
                  type="text" 
                  className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all font-bold" 
                  placeholder="Contoh: Toyota Motor Corp"
                  value={newPartner.name}
                  onChange={(e) => setNewPartner({...newPartner, name: e.target.value})}
                />
              </div>
              <div className="space-y-2">
                <label className="text-xs font-black text-slate-400 uppercase ml-1">URL Logo (Unsplash/Direct)</label>
                <input 
                  required
                  type="text" 
                  className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all font-bold" 
                  placeholder="https://images.unsplash.com/..."
                  value={newPartner.logoUrl}
                  onChange={(e) => setNewPartner({...newPartner, logoUrl: e.target.value})}
                />
              </div>
              <div className="space-y-2">
                <label className="text-xs font-black text-slate-400 uppercase ml-1">Tipe Mitra</label>
                <select 
                  className="w-full px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white transition-all font-bold"
                  value={newPartner.type}
                  onChange={(e) => setNewPartner({...newPartner, type: e.target.value})}
                >
                  <option value="MITRA">Mitra Resmi (User)</option>
                  <option value="SO">Sending Organization (SO)</option>
                </select>
              </div>
            </div>

            <button 
              disabled={adding}
              type="submit" 
              className="w-full py-4 bg-[var(--sji-blue)] text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-blue-700 transition-all flex items-center justify-center gap-2"
            >
              {adding ? <Loader2 className="animate-spin" /> : <><Plus size={20} /> Simpan Mitra</>}
            </button>
          </form>
        </div>

        {/* List Grid */}
        <div className="lg:col-span-2">
          {loading ? (
            <div className="p-20 text-center"><Loader2 className="animate-spin mx-auto text-[var(--sji-blue)]" /></div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {partners.map((p) => (
                <div key={p.id} className="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
                  <div className="flex items-center gap-4">
                    <div className="w-16 h-16 bg-slate-50 rounded-2xl overflow-hidden relative border border-slate-100">
                      <Image src={p.logoUrl} alt={p.name} fill className="object-contain p-2" />
                    </div>
                    <div>
                      <h4 className="font-bold text-slate-900 leading-tight">{p.name}</h4>
                      <span className={`text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded ${
                        p.type === 'SO' ? 'bg-red-50 text-[var(--sji-red)]' : 'bg-blue-50 text-[var(--sji-blue)]'
                      }`}>{p.type}</span>
                    </div>
                  </div>
                  <button 
                    onClick={() => handleDelete(p.id)}
                    className="p-3 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all"
                  >
                    <Trash2 size={18} />
                  </button>
                </div>
              ))}
              {partners.length === 0 && (
                <div className="col-span-full p-20 text-center bg-white rounded-[3rem] border border-dashed border-slate-200">
                  <p className="text-slate-400 font-bold">Belum ada mitra yang ditambahkan.</p>
                </div>
              )}
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
