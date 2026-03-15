'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useTranslations } from "next-intl";
import { motion } from "framer-motion";
import { CheckCircle2, Clock, Wallet } from "lucide-react";
import { Link } from "@/i18n/routing";

export default function ClassesPage() {
  const t = useTranslations('Classes');

  const classes = [
    {
      title: "Tokutei Ginou (SSW) - Kaigo",
      category: "SSW",
      price: "Rp 5.500.000",
      duration: "4 Bulan",
      features: ["JF-Test A2 / JLPT N4", "Skill Card Kaigo", "Wawancara User", "Bantuan COE"],
      popular: true
    },
    {
      title: "Magang Jepang (Ginou Jisshuusei)",
      category: "Magang",
      price: "Rp 4.500.000",
      duration: "6 Bulan",
      features: ["Pelatihan Fisik & Mental", "Bahasa Dasar N5-N4", "Budaya Kerja Jepang", "Asrama & Makan"],
      popular: false
    },
    {
      title: "Kursus Intensif JLPT N4",
      category: "Kursus",
      price: "Rp 2.500.000",
      duration: "3 Bulan",
      features: ["Materi JLPT N4", "Simulasi Ujian Mingguan", "Native Speaker Session", "Sertifikat LPK"],
      popular: false
    }
  ];

  return (
    <main className="min-h-screen bg-slate-50">
      <Header />
      
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto text-center mb-16">
          <motion.h1 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="text-4xl md:text-5xl font-extrabold text-[var(--sji-blue)] mb-4"
          >
            {t('title')}
          </motion.h1>
          <p className="text-gray-500 max-w-2xl mx-auto">{t('subtitle')}</p>
        </div>

        <div className="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
          {classes.map((item, index) => (
            <motion.div
              key={item.title}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.1 }}
              className={`relative bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 flex flex-col ${
                item.popular ? 'ring-4 ring-[var(--sji-blue)]/10 scale-105 z-10' : ''
              }`}
            >
              {item.popular && (
                <span className="absolute -top-4 left-1/2 -translate-x-1/2 bg-[var(--sji-red)] text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                  Terpopuler
                </span>
              )}

              <div className="mb-8">
                <span className="text-xs font-bold text-[var(--sji-red)] uppercase tracking-widest bg-red-50 px-3 py-1 rounded-full mb-4 inline-block">
                  {item.category}
                </span>
                <h3 className="text-2xl font-bold text-gray-900 leading-tight">{item.title}</h3>
              </div>

              <div className="space-y-4 mb-8">
                <div className="flex items-center gap-3 text-gray-600">
                  <Wallet size={18} className="text-[var(--sji-blue)]" />
                  <div className="text-sm">
                    <span className="text-gray-400 block text-xs">{t('price_start')}</span>
                    <span className="font-bold text-gray-900 text-xl">{item.price}</span>
                  </div>
                </div>
                <div className="flex items-center gap-3 text-gray-600">
                  <Clock size={18} className="text-[var(--sji-blue)]" />
                  <span className="text-sm font-medium">{item.duration}</span>
                </div>
              </div>

              <div className="space-y-3 mb-10 flex-1">
                {item.features.map((feature) => (
                  <div key={feature} className="flex items-start gap-3 text-sm text-gray-600">
                    <CheckCircle2 size={16} className="text-green-500 mt-0.5 shrink-0" />
                    <span>{feature}</span>
                  </div>
                ))}
              </div>

              <Link
                href="/registration"
                className={`w-full py-4 rounded-2xl font-bold text-center transition-all ${
                  item.popular 
                    ? 'bg-[var(--sji-blue)] text-white shadow-xl shadow-blue-900/20 hover:bg-blue-700' 
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                }`}
              >
                {t('join')}
              </Link>
            </motion.div>
          ))}
        </div>
      </div>

      <Footer />
    </main>
  );
}
