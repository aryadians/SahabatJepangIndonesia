'use client';

import { useState, useEffect } from 'react';
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useTranslations } from "next-intl";
import { motion } from "framer-motion";
import { CheckCircle2, Clock, Wallet, Loader2 } from "lucide-react";
import { Link } from "@/i18n/routing";

export default function ClassesPage() {
  const t = useTranslations('Classes');
  const [classes, setClasses] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch('/api/admin/classes')
      .then(res => res.json())
      .then(data => {
        if (Array.isArray(data)) setClasses(data);
      })
      .finally(() => setLoading(false));
  }, []);

  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      <div className="pt-40 pb-24 px-6">
        <div className="container mx-auto text-center mb-20 space-y-4">
          <motion.h1 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="text-5xl md:text-7xl font-black text-slate-900 tracking-tight"
          >
            {t('title')}
          </motion.h1>
          <p className="text-xl text-slate-500 font-medium max-w-2xl mx-auto">{t('subtitle')}</p>
        </div>

        {loading ? (
          <div className="p-20 text-center"><Loader2 className="animate-spin mx-auto text-[var(--sji-blue)]" /></div>
        ) : (
          <div className="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            {classes.map((item, index) => (
              <motion.div
                key={item.id}
                initial={{ opacity: 0, y: 30 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.1 }}
                className={`relative bg-white rounded-[3.5rem] p-12 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] border border-slate-50 flex flex-col group hover:shadow-[0_40px_80px_-15px_rgba(0,0,0,0.1)] transition-all duration-500 ${
                  item.isPopular ? 'ring-4 ring-[var(--sji-blue)]/10 lg:scale-105 z-10 bg-gradient-to-b from-blue-50/20 to-white' : ''
                }`}
              >
                {item.isPopular && (
                  <span className="absolute top-8 right-8 bg-[var(--sji-red)] text-white text-[10px] font-black px-4 py-1.5 rounded-xl uppercase tracking-[0.2em] shadow-lg shadow-red-500/20">
                    Popular
                  </span>
                )}

                <div className="mb-10">
                  <span className="text-[10px] font-black text-[var(--sji-red)] uppercase tracking-[0.2em] bg-red-50 px-4 py-1.5 rounded-xl mb-6 inline-block">
                    {item.category}
                  </span>
                  <h3 className="text-3xl font-black text-slate-900 leading-tight group-hover:text-[var(--sji-blue)] transition-colors">{item.title}</h3>
                </div>

                <div className="space-y-6 mb-10">
                  <div className="flex items-center gap-4 text-slate-600">
                    <div className="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-[var(--sji-blue)] shadow-inner">
                      <Wallet size={20} />
                    </div>
                    <div>
                      <span className="text-slate-400 block text-[10px] font-black uppercase tracking-widest">{t('price_start')}</span>
                      <span className="font-black text-slate-900 text-2xl tracking-tighter">{item.price}</span>
                    </div>
                  </div>
                  <div className="flex items-center gap-4 text-slate-600">
                    <div className="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-[var(--sji-red)] shadow-inner">
                      <Clock size={20} />
                    </div>
                    <span className="text-sm font-black uppercase tracking-widest text-slate-700">{item.duration} Pelatihan</span>
                  </div>
                </div>

                <div className="space-y-4 mb-12 flex-1">
                  {item.features.split(',').map((feature: string) => (
                    <div key={feature} className="flex items-start gap-4 text-slate-500 font-medium">
                      <CheckCircle2 size={18} className="text-green-500 mt-0.5 shrink-0" />
                      <span className="text-sm">{feature.trim()}</span>
                    </div>
                  ))}
                </div>

                <Link
                  href="/registration"
                  className={`w-full py-5 rounded-[1.5rem] font-black text-center transition-all ${
                    item.isPopular 
                      ? 'bg-[var(--sji-blue)] text-white shadow-2xl shadow-blue-900/30 hover:bg-blue-700' 
                      : 'bg-slate-900 text-white hover:bg-slate-800'
                  }`}
                >
                  {t('join')}
                </Link>
              </motion.div>
            ))}
          </div>
        )}
      </div>

      <Footer />
    </main>
  );
}
