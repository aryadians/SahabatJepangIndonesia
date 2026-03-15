'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { motion } from "framer-motion";
import { Link } from "@/i18n/routing";
import { Briefcase, GraduationCap, BookOpen, MapPin, Building2, Search, ArrowRight, ShieldCheck } from "lucide-react";
import Image from "next/image";

export default function ProgramsPage() {
  const programs = [
    {
      title: "Tokutei Ginou (SSW)",
      subtitle: "Specified Skilled Worker",
      desc: "Program tenaga kerja ahli untuk Anda yang memiliki kompetensi khusus di bidang tertentu.",
      icon: <Briefcase className="w-10 h-10" />,
      image: "https://images.unsplash.com/photo-1516216628859-9bcceca13ca4?auto=format&fit=crop&q=80&w=800",
      sectors: ["Kaigo", "Food Service", "Agriculture", "Construction", "Hospitality"],
      color: "blue"
    },
    {
      title: "Ginou Jisshuusei",
      subtitle: "Program Magang Jepang",
      desc: "Pelatihan kerja sambil belajar budaya kerja di perusahaan ternama Jepang selama 1-3 tahun.",
      icon: <GraduationCap className="w-10 h-10" />,
      image: "https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&q=80&w=800",
      sectors: ["Manufacturing", "Welding", "Packaging", "Fishing"],
      color: "red"
    },
    {
      title: "Language Course",
      subtitle: "Kursus Intensif Bahasa",
      desc: "Persiapan matang untuk menghadapi ujian kemampuan bahasa Jepang JLPT dan JFT-Basic.",
      icon: <BookOpen className="w-10 h-10" />,
      image: "https://images.unsplash.com/photo-1528813146033-5183479a9977?auto=format&fit=crop&q=80&w=800",
      sectors: ["Level N5", "Level N4", "Level N3", "Kaiwa Session"],
      color: "green"
    }
  ];

  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      <section className="pt-40 pb-20 bg-slate-50 relative overflow-hidden">
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto text-center mb-24 space-y-6">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="inline-flex items-center gap-2 px-4 py-1.5 bg-[var(--sji-red)]/10 text-[var(--sji-red)] rounded-full text-xs font-black uppercase tracking-[0.2em]"
            >
              <ShieldCheck size={14} /> Resmi & Terpercaya
            </motion.div>
            <motion.h1 
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="text-5xl md:text-8xl font-black text-slate-900 leading-none tracking-tighter"
            >
              Program <span className="text-[var(--sji-blue)]">Karier.</span>
            </motion.h1>
            <p className="text-xl text-slate-500 font-medium leading-relaxed max-w-2xl mx-auto">
              SJI menyediakan berbagai jalur karir dan pendidikan di Jepang yang disesuaikan dengan minat dan bakat Anda.
            </p>
          </div>

          <div className="space-y-24 max-w-6xl mx-auto">
            {programs.map((p, i) => (
              <motion.div
                key={p.title}
                initial={{ opacity: 0, y: 50 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                className={`flex flex-col lg:flex-row gap-16 items-center ${i % 2 === 1 ? 'lg:flex-row-reverse' : ''}`}
              >
                <div className="flex-1 space-y-8">
                  <div className="space-y-4">
                    <div className={`w-16 h-16 rounded-2xl flex items-center justify-center ${
                      p.color === 'blue' ? 'bg-blue-50 text-[var(--sji-blue)]' : 
                      p.color === 'red' ? 'bg-red-50 text-[var(--sji-red)]' : 'bg-green-50 text-green-600'
                    }`}>
                      {p.icon}
                    </div>
                    <h2 className="text-4xl font-black text-slate-900 tracking-tight">{p.title}</h2>
                    <p className="text-gray-400 font-black uppercase tracking-widest text-xs">{p.subtitle}</p>
                  </div>
                  
                  <p className="text-lg text-slate-500 font-medium leading-relaxed">{p.desc}</p>
                  
                  <div className="flex flex-wrap gap-3">
                    {p.sectors.map(s => (
                      <span key={s} className="px-5 py-2 bg-white border border-slate-100 text-slate-600 text-sm font-bold rounded-2xl shadow-sm">
                        {s}
                      </span>
                    ))}
                  </div>

                  <div className="pt-6 flex flex-wrap gap-4">
                    <Link href="/registration" className="px-8 py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-slate-800 transition-all flex items-center gap-2 group shadow-xl shadow-black/10">
                      Daftar Sekarang <ArrowRight size={18} className="group-hover:translate-x-1 transition-transform" />
                    </Link>
                    <button className="px-8 py-4 bg-white text-slate-900 font-black rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all">
                      Lihat Kurikulum
                    </button>
                  </div>
                </div>

                <div className="flex-1 relative">
                  <div className="relative aspect-[4/3] w-full rounded-[3rem] overflow-hidden shadow-2xl border-[12px] border-white group">
                    <Image src={p.image} alt={p.title} fill className="object-cover group-hover:scale-110 transition-transform duration-1000" />
                    <div className={`absolute inset-0 bg-gradient-to-t from-${p.color}-900/40 to-transparent opacity-60`}></div>
                  </div>
                  {/* Decorative backdrop */}
                  <div className={`absolute -bottom-10 -right-10 w-64 h-64 bg-${p.color}-500/10 rounded-full blur-3xl -z-10`}></div>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Info Section with image background */}
      <section className="py-32">
        <div className="container mx-auto px-6">
          <div className="bg-slate-900 rounded-[4rem] p-12 lg:p-24 text-white relative overflow-hidden group">
            <div className="absolute inset-0 opacity-20 group-hover:scale-105 transition-transform duration-1000">
              <Image src="https://images.unsplash.com/photo-1480796927426-f609979314bd?auto=format&fit=crop&q=80&w=1200" alt="Consultation" fill className="object-cover" />
            </div>
            <div className="relative z-10 max-w-3xl space-y-8 text-center lg:text-left">
              <h3 className="text-4xl lg:text-6xl font-black leading-tight tracking-tighter">Bingung Pilih Program Yang Mana?</h3>
              <p className="text-slate-300 text-xl font-medium leading-relaxed">Konsultasikan gratis dengan tim ahli kami untuk menentukan jalur karir terbaik Anda di Jepang.</p>
              <div className="pt-4 flex justify-center lg:justify-start">
                <a href="#" className="px-12 py-6 bg-[var(--sji-red)] text-white font-black rounded-3xl shadow-2xl shadow-red-900/40 hover:bg-red-700 hover:scale-105 active:scale-95 transition-all">
                  Hubungi Konsultan SJI
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
