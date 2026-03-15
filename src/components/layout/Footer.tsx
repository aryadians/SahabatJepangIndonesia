'use client';

import { Link } from '@/i18n/routing';
import { motion, useScroll, useTransform } from 'framer-motion';
import { 
  Facebook, 
  Instagram, 
  Youtube, 
  Mail, 
  Phone, 
  MapPin, 
  ExternalLink, 
  ArrowUpRight,
  Globe,
  Navigation as NavIcon
} from 'lucide-react';
import { useRef } from 'react';

export default function Footer() {
  const containerRef = useRef(null);
  
  // 3D-like perspective effect based on mouse movement (simplified for performance)
  const footerVariants = {
    hover: { rotateX: 2, rotateY: -2, transition: { duration: 0.5 } }
  };

  return (
    <footer 
      ref={containerRef}
      className="bg-[#050A1A] text-white pt-32 pb-12 overflow-hidden relative perspective-1000"
    >
      {/* 3D Animated Background Elements */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        <motion.div 
          animate={{ 
            scale: [1, 1.2, 1],
            rotate: [0, 90, 0],
            opacity: [0.05, 0.1, 0.05]
          }}
          transition={{ duration: 20, repeat: Infinity }}
          className="absolute -top-1/4 -right-1/4 w-[800px] h-[800px] bg-[var(--sji-blue)] rounded-full blur-[150px]"
        />
        <motion.div 
          animate={{ 
            scale: [1.2, 1, 1.2],
            rotate: [0, -90, 0],
            opacity: [0.03, 0.08, 0.03]
          }}
          transition={{ duration: 25, repeat: Infinity }}
          className="absolute -bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-[var(--sji-red)] rounded-full blur-[120px]"
        />
        
        {/* Grid Overlay for Tech Look */}
        <div className="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-[0.03]"></div>
      </div>

      <div className="container mx-auto px-6 relative z-10">
        {/* Newsletter / CTA Section - 3D Card */}
        <motion.div 
          initial={{ opacity: 0, y: 50 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="mb-24 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-2xl rounded-[3rem] p-10 lg:p-16 border border-white/10 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] flex flex-col lg:flex-row items-center justify-between gap-12"
        >
          <div className="max-w-xl text-center lg:text-left space-y-4">
            <h3 className="text-3xl md:text-5xl font-black tracking-tighter leading-tight">
              Siap Memulai Karir <br />di <span className="text-[var(--sji-red)]">Jepang?</span>
            </h3>
            <p className="text-slate-400 font-medium text-lg italic">
              "Bergabunglah dengan ribuan alumni yang sukses bersama SJI."
            </p>
          </div>
          <div className="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
            <Link 
              href="/registration"
              className="px-10 py-5 bg-[var(--sji-blue)] text-white font-black rounded-2xl shadow-2xl shadow-blue-900/40 hover:bg-blue-600 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-3 group"
            >
              Daftar Sekarang <ArrowUpRight size={20} className="group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
            </Link>
            <a 
              href="https://wa.me/6281333270022"
              className="px-10 py-5 bg-white/10 text-white font-black rounded-2xl hover:bg-white/20 transition-all flex items-center justify-center gap-3"
            >
              <Phone size={20} /> Konsultasi Gratis
            </a>
          </div>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-16 lg:gap-8 mb-24">
          {/* Brand Info */}
          <div className="lg:col-span-4 space-y-10">
            <div className="space-y-6">
              <Link href="/" className="flex items-center gap-4 group">
                <div className="w-14 h-14 bg-[var(--sji-red)] rounded-[1.2rem] flex items-center justify-center text-white font-black text-2xl shadow-2xl shadow-red-500/30 group-hover:rotate-[15deg] transition-all duration-500">
                  SJI
                </div>
                <div className="flex flex-col">
                  <span className="font-black text-2xl tracking-tighter leading-none">Sahabat Jepang</span>
                  <span className="text-[var(--sji-red)] font-black uppercase tracking-[0.3em] text-[10px] mt-1">Indonesia</span>
                </div>
              </Link>
              <p className="text-slate-400 leading-relaxed font-bold text-sm max-w-sm">
                Lembaga Pelatihan Kerja Resmi (SO) yang berdedikasi menciptakan tenaga kerja profesional dan berintegritas untuk masa depan Indonesia-Jepang.
              </p>
            </div>
            
            <div className="flex gap-4">
              {[
                { icon: <Facebook size={20} />, href: "#", color: "hover:bg-blue-600" },
                { icon: <Instagram size={20} />, href: "#", color: "hover:bg-pink-600" },
                { icon: <Youtube size={20} />, href: "#", color: "hover:bg-red-600" },
              ].map((social, i) => (
                <motion.a 
                  key={i} 
                  whileHover={{ y: -8, rotate: 5 }}
                  href={social.href} 
                  className={`w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center border border-white/10 transition-colors shadow-xl ${social.color}`}
                >
                  {social.icon}
                </motion.a>
              ))}
            </div>
          </div>

          {/* Useful Links */}
          <div className="lg:col-span-2 space-y-8">
            <h4 className="font-black text-xs uppercase tracking-[0.3em] text-slate-500 border-l-2 border-[var(--sji-red)] pl-4">Program</h4>
            <ul className="space-y-4">
              {['SSW (Tokutei Ginou)', 'Ginou Jisshuusei', 'Kursus Bahasa', 'Lowongan Kerja'].map((item) => (
                <li key={item}>
                  <Link href="/programs" className="text-slate-400 hover:text-white font-bold text-sm flex items-center gap-2 group transition-colors">
                    <span className="w-1 h-1 rounded-full bg-[var(--sji-red)] scale-0 group-hover:scale-100 transition-transform"></span>
                    {item}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          <div className="lg:col-span-2 space-y-8">
            <h4 className="font-black text-xs uppercase tracking-[0.3em] text-slate-500 border-l-2 border-[var(--sji-blue)] pl-4">Perusahaan</h4>
            <ul className="space-y-4">
              {['Tentang SJI', 'Tim Sensei', 'FAQ', 'Kontak Kami'].map((item) => (
                <li key={item}>
                  <Link href="/about" className="text-slate-400 hover:text-white font-bold text-sm flex items-center gap-2 group transition-colors">
                    <span className="w-1 h-1 rounded-full bg-[var(--sji-blue)] scale-0 group-hover:scale-100 transition-transform"></span>
                    {item}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact & 3D-ish Map Card */}
          <div className="lg:col-span-4 space-y-8">
            <h4 className="font-black text-xs uppercase tracking-[0.3em] text-slate-500 border-l-2 border-white pl-4">Lokasi Pusat</h4>
            
            <div className="group perspective-1000">
              <motion.div 
                whileHover={{ rotateX: 5, rotateY: -5, y: -5 }}
                className="bg-white/5 backdrop-blur-md rounded-[2.5rem] p-6 border border-white/10 shadow-2xl transition-all duration-500"
              >
                <div className="flex gap-4 mb-6">
                  <div className="w-12 h-12 bg-[var(--sji-red)]/10 rounded-2xl flex items-center justify-center text-[var(--sji-red)] shrink-0">
                    <MapPin size={24} />
                  </div>
                  <div className="space-y-1">
                    <p className="text-sm font-black leading-tight text-white/90">Sidoarjo Head Office</p>
                    <p className="text-[11px] text-slate-400 font-bold leading-relaxed">
                      Jl. Kav. Bumi Sedati No.16 Blok C2, Pepe, Kec. Sedati, Sidoarjo 61253
                    </p>
                  </div>
                </div>

                <div className="w-full h-32 rounded-[1.5rem] overflow-hidden grayscale hover:grayscale-0 transition-all duration-700 relative">
                  <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.844144123141!2d112.768424!3d-7.371389!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e50000000001%3A0x0!2zN8KwMjInMTcuMCJTIDExMsKwNDYnMDYuMyJF!5e0!3m2!1sid!2sid!4v1710500000000!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style={{ border: 0 }} 
                    loading="lazy"
                  ></iframe>
                  <a 
                    href="https://maps.app.goo.gl/T3fkcdrx35ypHn9GA" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all backdrop-blur-sm"
                  >
                    <span className="bg-white text-slate-900 px-5 py-2.5 rounded-xl font-black text-[10px] uppercase flex items-center gap-2 shadow-2xl">
                      <NavIcon size={14} /> Open in Maps
                    </span>
                  </a>
                </div>
                
                <div className="mt-6 pt-6 border-t border-white/5 flex items-center justify-between">
                  <div className="flex items-center gap-2 text-slate-400">
                    <Globe size={14} />
                    <span className="text-[10px] font-black uppercase tracking-widest">Sidoarjo, Jatim</span>
                  </div>
                  <span className="text-[10px] font-black text-slate-600 uppercase tracking-widest">JQ28+F4 Pepe</span>
                </div>
              </motion.div>
            </div>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="pt-12 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-8">
          <div className="flex flex-col items-center md:items-start gap-2">
            <p className="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em]">
              © {new Date().getFullYear()} Sahabat Jepang Indonesia. All Rights Reserved.
            </p>
            <p className="text-slate-600 text-[10px] font-bold">
              Officially Licensed Sending Organization (SO) by KEMNAKER RI.
            </p>
          </div>
          
          <div className="flex gap-8">
            {['Privacy Policy', 'Terms of Service', 'Cookie Policy'].map(item => (
              <a key={item} href="#" className="text-slate-500 hover:text-white text-[10px] font-black uppercase tracking-widest transition-colors">
                {item}
              </a>
            ))}
          </div>
        </div>
      </div>

      {/* Extreme Bottom Text Decor */}
      <div className="absolute -bottom-10 left-1/2 -translate-x-1/2 text-[150px] font-black text-white/[0.02] whitespace-nowrap select-none pointer-events-none tracking-tighter">
        SAHABAT JEPANG INDONESIA
      </div>
    </footer>
  );
}
