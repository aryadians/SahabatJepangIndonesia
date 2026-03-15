'use client';

import { useState, useEffect } from 'react';
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useTranslations } from "next-intl";
import { motion, AnimatePresence } from "framer-motion";
import { ChevronDown, ChevronUp, Search, Loader2, HelpCircle, Sparkles, ShieldCheck, Globe, Zap } from "lucide-react";

export default function FAQPage() {
  const t = useTranslations('FAQ');
  const [openIndex, setOpenIndex] = useState<number | null>(0);
  const [faqs, setFaqs] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState('');

  useEffect(() => {
    fetch('/api/admin/faq')
      .then(res => res.json())
      .then(data => {
        if (Array.isArray(data)) setFaqs(data);
      })
      .finally(() => setLoading(false));
  }, []);

  const filteredFaqs = faqs.filter(faq => 
    faq.question.toLowerCase().includes(searchTerm.toLowerCase()) ||
    faq.answer.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      <section className="pt-40 pb-24 relative overflow-hidden">
        {/* Background Decor */}
        <div className="absolute top-0 left-0 w-full h-full bg-slate-50/50 -z-10"></div>
        
        <div className="container mx-auto px-6">
          <div className="max-w-4xl mx-auto">
            
            {/* Header Polish */}
            <div className="text-center mb-20 space-y-6">
              <motion.div
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                className="inline-flex items-center gap-2 px-5 py-2 bg-blue-50 text-[var(--sji-blue)] rounded-full text-xs font-black uppercase tracking-[0.3em]"
              >
                <HelpCircle size={14} /> Knowledge Center
              </motion.div>
              <motion.h1 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                className="text-5xl md:text-8xl font-black text-slate-900 leading-none tracking-tighter"
              >
                Apa Yang Bisa Kami <span className="text-[var(--sji-blue)]">Bantu?</span>
              </motion.h1>
              <p className="text-xl text-slate-500 font-medium max-w-2xl mx-auto leading-relaxed">{t('subtitle')}</p>
            </div>

            {/* Elite Search Bar */}
            <div className="relative mb-16 group">
              <input 
                type="text" 
                className="w-full px-10 py-7 rounded-[2.5rem] bg-white border border-slate-100 shadow-[0_20px_50px_-10px_rgba(0,0,0,0.05)] group-focus-within:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] transition-all outline-none pl-16 font-bold text-slate-700 text-lg" 
                placeholder="Ketik pertanyaan Anda di sini..." 
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
              <Search className="absolute left-7 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[var(--sji-blue)] transition-colors" size={24} />
              <div className="absolute right-6 top-1/2 -translate-y-1/2 hidden md:flex items-center gap-2">
                <span className="text-[10px] font-black text-slate-300 uppercase tracking-widest bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">Press Enter</span>
              </div>
            </div>

            {loading ? (
              <div className="p-20 text-center"><Loader2 className="animate-spin mx-auto text-[var(--sji-blue)]" /></div>
            ) : (
              <div className="space-y-6">
                {filteredFaqs.map((faq, index) => (
                  <motion.div
                    key={faq.id}
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: index * 0.05 }}
                    className={`rounded-[3rem] border transition-all duration-500 overflow-hidden ${
                      openIndex === index ? 'bg-white border-blue-100 shadow-2xl' : 'bg-white/50 border-slate-100 hover:border-slate-200'
                    }`}
                  >
                    <button
                      onClick={() => setOpenIndex(openIndex === index ? null : index)}
                      className="w-full px-10 py-8 text-left flex items-center justify-between gap-6 group"
                    >
                      <div className="flex items-center gap-6 flex-1">
                        <div className={`w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 transition-all duration-500 ${
                          openIndex === index ? 'bg-[var(--sji-blue)] text-white shadow-lg' : 'bg-slate-100 text-slate-400 group-hover:bg-blue-50 group-hover:text-[var(--sji-blue)]'
                        }`}>
                          {index % 4 === 0 ? <Globe size={20} /> : index % 4 === 1 ? <Zap size={20} /> : index % 4 === 2 ? <ShieldCheck size={20} /> : <Sparkles size={20} />}
                        </div>
                        <span className="font-black text-slate-800 text-xl leading-tight group-hover:text-[var(--sji-blue)] transition-colors">{faq.question}</span>
                      </div>
                      <div className={`w-10 h-10 rounded-full flex items-center justify-center shrink-0 transition-all duration-500 ${openIndex === index ? 'bg-slate-900 text-white rotate-180' : 'bg-slate-50 text-slate-400'}`}>
                        <ChevronDown size={20} />
                      </div>
                    </button>
                    
                    <AnimatePresence>
                      {openIndex === index && (
                        <motion.div
                          initial={{ height: 0, opacity: 0 }}
                          animate={{ height: "auto", opacity: 1 }}
                          exit={{ height: 0, opacity: 0 }}
                          className="overflow-hidden"
                        >
                          <div className="px-10 pb-10 text-slate-500 font-medium leading-relaxed text-lg border-t border-slate-50 pt-8 ml-[4.5rem] mr-10">
                            {faq.answer}
                          </div>
                        </motion.div>
                      )}
                    </AnimatePresence>
                  </motion.div>
                ))}
                
                {filteredFaqs.length === 0 && (
                  <div className="text-center p-20 bg-white rounded-[3rem] border border-dashed border-slate-200">
                    <p className="text-slate-400 font-black uppercase tracking-widest">Maaf, pertanyaan tidak ditemukan.</p>
                  </div>
                )}
              </div>
            )}

            <motion.div 
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              className="mt-24 p-12 lg:p-20 rounded-[5rem] bg-slate-900 text-white text-center relative overflow-hidden group shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)]"
            >
              <div className="relative z-10 space-y-8">
                <h3 className="text-4xl lg:text-6xl font-black tracking-tight leading-none">Belum Menemukan <br /> Jawaban?</h3>
                <p className="text-slate-400 font-medium text-lg max-w-md mx-auto leading-relaxed">Tim ahli kami siap memberikan konsultasi gratis dan mendalam mengenai program karir di Jepang.</p>
                <div className="pt-4">
                  <a href="https://wa.me/6281333270022" className="inline-flex items-center gap-4 px-12 py-6 bg-[var(--sji-red)] text-white font-black rounded-3xl hover:bg-red-700 hover:scale-105 transition-all shadow-2xl shadow-red-900/40 text-lg">
                    Hubungi WhatsApp Admin
                  </a>
                </div>
              </div>
              
              {/* Extreme Background Decor */}
              <div className="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-[var(--sji-blue)]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
              <div className="absolute bottom-0 left-0 w-96 h-96 bg-[var(--sji-red)] rounded-full blur-[120px] opacity-10 -translate-x-1/2 translate-y-1/2"></div>
            </motion.div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
