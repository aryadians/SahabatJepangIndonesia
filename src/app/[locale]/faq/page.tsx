'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useTranslations } from "next-intl";
import { motion } from "framer-motion";
import { useState } from "react";
import { ChevronDown, ChevronUp, Search } from "lucide-react";

export default function FAQPage() {
  const t = useTranslations('FAQ');
  const [openIndex, setOpenIndex] = useState<number | null>(0);

  const faqs = [
    {
      q: "Apa syarat utama untuk mendaftar di SJI?",
      a: "Syarat utama adalah lulusan minimal SMA/SMK sederajat, usia 18-26 tahun (bervariasi tergantung program), sehat jasmani & rohani, serta memiliki semangat tinggi untuk belajar bahasa Jepang."
    },
    {
      q: "Berapa lama waktu pelatihan hingga berangkat ke Jepang?",
      a: "Rata-rata waktu pelatihan intensif adalah 4-6 bulan hingga lulus ujian bahasa (JFT-Basic/JLPT N4). Proses administrasi COE dan Visa biasanya memakan waktu tambahan 2-3 bulan."
    },
    {
      q: "Apakah ada biaya pendaftaran?",
      a: "Ya, terdapat biaya pendaftaran untuk administrasi awal. Detail biaya pelatihan dapat dilihat di halaman 'Daftar Kelas' atau hubungi admin kami untuk simulasi biaya total."
    },
    {
      q: "Apa perbedaan program Magang dan SSW (Tokutei Ginou)?",
      a: "Magang berfokus pada pelatihan kerja (Learning by doing) dengan durasi 1-3 tahun. SSW adalah program tenaga kerja ahli dengan durasi hingga 5 tahun dan gaji yang setara dengan pekerja lokal Jepang."
    },
    {
      q: "Apakah SJI membantu mencarikan perusahaan di Jepang?",
      a: "Tentu. SJI adalah Sending Organization (SO) resmi yang bekerja sama dengan banyak Kumiai (Koperasi) dan perusahaan (User) di seluruh penjuru Jepang."
    }
  ];

  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      <section className="pt-32 pb-20">
        <div className="container mx-auto px-4">
          <div className="max-w-3xl mx-auto">
            <div className="text-center mb-16">
              <motion.h1 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                className="text-4xl md:text-5xl font-black text-[var(--sji-blue)] mb-4"
              >
                {t('title')}
              </motion.h1>
              <p className="text-gray-500">{t('subtitle')}</p>
            </div>

            {/* Search Bar Placeholder */}
            <div className="relative mb-12">
              <input type="text" className="w-full px-8 py-5 rounded-[2rem] bg-slate-50 border border-slate-100 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none pl-14" placeholder="Cari pertanyaan Anda..." />
              <Search className="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400" size={20} />
            </div>

            <div className="space-y-4">
              {faqs.map((faq, index) => (
                <motion.div
                  key={index}
                  initial={{ opacity: 0, y: 10 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: index * 0.05 }}
                  className="rounded-3xl border border-slate-100 overflow-hidden bg-white shadow-sm hover:shadow-md transition-shadow"
                >
                  <button
                    onClick={() => setOpenIndex(openIndex === index ? null : index)}
                    className="w-full px-8 py-6 text-left flex items-center justify-between gap-4 group"
                  >
                    <span className="font-bold text-slate-800 text-lg group-hover:text-[var(--sji-blue)] transition-colors">{faq.q}</span>
                    <div className={`p-2 rounded-xl transition-all ${openIndex === index ? 'bg-[var(--sji-blue)] text-white' : 'bg-slate-50 text-slate-400 group-hover:bg-slate-100'}`}>
                      {openIndex === index ? <ChevronUp size={18} /> : <ChevronDown size={18} />}
                    </div>
                  </button>
                  
                  {openIndex === index && (
                    <motion.div
                      initial={{ height: 0, opacity: 0 }}
                      animate={{ height: "auto", opacity: 1 }}
                      className="px-8 pb-8 text-slate-600 leading-relaxed border-t border-slate-50 pt-4"
                    >
                      {faq.a}
                    </motion.div>
                  )}
                </motion.div>
              ))}
            </div>

            <div className="mt-20 p-10 rounded-[3rem] bg-[var(--sji-blue)] text-white text-center">
              <h3 className="text-2xl font-bold mb-4">Masih punya pertanyaan?</h3>
              <p className="text-blue-100 mb-8">Tim kami siap membantu menjawab pertanyaan Anda melalui WhatsApp.</p>
              <a href="#" className="inline-flex items-center gap-2 px-8 py-4 bg-[var(--sji-red)] text-white font-bold rounded-2xl hover:bg-red-700 transition-all shadow-xl shadow-blue-900/40">
                Hubungi Admin Via WhatsApp
              </a>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
