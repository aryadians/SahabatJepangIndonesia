'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { motion } from "framer-motion";
import { Calendar, User, ArrowLeft, Share2 } from "lucide-react";
import { Link } from "@/i18n/routing";

export default function NewsDetailPage() {
  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      <article className="pt-32 pb-20">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto">
            <Link href="/news" className="inline-flex items-center gap-2 text-slate-400 hover:text-[var(--sji-blue)] font-bold mb-8 transition-colors">
              <ArrowLeft size={18} /> Kembali ke Berita
            </Link>

            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="space-y-8"
            >
              <div className="space-y-4">
                <span className="px-4 py-1.5 bg-red-50 text-[var(--sji-red)] text-xs font-black uppercase tracking-widest rounded-full">Pendaftaran</span>
                <h1 className="text-4xl md:text-6xl font-black text-slate-900 leading-tight">Pendaftaran Batch 15 Resmi Dibuka: Raih Karier di Jepang!</h1>
                
                <div className="flex flex-wrap items-center gap-6 pt-4 border-b border-gray-100 pb-8 text-sm text-gray-500 font-medium">
                  <div className="flex items-center gap-2">
                    <div className="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-400">A</div>
                    By <span className="text-slate-900 font-bold">Admin SJI</span>
                  </div>
                  <div className="flex items-center gap-2">
                    <Calendar size={16} />
                    10 Maret 2026
                  </div>
                  <button className="flex items-center gap-2 hover:text-[var(--sji-blue)] transition-colors">
                    <Share2 size={16} /> Share
                  </button>
                </div>
              </div>

              {/* Cover Image Placeholder */}
              <div className="w-full aspect-video bg-gray-100 rounded-[3rem] shadow-2xl border-8 border-white overflow-hidden flex items-center justify-center text-gray-400 font-bold text-2xl">
                [ Hero Article Image ]
              </div>

              <div className="prose prose-lg max-w-none text-gray-600 leading-relaxed space-y-6">
                <p>
                  Sahabat Jepang Indonesia (SJI) dengan bangga mengumumkan bahwa pendaftaran untuk angkatan terbaru, <strong>Batch 15</strong>, telah resmi dibuka. Program ini dirancang khusus bagi Anda yang serius ingin berkarir di Jepang melalui jalur Tokutei Ginou (SSW) dan Magang.
                </p>
                <h3 className="text-2xl font-bold text-slate-900 pt-4">Kenapa Bergabung di Batch 15?</h3>
                <p>
                  Pada angkatan ini, kami fokus pada sektor-sektor yang memiliki permintaan tinggi di Jepang, antara lain:
                </p>
                <ul className="list-disc pl-6 space-y-2">
                  <li>Kaigo (Perawat Lansia)</li>
                  <li>Food Processing (Pengolahan Makanan)</li>
                  <li>Agriculture (Pertanian)</li>
                  <li>Construction (Konstruksi)</li>
                </ul>
                <p>
                  Siswa akan mendapatkan pelatihan bahasa intensif selama 4-6 bulan menggunakan metode <em>Kitte Mitte Oboite</em> yang telah terbukti membantu ribuan alumni kami lulus ujian JLPT N4 dan JFT-Basic A2 dengan cepat.
                </p>
              </div>

              <div className="mt-16 p-10 rounded-[3rem] bg-slate-50 border border-slate-100 text-center">
                <h4 className="text-2xl font-bold text-slate-900 mb-4">Tertarik Bergabung?</h4>
                <p className="text-slate-500 mb-8">Kuota untuk Batch 15 terbatas. Segera daftarkan diri Anda secara online.</p>
                <Link href="/registration" className="px-10 py-5 bg-[var(--sji-red)] text-white font-bold rounded-2xl shadow-xl shadow-red-900/20 hover:bg-red-700 transition-all inline-block">
                  Daftar Sekarang
                </Link>
              </div>
            </motion.div>
          </div>
        </div>
      </article>

      <Footer />
    </main>
  );
}
