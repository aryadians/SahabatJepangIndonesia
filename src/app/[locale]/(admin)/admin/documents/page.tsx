'use client';

import { useState } from 'react';
import { Check, X, Eye, FileText, Download, User } from 'lucide-react';
import { showSuccess } from '@/lib/swal';

export default function DocumentVerificationPage() {
  const [docs, setDocs] = useState([
    { id: 1, student: 'Ahmad Fauzi', type: 'KTP', status: 'PENDING', date: '15 Mar 2026' },
    { id: 2, student: 'Siti Aminah', type: 'Passport', status: 'PENDING', date: '14 Mar 2026' },
    { id: 3, student: 'Budi Santoso', type: 'Ijazah', status: 'VERIFIED', date: '10 Mar 2026' },
  ]);

  const handleVerify = (id: number) => {
    showSuccess("Terverifikasi", "Dokumen telah disetujui.");
    setDocs(docs.map(d => d.id === id ? { ...d, status: 'VERIFIED' } : d));
  };

  return (
    <div className="space-y-8">
      <div>
        <h2 className="text-2xl font-bold text-slate-900">Verifikasi Dokumen</h2>
        <p className="text-slate-500 text-sm">Validasi berkas yang diunggah oleh calon siswa.</p>
      </div>

      <div className="grid grid-cols-1 gap-4">
        {docs.map((doc) => (
          <div key={doc.id} className="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
            <div className="flex items-center gap-6">
              <div className={`w-14 h-14 rounded-2xl flex items-center justify-center ${
                doc.status === 'VERIFIED' ? 'bg-green-50 text-green-600' : 'bg-blue-50 text-[var(--sji-blue)]'
              }`}>
                <FileText size={24} />
              </div>
              <div>
                <div className="flex items-center gap-3 mb-1">
                  <h4 className="font-bold text-slate-900">{doc.student}</h4>
                  <span className="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-black rounded-md uppercase tracking-widest">{doc.type}</span>
                </div>
                <div className="flex items-center gap-4 text-xs font-medium text-slate-400">
                  <span className="flex items-center gap-1"><User size={12} /> SJI-2026-042</span>
                  <span>•</span>
                  <span>Diunggah: {doc.date}</span>
                </div>
              </div>
            </div>

            <div className="flex items-center gap-3">
              <button className="p-3 bg-slate-50 text-slate-400 rounded-xl hover:bg-slate-100 hover:text-slate-900 transition-all flex items-center gap-2 text-xs font-bold">
                <Eye size={16} /> Lihat File
              </button>
              {doc.status === 'PENDING' && (
                <>
                  <button onClick={() => handleVerify(doc.id)} className="p-3 bg-green-50 text-green-600 rounded-xl hover:bg-green-500 hover:text-white transition-all">
                    <Check size={18} />
                  </button>
                  <button className="p-3 bg-red-50 text-red-600 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                    <X size={18} />
                  </button>
                </>
              )}
              {doc.status === 'VERIFIED' && (
                <div className="flex items-center gap-2 text-green-600 font-bold text-xs px-4">
                  <Check size={16} /> Terverifikasi
                </div>
              )}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}
