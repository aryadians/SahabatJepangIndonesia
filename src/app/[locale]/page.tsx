'use client';

import { useState, useEffect } from 'react';
import Header from "@/components/layout/Header";
import Hero from "@/components/home/Hero";
import Stats from "@/components/home/Stats";
import Programs from "@/components/home/Programs";
import RegistrationWizard from "@/components/home/RegistrationWizard";
import Footer from "@/components/layout/Footer";
import { Link } from "@/i18n/routing";
import { Star, Quote, ArrowRight, ShieldCheck, Zap, Globe, Heart, Award } from "lucide-react";
import { motion } from "framer-motion";
import Image from 'next/image';

export default function HomePage() {
  const [partners, setPartners] = useState<any[]>([]);

  useEffect(() => {
    fetch('/api/partners')
      .then(res => res.json())
      .then(data => {
        if (Array.isArray(data)) setPartners(data);
      });
  }, []);

  const testimonials = [
    {
      name: "Ahmad Fauzi",
      program: "Tokutei Ginou - Kaigo",
      text: "Terima kasih SJI! Pelatihan bahasanya sangat intensif dan menyenangkan. Sekarang saya sudah bekerja di Osaka.",
      location: "Tokyo, Japan"
    },
    {
      name: "Siti Aminah",
      program: "Magang - Food Processing",
      text: "Metode Kitte Mitte Oboite sangat membantu saya yang nol bahasa Jepang hingga bisa lulus N4 dalam 4 bulan.",
      location: "Chiba, Japan"
    },
    {
      name: "Budi Santoso",
      program: "Tokutei Ginou - Construction",
      text: "Proses administrasi COE dan Visa dibantu sepenuhnya oleh tim SJI. Sangat terpercaya dan profesional.",
      location: "Nagoya, Japan"
    }
  ];

  return (
    <main className="min-h-screen bg-white selection:bg-[var(--sji-blue)] selection:text-white">
      <Header />
      <Hero />
      <Stats />

      {/* About Summary Section - Elite Polish */}
      <section className="py-32 bg-white relative overflow-hidden">
        <div className="container mx-auto px-6">
          <div className="flex flex-col lg:flex-row items-center gap-24">
            <div className="lg:w-1/2 relative group">
              <div className="relative z-10">
                <motion.div 
                  initial={{ rotate: -2 }}
                  whileInView={{ rotate: 0 }}
                  viewport={{ once: true }}
                  className="w-full aspect-[4/3] bg-slate-100 rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] border-[16px] border-white overflow-hidden relative"
                >
                  <Image src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=1000" alt="SJI Office" fill className="object-cover" />
                  <div className="absolute inset-0 bg-blue-900/10 mix-blend-multiply"></div>
                </motion.div>
                
                {/* Floating dynamic badges */}
                <motion.div 
                  animate={{ y: [0, -20, 0] }}
                  transition={{ duration: 4, repeat: Infinity, ease: "easeInOut" }}
                  className="absolute -bottom-8 -right-8 w-44 h-44 bg-[var(--sji-red)] rounded-[3.5rem] flex flex-col items-center justify-center text-white shadow-2xl shadow-red-500/40 rotate-12 group-hover:rotate-0 transition-transform duration-700"
                >
                  <span className="font-black text-6xl">10+</span>
                  <span className="text-[10px] font-black uppercase tracking-[0.3em]">Years of Glory</span>
                </motion.div>

                <motion.div 
                  animate={{ y: [0, 20, 0] }}
                  transition={{ duration: 5, repeat: Infinity, ease: "easeInOut" }}
                  className="absolute -top-10 -left-10 p-6 bg-white rounded-[2rem] shadow-2xl border border-slate-50 flex items-center gap-4 z-20"
                >
                  <div className="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600"><ShieldCheck size={24} /></div>
                  <div>
                    <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Akreditasi</p>
                    <p className="text-sm font-black text-slate-900">Resmi Kemnaker</p>
                  </div>
                </motion.div>
              </div>
              {/* Decorative background glow */}
              <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140%] h-[140%] bg-blue-50/40 rounded-full blur-[120px] -z-10"></div>
            </div>

            <div className="lg:w-1/2 space-y-12">
              <div className="space-y-6">
                <motion.div 
                  initial={{ opacity: 0, x: 20 }}
                  whileInView={{ opacity: 1, x: 0 }}
                  viewport={{ once: true }}
                  className="inline-flex items-center gap-2 px-5 py-2 bg-blue-50 text-[var(--sji-blue)] rounded-full text-xs font-black uppercase tracking-[0.3em]"
                >
                  <Globe size={14} className="animate-spin-slow" /> Connecting Indonesia to Japan
                </motion.div>
                <h2 className="text-5xl lg:text-7xl font-black text-slate-900 leading-[1.1] tracking-tighter">
                  Mencetak <span className="text-[var(--sji-blue)]">Pemimpin</span> <br /> Masa Depan.
                </h2>
              </div>
              
              <p className="text-xl text-slate-500 font-medium leading-relaxed max-w-xl">
                Sejak berdiri, SJI telah berkomitmen untuk menjadi jembatan bagi putra-putri terbaik bangsa untuk meraih impian mereka berkarir secara profesional di Negeri Sakura. Kami tidak hanya mengajarkan bahasa, tapi juga mentalitas dan etos kerja Jepang.
              </p>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-10 pt-4">
                <div className="flex gap-5 group">
                  <div className="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-[var(--sji-red)] shrink-0 group-hover:bg-[var(--sji-red)] group-hover:text-white transition-all duration-500 shadow-inner">
                    <Zap size={24} fill="currentColor" />
                  </div>
                  <div>
                    <h4 className="font-black text-slate-900 mb-1">Proses Cepat</h4>
                    <p className="text-sm text-slate-500 font-medium">Pelatihan intensif 4-6 bulan hingga siap terbang.</p>
                  </div>
                </div>
                <div className="flex gap-5 group">
                  <div className="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-[var(--sji-blue)] shrink-0 group-hover:bg-[var(--sji-blue)] group-hover:text-white transition-all duration-500 shadow-inner">
                    <Heart size={24} fill="currentColor" />
                  </div>
                  <div>
                    <h4 className="font-black text-slate-900 mb-1">Pembimbing Ahli</h4>
                    <p className="text-sm text-slate-500 font-medium">Dipandu oleh Sensei bersertifikat JLPT N1/N2.</p>
                  </div>
                </div>
              </div>

              <div className="pt-8 flex flex-wrap gap-6">
                <Link href="/about" className="inline-flex items-center gap-3 px-10 py-5 bg-slate-900 text-white font-black rounded-3xl hover:bg-slate-800 transition-all shadow-2xl shadow-black/20 group">
                  Tentang SJI <ArrowRight size={20} className="group-hover:translate-x-2 transition-transform" />
                </Link>
                <Link href="/contact" className="inline-flex items-center gap-3 px-10 py-5 bg-white text-slate-900 font-black rounded-3xl border-2 border-slate-100 hover:border-slate-200 transition-all">
                  Hubungi Kami
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>

      <Programs />

      {/* High-End News Preview Section */}
      <section className="py-32 bg-white">
        <div className="container mx-auto px-6">
          <div className="flex flex-col md:flex-row md:items-end justify-between gap-10 mb-20">
            <div className="space-y-4">
              <span className="text-[var(--sji-red)] font-black uppercase tracking-[0.3em] text-xs">Latest Updates</span>
              <h2 className="text-4xl md:text-6xl font-black text-slate-900 tracking-tight leading-none">Berita & Lowongan.</h2>
            </div>
            <Link href="/news" className="inline-flex items-center gap-2 text-slate-900 font-black uppercase tracking-widest text-xs hover:text-[var(--sji-blue)] transition-colors border-b-2 border-slate-900 pb-2">
              Lihat Semua Berita <ArrowRight size={16} />
            </Link>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <motion.div 
              whileHover={{ y: -10 }}
              className="group relative h-[500px] rounded-[4rem] overflow-hidden shadow-2xl"
            >
              <Image src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&q=80&w=1000" alt="News" fill className="object-cover group-hover:scale-110 transition-transform duration-1000" />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
              <div className="absolute bottom-0 left-0 p-12 space-y-4">
                <span className="px-4 py-1 bg-[var(--sji-red)] text-white text-[10px] font-black uppercase tracking-widest rounded-lg">Featured</span>
                <h3 className="text-3xl font-black text-white leading-tight">Pendaftaran Batch 15 Resmi Dibuka: Raih Karier di Jepang!</h3>
                <p className="text-slate-300 font-medium">Jangan lewatkan kesempatan emas bergabung dengan angkatan terbaik tahun ini.</p>
              </div>
            </motion.div>
            
            <div className="space-y-8">
              {[1, 2].map((i) => (
                <Link key={i} href="/news" className="flex flex-col sm:flex-row gap-8 p-8 bg-slate-50 rounded-[3rem] border border-transparent hover:border-slate-200 hover:bg-white transition-all group">
                  <div className="w-full sm:w-48 h-48 relative rounded-[2rem] overflow-hidden shrink-0 shadow-lg">
                    <Image src={`https://images.unsplash.com/photo-1528813146033-5183479a9977?auto=format&fit=crop&q=80&w=500`} alt="News" fill className="object-cover group-hover:scale-110 transition-transform duration-700" />
                  </div>
                  <div className="space-y-4 py-2">
                    <span className="text-[var(--sji-blue)] font-black uppercase tracking-widest text-[10px]">Edukasi • 10 Mar 2026</span>
                    <h4 className="text-xl font-black text-slate-900 group-hover:text-[var(--sji-blue)] transition-colors leading-tight">Tips Lulus JF-Test A2 dalam 4 Bulan Tanpa Kursus Mahal</h4>
                    <p className="text-slate-500 font-medium line-clamp-2">Pelajari metode rahasia Kitte Mitte Oboite yang digunakan ribuan alumni SJI.</p>
                  </div>
                </Link>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Testimonials Section */}
      <section className="py-32 bg-slate-50 relative overflow-hidden rounded-[5rem] mx-4 mb-32">
        <div className="container mx-auto px-6 relative z-10">
          <div className="text-center max-w-3xl mx-auto mb-20 space-y-4">
            <span className="text-[var(--sji-red)] font-black uppercase tracking-[0.2em] text-xs">Voice of Alumni</span>
            <h2 className="text-4xl md:text-6xl font-black text-slate-900 tracking-tight">Apa Kata Mereka?</h2>
            <p className="text-lg text-slate-500 font-medium italic">"Terpercaya, Profesional, dan Berintegritas."</p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            {testimonials.map((t, i) => (
              <div key={i} className="bg-white p-12 rounded-[3.5rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] border border-white relative group hover:shadow-2xl transition-all duration-500 flex flex-col">
                <Quote className="absolute top-10 right-10 text-slate-100 w-16 h-16 -rotate-12 transition-transform group-hover:rotate-0" />
                <div className="flex gap-1 mb-8">
                  {[1, 2, 3, 4, 5].map((s) => (
                    <Star key={s} size={16} className="fill-yellow-400 text-yellow-400" />
                  ))}
                </div>
                <p className="text-slate-600 font-bold leading-relaxed mb-10 relative z-10 italic text-lg">"{t.text}"</p>
                <div className="flex items-center gap-5 border-t border-slate-50 pt-8 mt-auto">
                  <div className="w-14 h-14 rounded-[1.5rem] bg-slate-100 shrink-0 flex items-center justify-center font-black text-slate-300">SJI</div>
                  <div>
                    <h4 className="font-black text-slate-900 leading-none mb-1">{t.name}</h4>
                    <p className="text-[10px] text-[var(--sji-red)] font-black uppercase tracking-widest">{t.program}</p>
                    <p className="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-tighter">{t.location}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
      
      {/* Registration Section on Home */}
      <section className="py-32 bg-white relative overflow-hidden">
        <div className="container mx-auto px-6 relative z-10">
          <div className="text-center mb-20 space-y-4">
            <span className="text-[var(--sji-blue)] font-black uppercase tracking-[0.2em] text-xs">Ready to start?</span>
            <h2 className="text-4xl md:text-6xl font-black text-slate-900 tracking-tight">Mulai Karier Anda Hari Ini</h2>
            <p className="text-lg text-slate-500 max-w-2xl mx-auto font-medium">Jangan tunda impian Anda. Daftar sekarang dan tim kami akan membimbing Anda hingga berangkat ke Jepang.</p>
          </div>
          <RegistrationWizard />
        </div>
      </section>
      
      {/* Official Partners / Mitras (DYNAMIC FROM DB) */}
      <section className="py-24 bg-slate-50 border-t border-slate-100">
        <div className="container mx-auto px-6">
          <p className="text-center text-slate-400 font-black uppercase tracking-[0.3em] text-[10px] mb-16">Mitra Resmi & Sending Organization</p>
          <div className="flex flex-wrap justify-center items-center gap-16 lg:gap-24 opacity-40 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-700">
            {partners.map((p) => (
              <div key={p.id} className="relative h-12 w-32 group">
                <Image src={p.logoUrl} alt={p.name} fill className="object-contain filter" />
                <div className="absolute -bottom-8 left-1/2 -translate-x-1/2 whitespace-nowrap text-[8px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity text-[var(--sji-blue)]">
                  {p.name}
                </div>
              </div>
            ))}
            {partners.length === 0 && (
              <>
                <div className="h-10 w-32 bg-slate-200 rounded-lg animate-pulse"></div>
                <div className="h-10 w-32 bg-slate-200 rounded-lg animate-pulse"></div>
                <div className="h-10 w-32 bg-slate-200 rounded-lg animate-pulse"></div>
              </>
            )}
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
