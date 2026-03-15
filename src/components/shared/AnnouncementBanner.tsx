'use client';

import { useState, useEffect } from 'react';
import { Megaphone, X, ChevronRight } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';

export default function AnnouncementBanner() {
  const [announcements, setAnnouncements] = useState<any[]>([]);
  const [show, setShow] = useState(true);

  useEffect(() => {
    fetch('/api/announcements')
      .then(res => res.json())
      .then(data => {
        if (Array.isArray(data) && data.length > 0) {
          setAnnouncements(data);
        }
      });
  }, []);

  if (!show || announcements.length === 0) return null;

  return (
    <AnimatePresence>
      <motion.div 
        initial={{ y: -100, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        exit={{ y: -100, opacity: 0 }}
        className="fixed top-24 left-1/2 -translate-x-1/2 z-40 w-full max-w-4xl px-4"
      >
        <div className="bg-slate-900 text-white rounded-[2rem] p-4 pr-12 shadow-2xl border border-white/10 flex items-center gap-4 relative overflow-hidden group">
          {/* Glow Effect */}
          <div className="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-[var(--sji-blue)]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
          
          <div className="w-10 h-10 bg-[var(--sji-red)] rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-red-500/20">
            <Megaphone size={20} />
          </div>
          
          <div className="flex-1 min-w-0">
            <p className="text-xs font-black uppercase tracking-[0.2em] text-slate-500 mb-0.5">Pengumuman Penting</p>
            <p className="text-sm font-bold truncate pr-4">{announcements[0].title}</p>
          </div>

          <button className="hidden sm:flex items-center gap-2 text-[var(--sji-blue)] font-black text-xs uppercase tracking-widest hover:text-blue-400 transition-colors">
            Lihat Detail <ChevronRight size={14} />
          </button>

          <button 
            onClick={() => setShow(false)}
            className="absolute right-4 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 transition-colors text-slate-400"
          >
            <X size={16} />
          </button>
        </div>
      </motion.div>
    </AnimatePresence>
  );
}
