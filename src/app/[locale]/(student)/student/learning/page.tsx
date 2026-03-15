'use client';

import { useState } from 'react';
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { motion } from "framer-motion";
import { BookOpen, PlayCircle, FileText, CheckCircle2, ChevronRight, Lock } from "lucide-react";

export default function LearningPage() {
  const [activeTab, setActiveTab] = useState('lessons');

  const modules = [
    {
      title: "Dasar Bahasa Jepang (N5)",
      lessons: [
        { title: "Hiragana & Katakana", duration: "45m", status: "completed" },
        { title: "Partikel Dasar (Wa, No, Ni)", duration: "60m", status: "completed" },
        { title: "Kata Kerja Bentuk Masu", duration: "90m", status: "current" },
        { title: "Angka & Jam", duration: "45m", status: "locked" },
      ]
    },
    {
      title: "Persiapan Kerja di Jepang",
      lessons: [
        { title: "Etos Kerja & Budaya", duration: "120m", status: "locked" },
        { title: "Komunikasi di Tempat Kerja", duration: "90m", status: "locked" },
      ]
    }
  ];

  return (
    <main className="min-h-screen bg-slate-50">
      <Header />
      
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto max-w-6xl">
          <div className="mb-12">
            <h1 className="text-4xl font-black text-slate-900 mb-2">E-Learning SJI</h1>
            <p className="text-slate-500 font-medium">Akses materi pelatihan bahasa dan budaya kapan saja.</p>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div className="lg:col-span-2 space-y-8">
              {modules.map((mod, i) => (
                <motion.div 
                  key={mod.title}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: i * 0.1 }}
                  className="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden"
                >
                  <div className="p-8 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                    <h3 className="font-bold text-slate-900 flex items-center gap-3">
                      <BookOpen className="text-[var(--sji-blue)]" /> {mod.title}
                    </h3>
                    <span className="text-[10px] font-black text-slate-400 uppercase tracking-widest">{mod.lessons.length} Materi</span>
                  </div>
                  
                  <div className="divide-y divide-slate-50">
                    {mod.lessons.map((lesson) => (
                      <div key={lesson.title} className="p-6 flex items-center justify-between group hover:bg-slate-50/50 transition-all cursor-pointer">
                        <div className="flex items-center gap-4">
                          <div className={`w-10 h-10 rounded-xl flex items-center justify-center ${
                            lesson.status === 'completed' ? 'bg-green-50 text-green-600' :
                            lesson.status === 'current' ? 'bg-blue-50 text-[var(--sji-blue)]' :
                            'bg-slate-50 text-slate-300'
                          }`}>
                            {lesson.status === 'completed' ? <CheckCircle2 size={20} /> : 
                             lesson.status === 'locked' ? <Lock size={18} /> : <PlayCircle size={20} />}
                          </div>
                          <div>
                            <p className={`font-bold text-sm ${lesson.status === 'locked' ? 'text-slate-400' : 'text-slate-900'}`}>{lesson.title}</p>
                            <p className="text-[10px] text-slate-400 font-bold uppercase tracking-tighter mt-0.5">{lesson.duration} • Video & PDF</p>
                          </div>
                        </div>
                        {lesson.status !== 'locked' && (
                          <ChevronRight size={18} className="text-slate-300 group-hover:text-[var(--sji-blue)] transition-colors" />
                        )}
                      </div>
                    ))}
                  </div>
                </motion.div>
              ))}
            </div>

            <div className="space-y-8">
              <div className="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-slate-900/20 relative overflow-hidden">
                <div className="relative z-10">
                  <h4 className="font-black text-lg mb-2">Progress Belajar</h4>
                  <div className="text-4xl font-black mb-6 tracking-tighter">65% <span className="text-sm font-medium text-slate-400">Selesai</span></div>
                  
                  <div className="w-full h-2 bg-slate-800 rounded-full mb-8 overflow-hidden">
                    <motion.div 
                      initial={{ width: 0 }}
                      animate={{ width: '65%' }}
                      className="h-full bg-[var(--sji-red)]"
                    />
                  </div>

                  <div className="space-y-4">
                    <div className="flex items-center justify-between text-xs font-bold text-slate-400">
                      <span>Quiz Lulus</span>
                      <span className="text-white">12/18</span>
                    </div>
                    <div className="flex items-center justify-between text-xs font-bold text-slate-400">
                      <span>Waktu Belajar</span>
                      <span className="text-white">24 Jam</span>
                    </div>
                  </div>
                </div>
                <div className="absolute top-0 right-0 w-32 h-32 bg-[var(--sji-blue)] rounded-full blur-3xl opacity-20 -translate-y-1/2 translate-x-1/2"></div>
              </div>

              <div className="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 text-center">
                <div className="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-[var(--sji-blue)] mx-auto mb-6">
                  <FileText size={32} />
                </div>
                <h4 className="font-bold text-slate-900 mb-2">Simulasi Ujian</h4>
                <p className="text-sm text-slate-500 mb-8 leading-relaxed">Siapkan dirimu untuk ujian JLPT & JFT sesungguhnya.</p>
                <button className="w-full py-4 bg-[var(--sji-blue)] text-white font-black rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20">
                  Mulai CBT
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <Footer />
    </main>
  );
}
