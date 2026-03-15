'use client';

import { FileText, Download, Printer, Search } from 'lucide-react';
import { generateInvoicePDF } from '@/components/admin/InvoicePDF';

export default function BillingPage() {
  const invoices = [
    { id: 'INV-2026-001', name: 'Ahmad Fauzi', amount: 5500000, status: 'PAID', date: '15 Jan 2026', desc: 'Pelatihan Tokutei Ginou Kaigo' },
    { id: 'INV-2026-002', name: 'Siti Aminah', amount: 4500000, status: 'PARTIAL', date: '20 Feb 2026', desc: 'Magang Food Processing' },
    { id: 'INV-2026-003', name: 'Budi Santoso', amount: 2500000, status: 'PENDING', date: '01 Mar 2026', desc: 'Kursus Bahasa Jepang N4' },
  ];

  const handleDownload = (inv: any) => {
    generateInvoicePDF({
      invoiceId: inv.id,
      studentName: inv.name,
      amount: inv.amount,
      date: inv.date,
      description: inv.desc
    });
  };

  return (
    <div className="space-y-8">
      <div>
        <h2 className="text-2xl font-bold text-slate-900">Tagihan & Pembayaran</h2>
        <p className="text-slate-500 text-sm">Kelola invoice dan status pembayaran siswa.</p>
      </div>

      <div className="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div className="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between gap-4">
          <div className="relative flex-1">
            <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={18} />
            <input type="text" placeholder="Cari nomor invoice atau nama..." className="w-full pl-12 pr-4 py-3 bg-slate-50 rounded-xl outline-none text-sm" />
          </div>
          <button className="px-6 py-3 bg-[var(--sji-blue)] text-white font-bold rounded-xl text-sm hover:bg-blue-700 transition-all">
            Buat Invoice Baru
          </button>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left">
            <thead>
              <tr className="bg-slate-50/50">
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Invoice ID</th>
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Siswa</th>
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Total</th>
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {invoices.map((inv) => (
                <tr key={inv.id} className="hover:bg-slate-50/50 transition-colors">
                  <td className="px-8 py-5 text-sm font-bold text-slate-900">{inv.id}</td>
                  <td className="px-8 py-5">
                    <p className="text-sm font-bold text-slate-900">{inv.name}</p>
                    <p className="text-[10px] text-slate-400 uppercase font-black">{inv.date}</p>
                  </td>
                  <td className="px-8 py-5 text-sm font-bold text-slate-700">Rp {inv.amount.toLocaleString('id-ID')}</td>
                  <td className="px-8 py-5">
                    <span className={`px-3 py-1 rounded-full text-[10px] font-black ${
                      inv.status === 'PAID' ? 'bg-green-100 text-green-600' : 
                      inv.status === 'PARTIAL' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600'
                    }`}>
                      {inv.status}
                    </span>
                  </td>
                  <td className="px-8 py-5 text-right">
                    <button 
                      onClick={() => handleDownload(inv)}
                      className="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 text-[var(--sji-blue)] font-bold rounded-lg hover:bg-blue-50 transition-all text-xs"
                    >
                      <Download size={14} /> PDF
                    </button>
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
