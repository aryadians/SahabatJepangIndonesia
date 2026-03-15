'use client';

import { useTranslations } from 'next-intl';
import { motion } from 'framer-motion';
import { ChevronRight, PlayCircle, ShieldCheck, Zap } from 'lucide-react';
import { Link } from '@/i18n/routing';
import Image from 'next/image';

export default function Hero() {
  const t = useTranslations('HomePage');

  return (
    <section className="relative pt-32 pb-24 lg:pt-52 lg:pb-40 overflow-hidden bg-white">
      {/* Background Decor */}
      <div className="absolute top-0 right-0 -z-10 opacity-20 pointer-events-none">
        <svg width="800" height="800" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="600" cy="200" r="300" fill="url(#grad1)" />
          <defs>
            <linearGradient id="grad1" x1="300" y1="-100" x2="900" y2="500" gradientUnits="userSpaceOnUse">
              <stop stopColor="var(--sji-blue)" />
              <stop offset="1" stopColor="var(--sji-red)" />
            </linearGradient>
          </defs>
        </svg>
      </div>

      <div className="container mx-auto px-6">
        <div className="flex flex-col lg:flex-row items-center gap-20">
          <div className="flex-1 text-center lg:text-left space-y-8">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              className="inline-flex items-center gap-2 px-5 py-2 mb-2 text-sm font-black tracking-widest text-[var(--sji-red)] uppercase bg-red-50 rounded-2xl border border-red-100"
            >
              <span className="relative flex h-2 w-2">
                <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span className="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
              </span>
              {t('subtitle')}
            </motion.div>
            
            <motion.h1
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.1 }}
              className="text-5xl lg:text-8xl font-black text-slate-900 leading-[1.1] tracking-tighter"
            >
              Wujudkan Karir <br /> Impian di <span className="text-[var(--sji-blue)]">Jepang</span>
            </motion.h1>

            <motion.p
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.2 }}
              className="text-xl text-slate-500 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-medium"
            >
              {t('hero_description')}
            </motion.p>

            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.3 }}
              className="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6 pt-4"
            >
              <Link
                href="/registration"
                className="px-10 py-5 bg-[var(--sji-blue)] text-white font-black rounded-2xl shadow-2xl shadow-blue-900/30 hover:bg-blue-700 hover:scale-105 active:scale-95 transition-all flex items-center gap-3 group"
              >
                {t('cta_join')}
                <ChevronRight size={20} className="group-hover:translate-x-1 transition-transform" />
              </Link>
              <button className="flex items-center gap-3 text-slate-900 font-black hover:text-[var(--sji-red)] transition-colors group">
                <div className="w-14 h-14 bg-white rounded-full shadow-xl flex items-center justify-center group-hover:scale-110 transition-all border border-slate-50">
                  <PlayCircle size={28} className="text-[var(--sji-red)]" />
                </div>
                Tonton Video SJI
              </button>
            </motion.div>

            {/* Trust Badges */}
            <motion.div 
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              transition={{ delay: 0.8 }}
              className="pt-12 flex flex-wrap items-center justify-center lg:justify-start gap-8 opacity-60"
            >
              <div className="flex items-center gap-2 text-xs font-black text-slate-400 uppercase tracking-widest">
                <ShieldCheck size={16} className="text-green-500" /> Resmi Kemnaker
              </div>
              <div className="flex items-center gap-2 text-xs font-black text-slate-400 uppercase tracking-widest">
                <Zap size={16} className="text-yellow-500" /> Proses Cepat
              </div>
            </motion.div>
          </div>

          <div className="flex-1 relative">
            <motion.div
              initial={{ opacity: 0, scale: 0.8 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 1, delay: 0.4, type: 'spring' }}
              className="relative z-10"
            >
              <div className="w-full aspect-square max-w-xl mx-auto bg-slate-100 rounded-[4rem] relative overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.15)] border-[12px] border-white group">
                <Image 
                  src="https://images.unsplash.com/photo-1526481280693-3bfa7561693f?auto=format&fit=crop&q=80&w=1000" 
                  alt="Japan Career"
                  fill
                  className="object-cover group-hover:scale-110 transition-transform duration-1000"
                />
                <div className="absolute inset-0 bg-gradient-to-tr from-[var(--sji-blue)]/40 to-transparent"></div>
                
                {/* Dynamic cards */}
                <motion.div
                  animate={{ y: [0, -15, 0] }}
                  transition={{ duration: 4, repeat: Infinity }}
                  className="absolute top-12 left-12 p-4 bg-white/90 backdrop-blur rounded-3xl shadow-2xl flex items-center gap-4 border border-white/50"
                >
                  <div className="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-2xl">🇯🇵</div>
                  <div>
                    <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Status</p>
                    <p className="text-sm font-black text-slate-900 leading-none">Siap Terbang</p>
                  </div>
                </motion.div>

                <motion.div
                  animate={{ y: [0, 15, 0] }}
                  transition={{ duration: 5, repeat: Infinity }}
                  className="absolute bottom-12 right-12 p-4 bg-white/90 backdrop-blur rounded-3xl shadow-2xl flex items-center gap-4 border border-white/50"
                >
                  <div className="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl">🎓</div>
                  <div>
                    <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Lulus</p>
                    <p className="text-sm font-black text-slate-900 leading-none">JLPT N4 Certified</p>
                  </div>
                </motion.div>
              </div>
            </motion.div>
            
            {/* Shapes */}
            <div className="absolute -bottom-10 -right-10 w-64 h-64 bg-[var(--sji-red)]/5 rounded-full blur-3xl -z-10"></div>
            <div className="absolute -top-10 -left-10 w-64 h-64 bg-[var(--sji-blue)]/5 rounded-full blur-3xl -z-10"></div>
          </div>
        </div>
      </div>
    </section>
  );
}
