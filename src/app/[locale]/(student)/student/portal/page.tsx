'use client';

import { motion, AnimatePresence } from "framer-motion";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import FileUpload from "@/components/shared/FileUpload";
import AnnouncementBanner from "@/components/shared/AnnouncementBanner";
import { 
  CheckCircle2, 
  Circle, 
  Clock, 
  FileText, 
  Plane, 
  CreditCard, 
  User as UserIcon,
  ShieldCheck,
  Zap,
  Award,
  ArrowRight
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
    <main className="min-h-screen bg-[#F8FAFC]">
      <Header />
      <AnnouncementBanner />
      
      <div className="pt-40 pb-24 px-6">
        <div className="container mx-auto max-w-7xl">
          
          {/* Elite Welcome Section - 3D Perspective */}
          <div className="perspective-1000 mb-16">
            <motion.div 
              whileHover={{ rotateX: 2, rotateY: -2, scale: 1.01 }}
              className="bg-white rounded-[4rem] p-12 lg:p-20 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.05)] border border-white flex flex-col lg:flex-row items-center justify-between gap-12 relative overflow-hidden group"
            >
              {/* Background Glow */}
              <div className="absolute top-0 right-0 w-96 h-96 bg-[var(--sji-blue)] rounded-full blur-[120px] opacity-10 -translate-y-1/2 translate-x-1/2 transition-opacity group-hover:opacity-20"></div>
              
              <div className="space-y-8 relative z-10 text-center lg:text-left flex-1">
                <div className="space-y-4">
                  <motion.span 
                    initial={{ opacity: 0, x: -20 }}
                    animate={{ opacity: 1, x: 0 }}
                    className="px-5 py-2 bg-blue-50 text-[var(--sji-blue)] text-xs font-black uppercase tracking-[0.3em] rounded-2xl border border-blue-100 inline-block"
                  >
                    Personal Dashboard
                  </motion.span>
                  <h1 className="text-5xl lg:text-7xl font-black text-slate-900 leading-none tracking-tighter">
                    Halo, <span className="text-[var(--sji-blue)]">Ahmad Fauzi!</span> 👋
                  </h1>
                  <p className="text-xl text-slate-500 font-medium max-w-xl leading-relaxed">
                    Pantau terus perjalanan karirmu menuju Jepang. Pastikan semua dokumen dan tagihan sudah terpenuhi tepat waktu.
                  </p>
                </div>

                <div className="flex flex-wrap items-center justify-center lg:justify-start gap-6 pt-4">
                  <div className="flex items-center gap-3 text-sm font-black text-slate-700 bg-slate-50 px-6 py-3 rounded-[1.5rem] border border-slate-100 shadow-sm hover:bg-white transition-all">
                    <div className="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center text-[var(--sji-blue)]"><UserIcon size={16} /></div>
                    SJI-2026-042
                  </div>
                  <div className="flex items-center gap-3 text-sm font-black text-slate-700 bg-slate-50 px-6 py-3 rounded-[1.5rem] border border-slate-100 shadow-sm hover:bg-white transition-all">
                    <div className="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-green-600"><ShieldCheck size={16} /></div>
                    Student Terverifikasi
                  </div>
                </div>
              </div>

              <div className="relative">
                <motion.div 
                  animate={{ rotate: [0, 5, 0] }}
                  transition={{ duration: 6, repeat: Infinity, ease: "easeInOut" }}
                  className="w-56 h-56 bg-gradient-to-br from-[var(--sji-blue)] to-blue-900 rounded-[3.5rem] flex items-center justify-center text-white font-black text-7xl shadow-[0_40px_80px_-15px_rgba(0,71,171,0.4)] border-[10px] border-white relative z-10"
                >
                  AF
                </motion.div>
                {/* Floating 3D Elements */}
                <motion.div animate={{ y: [0, -15, 0] }} transition={{ duration: 4, repeat: Infinity }} className="absolute -top-6 -right-6 w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center text-3xl z-20">🇯🇵</motion.div>
                <motion.div animate={{ y: [0, 15, 0] }} transition={{ duration: 5, repeat: Infinity }} className="absolute -bottom-6 -left-6 w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center text-3xl z-20 text-[var(--sji-red)]"><Zap fill="currentColor" /></motion.div>
              </div>
            </motion.div>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            {/* Journey Timeline - High Impact */}
            <div className="lg:col-span-8 space-y-12">
              <div className="bg-white rounded-[4rem] p-12 lg:p-16 shadow-sm border border-slate-100 relative overflow-hidden">
                <div className="flex items-center justify-between mb-16">
                  <h3 className="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-4">
                    <div className="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-[var(--sji-red)] shadow-inner"><Plane size={24} /></div>
                    Journey ke Jepang
                  </h3>
                  <button className="text-xs font-black uppercase tracking-widest text-[var(--sji-blue)] hover:underline">Download Roadmap</button>
                </div>
                
                <div className="relative space-y-16">
                  {/* Visual Progress Line */}
                  <div className="absolute left-6 top-4 bottom-4 w-1 bg-slate-50 rounded-full"></div>
                  <motion.div 
                    initial={{ height: 0 }}
                    animate={{ height: '33%' }}
                    transition={{ duration: 2, ease: "easeInOut" }}
                    className="absolute left-6 top-4 w-1 bg-gradient-to-b from-[var(--sji-blue)] to-[var(--sji-red)] rounded-full shadow-[0_0_15px_rgba(0,71,171,0.3)]"
                  />

                  {steps.map((step, i) => (
                    <motion.div 
                      key={step.name}
                      initial={{ opacity: 0, x: -30 }}
                      whileInView={{ opacity: 1, x: 0 }}
                      viewport={{ once: true }}
                      transition={{ delay: i * 0.1 }}
                      className="relative pl-20 group"
                    >
                      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div className="space-y-1">
                          <span className={`font-black text-2xl transition-colors ${
                            step.status === 'completed' ? 'text-slate-900' : 
                            step.status === 'current' ? 'text-[var(--sji-blue)]' : 'text-slate-300'
                          }`}>{step.name}</span>
                          <p className="text-slate-400 font-bold text-sm uppercase tracking-widest">{step.date}</p>
                        </div>
                        
                        {step.status === 'current' && (
                          <motion.div 
                            animate={{ scale: [1, 1.05, 1] }}
                            transition={{ duration: 2, repeat: Infinity }}
                            className="bg-blue-50 text-[var(--sji-blue)] px-5 py-2 rounded-xl border border-blue-100 text-xs font-black uppercase tracking-[0.2em]"
                          >
                            Sedang Berjalan
                          </motion.div>
                        )}
                      </div>
                      
                      {/* 3D-ish Indicator */}
                      <div className={`absolute left-0 w-12 h-12 rounded-2xl flex items-center justify-center z-10 transition-all duration-500 border-4 border-[#F8FAFC] shadow-xl ${
                        step.status === 'completed' ? 'bg-green-500 text-white group-hover:rotate-[360deg]' :
                        step.status === 'current' ? 'bg-[var(--sji-blue)] text-white scale-110' :
                        'bg-white text-slate-200 border-slate-50'
                      }`}>
                        {step.status === 'completed' ? <CheckCircle2 size={20} /> : 
                         step.status === 'current' ? <Clock size={20} className="animate-spin-slow" /> : <Circle size={20} />}
                      </div>
                    </motion.div>
                  ))}
                </div>
              </div>

              {/* Enhanced Upload Area */}
              <div className="bg-slate-900 rounded-[4rem] p-12 lg:p-16 text-white shadow-2xl relative overflow-hidden">
                <div className="absolute top-0 right-0 w-full h-full opacity-5 pointer-events-none">
                  <div className="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-[100px]"></div>
                </div>
                
                <h3 className="text-3xl font-black mb-10 flex items-center gap-4 relative z-10">
                  <div className="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center"><FileText size={24} /></div>
                  Pusat Berkas Digital
                </h3>
                
                <div className="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10">
                  <div className="space-y-4">
                    <FileUpload label="KTP / Kartu Keluarga" onUpload={(url) => console.log(url)} />
                    <p className="text-[10px] text-slate-500 font-bold uppercase tracking-widest pl-2">Format: JPG, PNG, PDF (Max 5MB)</p>
                  </div>
                  <div className="space-y-4">
                    <FileUpload label="Passport (Jika Ada)" onUpload={(url) => console.log(url)} />
                    <p className="text-[10px] text-slate-500 font-bold uppercase tracking-widest pl-2">Format: PDF (Warna)</p>
                  </div>
                </div>
              </div>
            </div>

            {/* Sidebar Modules */}
            <div className="lg:col-span-4 space-y-12 sticky top-32">
              
              {/* Billing - Premium Dark Look */}
              <motion.div 
                whileHover={{ y: -10 }}
                className="bg-white rounded-[3.5rem] p-10 shadow-2xl shadow-slate-200/50 border border-slate-100 flex flex-col"
              >
                <div className="flex items-center justify-between mb-10">
                  <div className="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-[var(--sji-red)] shadow-inner">
                    <CreditCard size={28} />
                  </div>
                  <span className="text-[10px] font-black uppercase tracking-widest text-slate-400 bg-slate-50 px-3 py-1 rounded-lg">Invoice active</span>
                </div>
                
                <div className="space-y-2 mb-10">
                  <p className="text-slate-400 font-black uppercase tracking-widest text-[10px]">Sisa Tagihan Pelatihan</p>
                  <div className="text-5xl font-black text-slate-900 tracking-tighter italic">Rp 4.5M</div>
                </div>

                <div className="space-y-4 mb-10">
                  <div className="flex justify-between items-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <span className="text-sm font-bold text-slate-500">Terbayar</span>
                    <span className="text-sm font-black text-green-600">Rp 1.000.000</span>
                  </div>
                  <div className="flex justify-between items-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <span className="text-sm font-bold text-slate-500">Total Program</span>
                    <span className="text-sm font-black text-slate-900">Rp 5.500.000</span>
                  </div>
                </div>

                <button className="w-full py-5 bg-[var(--sji-blue)] text-white font-black rounded-3xl hover:bg-blue-700 shadow-2xl shadow-blue-900/30 transition-all flex items-center justify-center gap-3 group">
                  Bayar Sekarang <ArrowRight size={20} className="group-hover:translate-x-1 transition-transform" />
                </button>
              </motion.div>

              {/* Achievements - 3D Card */}
              <div className="bg-gradient-to-br from-blue-600 to-blue-800 rounded-[3.5rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                <div className="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <Award className="w-16 h-16 text-white/20 absolute -bottom-4 -right-4 group-hover:scale-125 transition-transform duration-700" />
                
                <h4 className="text-2xl font-black mb-6 relative z-10 tracking-tight">Akademik</h4>
                <div className="space-y-6 relative z-10">
                  <div className="flex items-center gap-4">
                    <div className="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center font-black">N4</div>
                    <div>
                      <p className="text-[10px] font-black uppercase tracking-widest text-blue-200">Target Level</p>
                      <p className="text-sm font-bold">JLPT N4 Certified</p>
                    </div>
                  </div>
                  <div className="flex items-center gap-4">
                    <div className="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center font-black text-xs">85%</div>
                    <div>
                      <p className="text-[10px] font-black uppercase tracking-widest text-blue-200">Attendance</p>
                      <p className="text-sm font-bold">Excellent Record</p>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <Footer />
    </main>
  );
}
