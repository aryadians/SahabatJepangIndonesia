'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { motion } from "framer-motion";
import { Award, GraduationCap, Languages } from "lucide-react";

export default function TeachersPage() {
  const teachers = [
    {
      name: "Budi Santoso Sensei",
      role: "Kepala Instruktur Bahasa",
      qual: "JLPT N1 Certified",
      exp: "10+ Tahun Mengajar",
      desc: "Lulusan Sastra Jepang UI dengan pengalaman kerja 5 tahun di Tokyo."
    },
    {
      name: "Siti Aminah Sensei",
      role: "Instruktur Kaigo",
      qual: "JLPT N2 Certified",
      exp: "6 Tahun Pengalaman",
      desc: "Spesialis pelatihan perawat lansia (Kaigo) dengan sertifikasi resmi Jepang."
    },
    {
      name: "Tanaka Kenji Sensei",
      role: "Native Speaker / Culture Coach",
      qual: "Japanese Native",
      exp: "8 Tahun di Indonesia",
      desc: "Membantu siswa memahami budaya dan etos kerja profesional di Jepang."
    },
    {
      name: "Ahmad Fauzi Sensei",
      role: "Instruktur Teknik",
      qual: "JLPT N3 Certified",
      exp: "Ex-Internship Japan",
      desc: "Alumni magang Jepang yang kini mendedikasikan diri melatih calon pekerja teknik."
    }
  ];

  return (
    <main className="min-h-screen bg-slate-50">
      <Header />
      
      <section className="pt-32 pb-20">
        <div className="container mx-auto px-4 text-center mb-20">
          <motion.h1 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="text-5xl md:text-6xl font-black text-[var(--sji-blue)] mb-6"
          >
            Tim Pengajar Kami
          </motion.h1>
          <p className="text-xl text-gray-500 max-w-2xl mx-auto">
            Dibimbing oleh para Sensei berpengalaman dan bersertifikat internasional untuk menjamin kualitas kelulusan Anda.
          </p>
        </div>

        <div className="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {teachers.map((t, i) => (
            <motion.div
              key={t.name}
              initial={{ opacity: 0, scale: 0.9 }}
              whileInView={{ opacity: 1, scale: 1 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 hover:shadow-2xl transition-all group"
            >
              <div className="w-32 h-32 bg-slate-100 rounded-3xl mx-auto mb-6 overflow-hidden flex items-center justify-center text-slate-300 font-black text-3xl group-hover:bg-blue-50 group-hover:text-[var(--sji-blue)] transition-colors">
                PHOTO
              </div>
              <div className="text-center space-y-2">
                <h3 className="text-xl font-bold text-slate-900 leading-tight">{t.name}</h3>
                <p className="text-[var(--sji-red)] text-xs font-black uppercase tracking-widest">{t.role}</p>
                
                <div className="flex flex-col gap-2 pt-4 border-t border-slate-50 mt-4">
                  <div className="flex items-center gap-2 text-xs text-slate-500">
                    <Award size={14} className="text-[var(--sji-blue)]" />
                    <span>{t.qual}</span>
                  </div>
                  <div className="flex items-center gap-2 text-xs text-slate-500">
                    <Languages size={14} className="text-[var(--sji-blue)]" />
                    <span>{t.exp}</span>
                  </div>
                </div>
                
                <p className="text-sm text-slate-400 leading-relaxed pt-4 italic">"{t.desc}"</p>
              </div>
            </motion.div>
          ))}
        </div>
      </section>

      <Footer />
    </main>
  );
}
