'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useTranslations } from "next-intl";
import { motion } from "framer-motion";
import { Link } from "@/i18n/routing";
import { Calendar, User, ArrowRight } from "lucide-react";

export default function NewsPage() {
  const t = useTranslations('News');

  const newsItems = [
    {
      id: 1,
      title: "Pendaftaran Batch 15 Resmi Dibuka!",
      excerpt: "Bagi Anda yang ingin berkarir di bidang Kaigo atau Pengolahan Makanan, pendaftaran Batch 15 kini telah dibuka.",
      date: "10 Mar 2026",
      author: "Admin SJI",
      category: "Pendaftaran"
    },
    {
      id: 2,
      title: "Success Story: Ahmad Fauzi Berangkat ke Tokyo",
      excerpt: "Salah satu alumni terbaik SJI, Ahmad Fauzi, telah resmi berangkat untuk program Tokutei Ginou bidang Konstruksi.",
      date: "05 Mar 2026",
      author: "Admin SJI",
      category: "Berita"
    },
    {
      id: 3,
      title: "Tips Lulus JF-Test A2 dalam 4 Bulan",
      excerpt: "Pelajari metode belajar intensif Kitte Mitte Oboite yang membantu siswa SJI lulus ujian bahasa dengan cepat.",
      date: "01 Mar 2026",
      author: "Sensei SJI",
      category: "Edukasi"
    }
  ];

  return (
    <main className="min-h-screen bg-slate-50">
      <Header />
      
      <section className="pt-32 pb-20">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <motion.h1 
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="text-4xl md:text-5xl font-black text-[var(--sji-blue)] mb-4"
            >
              {t('title')}
            </motion.h1>
            <p className="text-gray-500 max-w-2xl mx-auto">{t('subtitle')}</p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {newsItems.map((item, index) => (
              <motion.div
                key={item.id}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.1 }}
                className="bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl transition-all border border-gray-100 group"
              >
                {/* Image Placeholder */}
                <div className="aspect-[16/10] bg-gray-100 relative overflow-hidden flex items-center justify-center text-gray-400 font-bold group-hover:scale-105 transition-transform duration-500">
                  [ Thumbnail Image ]
                </div>

                <div className="p-8 space-y-4">
                  <div className="flex items-center gap-4 text-xs text-gray-400 font-bold uppercase tracking-widest">
                    <span className="text-[var(--sji-red)]">{item.category}</span>
                    <span>•</span>
                    <div className="flex items-center gap-1">
                      <Calendar size={12} />
                      {item.date}
                    </div>
                  </div>

                  <h3 className="text-xl font-bold text-gray-900 group-hover:text-[var(--sji-blue)] transition-colors leading-tight">
                    {item.title}
                  </h3>
                  
                  <p className="text-gray-500 text-sm leading-relaxed line-clamp-3">
                    {item.excerpt}
                  </p>

                  <div className="pt-4 flex items-center justify-between border-t border-gray-50">
                    <div className="flex items-center gap-2 text-xs font-bold text-gray-700">
                      <div className="w-6 h-6 rounded-full bg-slate-100"></div>
                      {item.author}
                    </div>
                    <Link href={`/news/${item.id}`} className="text-[var(--sji-blue)] font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all">
                      {t('read_more')} <ArrowRight size={14} />
                    </Link>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
