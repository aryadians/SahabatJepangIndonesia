'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { motion } from "framer-motion";
import { Link } from "@/i18n/routing";
import { Briefcase, GraduationCap, BookOpen, MapPin, Building2, Search } from "lucide-react";

export default function ProgramsPage() {
  const programs = [
    {
      title: "Tokutei Ginou (SSW)",
      subtitle: "Specified Skilled Worker",
      desc: "Program tenaga kerja ahli untuk Anda yang memiliki kompetensi khusus di bidang tertentu.",
      icon: <Briefcase className="w-10 h-10" />,
      sectors: ["Kaigo", "Food Service", "Agriculture", "Construction", "Hospitality"],
      color: "blue"
    },
    {
      title: "Ginou Jisshuusei",
      subtitle: "Program Magang Jepang",
      desc: "Pelatihan kerja sambil belajar budaya kerja di perusahaan ternama Jepang selama 1-3 tahun.",
      icon: <GraduationCap className="w-10 h-10" />,
      sectors: ["Manufacturing", "Welding", "Packaging", "Fishing"],
      color: "red"
    },
    {
      title: "Language Course",
      subtitle: "Kursus Intensif Bahasa",
      desc: "Persiapan matang untuk menghadapi ujian kemampuan bahasa Jepang JLPT dan JFT-Basic.",
      icon: <BookOpen className="w-10 h-10" />,
      sectors: ["Level N5", "Level N4", "Level N3", "Kaiwa Session"],
      color: "green"
    }
  ];

  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      <section className="pt-32 pb-20 bg-slate-50">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto text-center mb-20">
            <motion.h1 
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="text-5xl md:text-6xl font-black text-[var(--sji-blue)] mb-6"
            >
              Program Kami
            </motion.h1>
            <p className="text-xl text-gray-500 leading-relaxed">
              SJI menyediakan berbagai jalur karir dan pendidikan di Jepang yang disesuaikan dengan minat dan bakat Anda.
            </p>
          </div>

          <div className="space-y-12 max-w-5xl mx-auto">
            {programs.map((p, i) => (
              <motion.div
                key={p.title}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="bg-white rounded-[3.5rem] p-10 lg:p-16 shadow-sm border border-slate-100 flex flex-col lg:flex-row gap-12 group hover:shadow-2xl transition-all duration-500"
              >
                <div className={`w-24 h-24 shrink-0 rounded-[2rem] flex items-center justify-center ${
                  p.color === 'blue' ? 'bg-blue-50 text-[var(--sji-blue)]' : 
                  p.color === 'red' ? 'bg-red-50 text-[var(--sji-red)]' : 'bg-green-50 text-green-600'
                }`}>
                  {p.icon}
                </div>

                <div className="flex-1 space-y-6">
                  <div>
                    <h2 className="text-3xl font-black text-slate-900 group-hover:text-[var(--sji-blue)] transition-colors">{p.title}</h2>
                    <p className="text-gray-400 font-bold uppercase tracking-widest text-sm mt-1">{p.subtitle}</p>
                  </div>
                  <p className="text-gray-600 text-lg leading-relaxed">{p.desc}</p>
                  
                  <div className="flex flex-wrap gap-3">
                    {p.sectors.map(s => (
                      <span key={s} className="px-5 py-2 bg-slate-50 text-slate-500 text-sm font-bold rounded-2xl group-hover:bg-white group-hover:border-slate-200 border border-transparent transition-all">
                        {s}
                      </span>
                    ))}
                  </div>

                  <div className="pt-6 flex flex-col sm:flex-row gap-4">
                    <Link href={`/programs/${p.title.toLowerCase().replace(/ /g, '-')}`} className="px-8 py-4 bg-[var(--sji-blue)] text-white font-bold rounded-2xl hover:bg-blue-700 transition-all text-center">
                      Pelajari Kurikulum
                    </Link>
                    <Link href="/registration" className="px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all text-center">
                      Daftar Program
                    </Link>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Info Section */}
      <section className="py-24">
        <div className="container mx-auto px-4">
          <div className="bg-[var(--sji-blue)] rounded-[4rem] p-12 lg:p-24 text-white relative overflow-hidden">
            <div className="relative z-10 max-w-3xl">
              <h3 className="text-4xl lg:text-5xl font-black mb-8 leading-tight">Bingung Pilih Program Yang Mana?</h3>
              <p className="text-blue-100 text-xl mb-12 leading-relaxed">Konsultasikan gratis dengan tim ahli kami untuk menentukan jalur karir terbaik Anda di Jepang.</p>
              <div className="flex flex-wrap gap-4">
                <a href="#" className="px-10 py-5 bg-[var(--sji-red)] text-white font-bold rounded-2xl shadow-xl shadow-blue-900/40 hover:bg-red-700 transition-all">
                  Konsultasi Gratis Sekarang
                </a>
              </div>
            </div>
            {/* Abstract Background */}
            <div className="absolute top-0 right-0 w-1/2 h-full bg-white opacity-5 -translate-y-1/2 translate-x-1/2 rounded-full"></div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
