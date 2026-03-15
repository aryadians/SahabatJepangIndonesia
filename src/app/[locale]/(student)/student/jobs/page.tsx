'use client';

import { useState, useEffect } from 'react';
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { motion } from "framer-motion";
import { Briefcase, MapPin, Wallet, Calendar, Search, ArrowRight, Loader2 } from "lucide-react";
import { showSuccess } from "@/lib/swal";

export default function JobsPage() {
  const [jobs, setJobs] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchJobs();
  }, []);

  const fetchJobs = async () => {
    try {
      const res = await fetch('/api/jobs');
      const data = await res.json();
      if (Array.isArray(data)) setJobs(data);
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  const handleApply = (title: string) => {
    showSuccess("Lamaran Terkirim", `Berhasil melamar untuk posisi ${title}. Tim admin SJI akan meninjau profil Anda.`);
  };

  return (
    <main className="min-h-screen bg-slate-50">
      <Header />
      
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto max-w-6xl">
          <div className="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
              <h1 className="text-4xl font-black text-slate-900 mb-2">Job Board</h1>
              <p className="text-slate-500 font-medium">Temukan peluang karir terbaik di Jepang bersama mitra resmi SJI.</p>
            </div>
            <div className="relative w-full md:w-96">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={18} />
              <input type="text" placeholder="Cari posisi atau lokasi..." className="w-full pl-12 pr-4 py-4 bg-white rounded-2xl shadow-sm border-transparent focus:border-[var(--sji-blue)] outline-none transition-all" />
            </div>
          </div>

          {loading ? (
            <div className="p-20 flex flex-col items-center justify-center gap-4">
              <Loader2 className="animate-spin text-[var(--sji-blue)]" size={40} />
              <p className="text-slate-400 font-bold">Memuat Lowongan Kerja...</p>
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
              {jobs.length === 0 && (
                <div className="col-span-full p-20 text-center bg-white rounded-[3rem] border border-dashed border-slate-200">
                  <p className="text-slate-400 font-bold">Belum ada lowongan kerja tersedia saat ini.</p>
                </div>
              )}
              {jobs.map((job, i) => (
                <motion.div
                  key={job.id}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: i * 0.1 }}
                  className="bg-white rounded-[2.5rem] p-8 lg:p-10 shadow-sm border border-slate-100 hover:shadow-xl transition-all group"
                >
                  <div className="flex justify-between items-start mb-6">
                    <div className="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-[var(--sji-blue)] group-hover:scale-110 transition-transform">
                      <Briefcase size={28} />
                    </div>
                    <span className="px-4 py-1.5 bg-green-50 text-green-600 text-[10px] font-black uppercase tracking-widest rounded-lg">Verified</span>
                  </div>

                  <h3 className="text-2xl font-black text-slate-900 mb-2 group-hover:text-[var(--sji-blue)] transition-colors">{job.title}</h3>
                  <p className="text-slate-400 font-bold text-sm mb-6 uppercase tracking-wider">{job.company}</p>

                  <div className="grid grid-cols-2 gap-4 mb-8">
                    <div className="flex items-center gap-2 text-slate-500">
                      <MapPin size={16} className="text-[var(--sji-red)]" />
                      <span className="text-xs font-bold">{job.location}</span>
                    </div>
                    <div className="flex items-center gap-2 text-slate-500">
                      <Wallet size={16} className="text-[var(--sji-blue)]" />
                      <span className="text-xs font-bold">{job.salary}</span>
                    </div>
                  </div>

                  <div className="flex items-center gap-4 pt-6 border-t border-slate-50">
                    <button 
                      onClick={() => handleApply(job.title)}
                      className="flex-1 py-4 bg-[var(--sji-blue)] text-white font-black rounded-xl shadow-lg shadow-blue-900/20 hover:bg-blue-700 transition-all flex items-center justify-center gap-2"
                    >
                      Lamar Sekarang <ArrowRight size={18} />
                    </button>
                    <button className="px-6 py-4 bg-slate-50 text-slate-500 font-bold rounded-xl hover:bg-slate-100 transition-all">Detail</button>
                  </div>
                </motion.div>
              ))}
            </div>
          )}
        </div>
      </div>

      <Footer />
    </main>
  );
}
