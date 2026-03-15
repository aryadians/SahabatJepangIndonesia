'use client';

import { motion } from "framer-motion";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { 
  CheckCircle2, 
  Circle, 
  Clock, 
  FileText, 
  Plane, 
  CreditCard, 
  User as UserIcon,
  ShieldCheck
} from "lucide-react";

export default function StudentPortalPage() {
  const steps = [
    { name: "Pendaftaran", status: "completed", date: "15 Jan 2026" },
    { name: "Pelatihan Bahasa", status: "current", date: "On Progress" },
    { name: "Ujian JFT/JLPT", status: "upcoming", date: "Apr 2026" },
    { name: "Wawancara User", status: "upcoming", date: "-" },
    { name: "Proses COE", status: "upcoming", date: "-" },
    { name: "Terbang ke Jepang", status: "upcoming", date: "-" },
  ];

  return (
    <main className="min-h-screen bg-slate-50">
      <Header />
      
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto max-w-6xl">
          {/* Welcome Card */}
          <div className="bg-white rounded-[3rem] p-10 lg:p-16 shadow-sm border border-slate-100 mb-12 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <div className="space-y-4 relative z-10 text-center md:text-left">
              <span className="px-4 py-1.5 bg-blue-50 text-[var(--sji-blue)] text-xs font-black uppercase tracking-widest rounded-full">Student Portal</span>
              <h1 className="text-4xl font-black text-slate-900 leading-tight">Halo, Ahmad Fauzi! 👋</h1>
              <p className="text-gray-500 max-w-md">Pantau terus perjalanan karirmu menuju Jepang. Pastikan semua dokumen dan tagihan sudah terpenuhi.</p>
              <div className="flex flex-wrap items-center justify-center md:justify-start gap-4 pt-4">
                <div className="flex items-center gap-2 text-sm font-bold text-slate-700 bg-slate-50 px-4 py-2 rounded-xl">
                  <UserIcon size={16} className="text-[var(--sji-blue)]" /> SJI-2026-042
                </div>
                <div className="flex items-center gap-2 text-sm font-bold text-slate-700 bg-slate-50 px-4 py-2 rounded-xl">
                  <ShieldCheck size={16} className="text-green-500" /> Terverifikasi
                </div>
              </div>
            </div>
            <div className="w-48 h-48 bg-[var(--sji-blue)] rounded-[2.5rem] flex items-center justify-center text-white font-black text-6xl shadow-2xl relative z-10">
              AF
            </div>
            {/* Background Decor */}
            <div className="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 opacity-50"></div>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {/* Journey Timeline */}
            <div className="lg:col-span-2 space-y-8">
              <div className="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                <h3 className="text-2xl font-bold text-slate-900 mb-10 flex items-center gap-3">
                  <Plane className="text-[var(--sji-red)]" /> Journey ke Jepang
                </h3>
                
                <div className="relative space-y-12">
                  {/* Vertical Line */}
                  <div className="absolute left-4 top-2 bottom-2 w-0.5 bg-slate-100"></div>

                  {steps.map((step, i) => (
                    <motion.div 
                      key={step.name}
                      initial={{ opacity: 0, x: -20 }}
                      whileInView={{ opacity: 1, x: 0 }}
                      transition={{ delay: i * 0.1 }}
                      className="relative pl-12 flex items-center justify-between"
                    >
                      <div className="flex flex-col">
                        <span className="font-bold text-slate-900 text-lg">{step.name}</span>
                        <span className="text-sm text-slate-400 font-medium">{step.date}</span>
                      </div>
                      
                      {/* Icon Indicator */}
                      <div className={`absolute left-0 w-8 h-8 rounded-full flex items-center justify-center z-10 border-4 border-white ${
                        step.status === 'completed' ? 'bg-green-500 text-white' :
                        step.status === 'current' ? 'bg-[var(--sji-blue)] text-white ring-4 ring-blue-100' :
                        'bg-slate-100 text-slate-300'
                      }`}>
                        {step.status === 'completed' ? <CheckCircle2 size={14} /> : 
                         step.status === 'current' ? <Clock size={14} /> : <Circle size={14} />}
                      </div>

                      {step.status === 'current' && (
                        <span className="text-xs font-black uppercase text-[var(--sji-blue)] bg-blue-50 px-3 py-1 rounded-lg">Sedang Berjalan</span>
                      )}
                    </motion.div>
                  ))}
                </div>
              </div>
            </div>

            {/* Sidebar Cards */}
            <div className="space-y-8">
              {/* Document Status */}
              <div className="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                <h4 className="font-bold text-slate-900 mb-6 flex items-center gap-3 text-lg">
                  <FileText className="text-[var(--sji-blue)]" /> Dokumen
                </h4>
                <div className="space-y-4">
                  {[
                    { name: 'KTP & KK', status: 'OK' },
                    { name: 'Ijazah Terakhir', status: 'OK' },
                    { name: 'Passport', status: 'PENDING' },
                    { name: 'Medical Checkup', status: 'MISSING' },
                  ].map((doc) => (
                    <div key={doc.name} className="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                      <span className="text-sm font-bold text-slate-700">{doc.name}</span>
                      <span className={`text-[10px] font-black px-2 py-1 rounded-md ${
                        doc.status === 'OK' ? 'bg-green-100 text-green-600' :
                        doc.status === 'PENDING' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600'
                      }`}>{doc.status}</span>
                    </div>
                  ))}
                </div>
                <button className="w-full mt-6 py-3 border-2 border-dashed border-slate-200 text-slate-400 font-bold rounded-2xl hover:bg-slate-50 transition-all text-sm">
                  + Upload Dokumen Baru
                </button>
              </div>

              {/* Billing Summary */}
              <div className="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-xl shadow-slate-900/20">
                <h4 className="font-bold mb-6 flex items-center gap-3 text-lg">
                  <CreditCard className="text-[var(--sji-red)]" /> Billing
                </h4>
                <div className="space-y-2 mb-8">
                  <p className="text-slate-400 text-sm">Total Tagihan</p>
                  <p className="text-3xl font-black">Rp 5.500.000</p>
                </div>
                <div className="space-y-4">
                  <div className="flex justify-between text-sm">
                    <span className="text-slate-400 font-medium">Terbayar</span>
                    <span className="font-bold text-green-400">Rp 1.000.000</span>
                  </div>
                  <div className="flex justify-between text-sm">
                    <span className="text-slate-400 font-medium">Sisa</span>
                    <span className="font-bold text-red-400">Rp 4.500.000</span>
                  </div>
                </div>
                <button className="w-full mt-8 py-4 bg-[var(--sji-red)] text-white font-bold rounded-2xl hover:bg-red-700 transition-all shadow-lg shadow-red-900/20">
                  Bayar Sekarang
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <Footer />
    </main>
  );
}
