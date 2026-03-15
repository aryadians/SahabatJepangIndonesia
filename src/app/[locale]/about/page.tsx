'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useTranslations } from "next-intl";
import { motion } from "framer-motion";
import { Target, Eye, Award, Users2 } from "lucide-react";

export default function AboutPage() {
  const t = useTranslations('About');

  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      {/* Hero Section */}
      <section className="pt-32 pb-20 bg-gradient-to-b from-blue-50 to-white overflow-hidden">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto text-center">
            <motion.h1 
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="text-4xl md:text-6xl font-black text-[var(--sji-blue)] mb-6"
            >
              Sahabat Jepang Indonesia
            </motion.h1>
            <motion.p 
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.1 }}
              className="text-xl text-gray-600 leading-relaxed"
            >
              {t('description')}
            </motion.p>
          </div>
        </div>
      </section>

      {/* Vision & Mission */}
      <section className="py-24">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-12">
            <motion.div 
              initial={{ opacity: 0, x: -20 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              className="p-10 rounded-[3rem] bg-blue-50 border border-blue-100"
            >
              <div className="w-14 h-14 bg-[var(--sji-blue)] rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-blue-900/20">
                <Eye size={28} />
              </div>
              <h2 className="text-3xl font-bold text-gray-900 mb-6">{t('vision')}</h2>
              <p className="text-gray-700 leading-relaxed italic">
                "Menjadi lembaga pelatihan kerja terdepan di Indonesia yang dipercaya secara global dalam mencetak tenaga kerja profesional dan berintegritas untuk masa depan Indonesia-Jepang."
              </p>
            </motion.div>

            <motion.div 
              initial={{ opacity: 0, x: 20 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              className="p-10 rounded-[3rem] bg-red-50 border border-red-100"
            >
              <div className="w-14 h-14 bg-[var(--sji-red)] rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-red-900/20">
                <Target size={28} />
              </div>
              <h2 className="text-3xl font-bold text-gray-900 mb-6">{t('mission')}</h2>
              <ul className="space-y-4 text-gray-700">
                <li className="flex gap-3">
                  <div className="w-1.5 h-1.5 rounded-full bg-[var(--sji-red)] mt-2.5 shrink-0"></div>
                  <span>Memberikan pelatihan bahasa dan budaya Jepang berkualitas tinggi.</span>
                </li>
                <li className="flex gap-3">
                  <div className="w-1.5 h-1.5 rounded-full bg-[var(--sji-red)] mt-2.5 shrink-0"></div>
                  <span>Menjalin kemitraan strategis dengan perusahaan-perusahaan ternama di Jepang.</span>
                </li>
                <li className="flex gap-3">
                  <div className="w-1.5 h-1.5 rounded-full bg-[var(--sji-red)] mt-2.5 shrink-0"></div>
                  <span>Membimbing siswa dalam proses administrasi hingga penempatan kerja.</span>
                </li>
              </ul>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Why Us / Values */}
      <section className="py-24 bg-gray-900 text-white rounded-[4rem] mx-4 mb-20 overflow-hidden relative">
        <div className="container mx-auto px-4 relative z-10">
          <div className="text-center mb-16">
            <h2 className="text-3xl font-bold mb-4">Nilai-Nilai Utama Kami</h2>
            <div className="w-16 h-1 bg-[var(--sji-red)] mx-auto"></div>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div className="text-center space-y-4">
              <div className="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto text-[var(--sji-red)]"><Award size={32} /></div>
              <h4 className="font-bold text-xl">Legalitas Resmi</h4>
              <p className="text-gray-400 text-sm">Izin resmi KEMNAKER RI sebagai Sending Organization (SO).</p>
            </div>
            <div className="text-center space-y-4">
              <div className="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto text-[var(--sji-red)]"><Users2 size={32} /></div>
              <h4 className="font-bold text-xl">Instruktur Ahli</h4>
              <p className="text-gray-400 text-sm">Pengajar berpengalaman dan bersertifikat level N2/N1.</p>
            </div>
            <div className="text-center space-y-4">
              <div className="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto text-[var(--sji-red)]"><Target size={32} /></div>
              <h4 className="font-bold text-xl">Fokus Karier</h4>
              <p className="text-gray-400 text-sm">Bimbingan intensif hingga siswa mendapatkan kontrak kerja.</p>
            </div>
            <div className="text-center space-y-4">
              <div className="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto text-[var(--sji-red)]"><Award size={32} /></div>
              <h4 className="font-bold text-xl">Jejaring Luas</h4>
              <p className="text-gray-400 text-sm">Koneksi dengan puluhan Kumiai dan Perusahaan di Jepang.</p>
            </div>
          </div>
        </div>
        
        {/* Background Decor */}
        <div className="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
      </section>

      <Footer />
    </main>
  );
}
