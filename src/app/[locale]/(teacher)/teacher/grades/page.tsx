'use client';

import { useState } from 'react';
import { Save, User, BookOpen, Calculator, Loader2 } from 'lucide-react';
import { motion } from 'framer-motion';
import { showSuccess } from '@/lib/swal';

export default function GradeManagementPage() {
  const [loading, setLoading] = useState(false);
  const students = [
    { id: 'SJI-001', name: 'Ahmad Fauzi' },
    { id: 'SJI-002', name: 'Siti Aminah' },
    { id: 'SJI-003', name: 'Budi Santoso' },
  ];

  const handleSave = () => {
    setLoading(true);
    setTimeout(() => {
      setLoading(false);
      showSuccess("Data Tersimpan", "Nilai siswa berhasil diperbarui ke sistem.");
    }, 1000);
  };

  return (
    <div className="p-8 max-w-6xl mx-auto space-y-10">
      <div className="flex justify-between items-end">
        <div>
          <h1 className="text-3xl font-black text-slate-900">Input Nilai Siswa</h1>
          <p className="text-slate-500 font-medium text-sm">Manajemen penilaian harian dan try-out LPK SJI.</p>
        </div>
        <button 
          onClick={handleSave}
          disabled={loading}
          className="px-8 py-4 bg-[var(--sji-blue)] text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-blue-700 transition-all flex items-center gap-2"
        >
          {loading ? <Loader2 className="animate-spin" size={20} /> : <><Save size={20} /> Simpan Semua</>}
        </button>
      </div>

      <div className="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left">
            <thead>
              <tr className="bg-slate-50/50">
                <th className="px-8 py-6 text-xs font-black uppercase tracking-widest text-slate-400">Siswa</th>
                <th className="px-8 py-6 text-xs font-black uppercase tracking-widest text-slate-400">JLPT N4 (Kanji)</th>
                <th className="px-8 py-6 text-xs font-black uppercase tracking-widest text-slate-400">JLPT N4 (Grammar)</th>
                <th className="px-8 py-6 text-xs font-black uppercase tracking-widest text-slate-400">Choukai (Listening)</th>
                <th className="px-8 py-6 text-xs font-black uppercase tracking-widest text-slate-400">Status</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {students.map((student) => (
                <tr key={student.id} className="hover:bg-slate-50/30 transition-colors">
                  <td className="px-8 py-6">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[var(--sji-blue)] font-black text-xs">{student.id.split('-')[1]}</div>
                      <div>
                        <p className="font-bold text-slate-900 text-sm">{student.name}</p>
                        <p className="text-[10px] text-slate-400 font-black uppercase tracking-tighter">Batch 14</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-8 py-6">
                    <input type="number" placeholder="0" className="w-20 px-4 py-2 bg-slate-50 rounded-xl border border-transparent focus:bg-white focus:border-[var(--sji-blue)] outline-none font-bold text-center" />
                  </td>
                  <td className="px-8 py-6">
                    <input type="number" placeholder="0" className="w-20 px-4 py-2 bg-slate-50 rounded-xl border border-transparent focus:bg-white focus:border-[var(--sji-blue)] outline-none font-bold text-center" />
                  </td>
                  <td className="px-8 py-6">
                    <input type="number" placeholder="0" className="w-20 px-4 py-2 bg-slate-50 rounded-xl border border-transparent focus:bg-white focus:border-[var(--sji-blue)] outline-none font-bold text-center" />
                  </td>
                  <td className="px-8 py-6">
                    <span className="px-3 py-1 bg-yellow-50 text-yellow-600 text-[10px] font-black uppercase rounded-lg">Draft</span>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}
