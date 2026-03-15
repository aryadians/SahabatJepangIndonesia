'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useTranslations } from "next-intl";
import { motion } from "framer-motion";
import { Target, Eye, Award, Users2, ShieldCheck, Sparkles } from "lucide-react";
import Image from "next/image";

export default function AboutPage() {
  const t = useTranslations('About');

  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      {/* Hero Section with Image */}
      <section className="pt-40 pb-24 bg-slate-50 relative overflow-hidden">
        <div className="container mx-auto px-6 relative z-10">
          <div className="flex flex-col lg:flex-row items-center gap-20">
            <div className="lg:w-1/2 space-y-8">
              <motion.div
                initial={{ opacity: 0, x: -20 }}
                animate={{ opacity: 1, x: 0 }}
                className="inline-flex items-center gap-2 px-4 py-1.5 bg-[var(--sji-blue)]/10 text-[var(--sji-blue)] rounded-full text-xs font-black uppercase tracking-[0.2em]"
              >
                <Sparkles size={14} /> Sejarah & Visi SJI
              </motion.div>
              <motion.h1 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                className="text-5xl md:text-7xl font-black text-slate-900 leading-tight tracking-tighter"
              >
                Membangun <br /> <span className="text-[var(--sji-red)]">Masa Depan</span> <br /> Global.
              </motion.h1>
              <motion.p 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.1 }}
                className="text-xl text-slate-500 font-medium leading-relaxed max-w-xl"
              >
                {t('description')}
              </motion.p>
            </div>
            <div className="lg:w-1/2 relative">
              <motion.div 
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                className="relative z-10 aspect-[4/5] bg-slate-200 rounded-[4rem] overflow-hidden shadow-2xl border-[16px] border-white group"
              >
                <Image 
                  src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&q=80&w=1000" 
                  alt="SJI History"
                  fill
                  className="object-cover group-hover:scale-110 transition-transform duration-1000"
                />
              </motion.div>
              <div className="absolute -bottom-10 -left-10 w-64 h-64 bg-[var(--sji-blue)]/10 rounded-full blur-3xl -z-10"></div>
            </div>
          </div>
        </div>
      </section>

      {/* Vision & Mission - 3D Perspective Cards */}
      <section className="py-32">
        <div className="container mx-auto px-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
            <motion.div 
              whileHover={{ rotateX: 5, rotateY: -5, y: -10 }}
              className="p-12 lg:p-16 rounded-[4rem] bg-white border border-slate-100 shadow-[0_40px_80px_-20px_rgba(0,0,0,0.05)] relative overflow-hidden group perspective-1000"
            >
              <div className="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center text-[var(--sji-blue)] mb-10 group-hover:scale-110 transition-transform shadow-inner">
                <Eye size={32} />
              </div>
              <h2 className="text-3xl font-black text-slate-900 mb-8 tracking-tight">{t('vision')}</h2>
              <p className="text-lg text-slate-500 font-bold leading-relaxed italic">
                "Menjadi lembaga pelatihan kerja terdepan di Indonesia yang dipercaya secara global dalam mencetak tenaga kerja profesional dan berintegritas untuk masa depan Indonesia-Jepang."
              </p>
              <div className="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-blue-50 to-transparent opacity-50"></div>
            </motion.div>

            <motion.div 
              whileHover={{ rotateX: -5, rotateY: 5, y: -10 }}
              className="p-12 lg:p-16 rounded-[4rem] bg-slate-900 text-white shadow-2xl relative overflow-hidden group perspective-1000"
            >
              <div className="w-20 h-20 bg-white/10 rounded-3xl flex items-center justify-center text-[var(--sji-red)] mb-10 group-hover:scale-110 transition-transform border border-white/5">
                <Target size={32} />
              </div>
              <h2 className="text-3xl font-black mb-8 tracking-tight">{t('mission')}</h2>
              <ul className="space-y-6">
                {[
                  "Memberikan pelatihan bahasa dan budaya Jepang berkualitas tinggi.",
                  "Menjalin kemitraan strategis dengan perusahaan ternama di Jepang.",
                  "Membimbing siswa dalam proses administrasi hingga penempatan kerja."
                ].map((m, i) => (
                  <li key={i} className="flex gap-4 items-start">
                    <div className="w-6 h-6 bg-[var(--sji-red)] rounded-lg flex items-center justify-center shrink-0 mt-1 shadow-lg shadow-red-500/20">
                      <ShieldCheck size={14} className="text-white" />
                    </div>
                    <span className="text-slate-300 font-bold leading-relaxed">{m}</span>
                  </li>
                ))}
              </ul>
              <div className="absolute bottom-0 right-0 w-48 h-48 bg-red-500/10 rounded-full blur-3xl opacity-50"></div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Corporate Values with dynamic layout */}
      <section className="py-32 bg-slate-50 relative overflow-hidden">
        <div className="container mx-auto px-6 relative z-10">
          <div className="text-center max-w-3xl mx-auto mb-20 space-y-4">
            <span className="text-[var(--sji-red)] font-black uppercase tracking-[0.2em] text-xs">Our Core Values</span>
            <h2 className="text-4xl md:text-6xl font-black text-slate-900 tracking-tight">Nilai-Nilai Utama Kami</h2>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {[
              { icon: <Award />, title: "Legalitas Resmi", desc: "Izin resmi KEMNAKER RI sebagai Sending Organization (SO)." },
              { icon: <Users2 />, title: "Instruktur Ahli", desc: "Pengajar berpengalaman dan bersertifikat level N2/N1." },
              { icon: <Target />, title: "Fokus Karier", desc: "Bimbingan intensif hingga siswa mendapatkan kontrak kerja." },
              { icon: <Sparkles />, title: "Jejaring Luas", desc: "Koneksi dengan puluhan Kumiai dan Perusahaan di Jepang." }
            ].map((v, i) => (
              <motion.div 
                key={i}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="bg-white p-10 rounded-[3rem] shadow-sm border border-white hover:shadow-xl transition-all group text-center"
              >
                <div className="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 text-[var(--sji-red)] group-hover:bg-[var(--sji-red)] group-hover:text-white transition-all duration-500 shadow-inner">
                  {v.icon}
                </div>
                <h4 className="font-black text-slate-900 mb-3">{v.title}</h4>
                <p className="text-sm text-slate-500 font-medium leading-relaxed">{v.desc}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
