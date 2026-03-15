'use client';

import { useState, useEffect } from 'react';
import { Save, RefreshCw, Type, Image as ImageIcon, Phone, Mail, Loader2 } from 'lucide-react';
import { showSuccess, showError } from '@/lib/swal';

export default function ContentManagerPage() {
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [contents, setContents] = useState<any>({
    hero_title: 'Wujudkan Karir Impian di Jepang',
    contact_phone: '+62 813-3327-0022',
    contact_email: 'official@sjigroup.co.id',
    footer_text: 'Lembaga Pelatihan Kerja Resmi (SO) yang berdedikasi...',
  });

  useEffect(() => {
    fetchContents();
  }, []);

  const fetchContents = async () => {
    try {
      const res = await fetch('/api/content');
      const data = await res.json();
      setContents({ ...contents, ...data });
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  const handleSave = async (key: string) => {
    setSaving(true);
    try {
      const res = await fetch('/api/content', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ key, value: contents[key] })
      });
      if (res.ok) showSuccess("Berhasil", `Konten ${key} telah diperbarui.`);
    } catch (error) {
      showError("Gagal", "Terjadi kesalahan saat menyimpan.");
    } finally {
      setSaving(false);
    }
  };

  if (loading) return <div className="p-20 text-center"><Loader2 className="animate-spin mx-auto" /></div>;

  return (
    <div className="space-y-10 pb-20">
      <div>
        <h2 className="text-3xl font-black text-slate-900 tracking-tighter">Manajemen Konten (CMS)</h2>
        <p className="text-slate-500 font-medium">Ubah tulisan, gambar, dan informasi penting secara dinamis.</p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {/* Hero Section CMS */}
        <div className="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 space-y-8">
          <div className="flex items-center gap-3 border-b border-slate-50 pb-6">
            <div className="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-[var(--sji-blue)]"><Type size={20} /></div>
            <h3 className="font-black text-slate-900 uppercase tracking-widest text-sm">Hero Section</h3>
          </div>
          
          <div className="space-y-6">
            <div className="space-y-2">
              <label className="text-xs font-black text-slate-400 uppercase ml-1">Hero Title</label>
              <div className="flex gap-2">
                <input 
                  type="text" 
                  className="flex-1 px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all font-bold" 
                  value={contents.hero_title}
                  onChange={(e) => setContents({...contents, hero_title: e.target.value})}
                />
                <button onClick={() => handleSave('hero_title')} className="p-4 bg-[var(--sji-blue)] text-white rounded-2xl hover:scale-105 active:scale-95 transition-all shadow-lg shadow-blue-900/20"><Save size={20} /></button>
              </div>
            </div>
          </div>
        </div>

        {/* Contact CMS */}
        <div className="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 space-y-8">
          <div className="flex items-center gap-3 border-b border-slate-50 pb-6">
            <div className="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-[var(--sji-red)]"><Phone size={20} /></div>
            <h3 className="font-black text-slate-900 uppercase tracking-widest text-sm">Informasi Kontak</h3>
          </div>
          
          <div className="space-y-6">
            <div className="space-y-2">
              <label className="text-xs font-black text-slate-400 uppercase ml-1">WhatsApp SJI</label>
              <div className="flex gap-2">
                <input 
                  type="text" 
                  className="flex-1 px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-red-100 transition-all font-bold" 
                  value={contents.contact_phone}
                  onChange={(e) => setContents({...contents, contact_phone: e.target.value})}
                />
                <button onClick={() => handleSave('contact_phone')} className="p-4 bg-[var(--sji-red)] text-white rounded-2xl hover:scale-105 active:scale-95 transition-all shadow-lg shadow-red-900/20"><Save size={20} /></button>
              </div>
            </div>
            <div className="space-y-2">
              <label className="text-xs font-black text-slate-400 uppercase ml-1">Email Resmi</label>
              <div className="flex gap-2">
                <input 
                  type="text" 
                  className="flex-1 px-6 py-4 bg-slate-50 rounded-2xl outline-none focus:bg-white focus:ring-2 focus:ring-slate-100 transition-all font-bold" 
                  value={contents.contact_email}
                  onChange={(e) => setContents({...contents, contact_email: e.target.value})}
                />
                <button onClick={() => handleSave('contact_email')} className="p-4 bg-slate-900 text-white rounded-2xl hover:scale-105 active:scale-95 transition-all shadow-lg shadow-black/20"><Save size={20} /></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
