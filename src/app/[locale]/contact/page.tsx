'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { motion } from "framer-motion";
import { Mail, Phone, MapPin, Send, Globe, MessageSquare, ExternalLink } from "lucide-react";
import { showSuccess } from "@/lib/swal";
import Image from "next/image";

export default function ContactPage() {
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    showSuccess("Pesan Terkirim", "Terima kasih telah menghubungi kami. Tim kami akan segera merespon pesan Anda.");
  };

  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      <section className="pt-40 pb-24 relative overflow-hidden">
        {/* Background Decor */}
        <div className="absolute top-0 left-0 w-full h-full bg-slate-50/50 -z-10"></div>
        <div className="absolute top-0 right-0 w-[600px] h-[600px] bg-[var(--sji-blue)]/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>

        <div className="container mx-auto px-6">
          <div className="max-w-7xl mx-auto">
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-20 items-start">
              
              {/* Left Side: Info - Elite Look */}
              <div className="lg:col-span-5 space-y-12">
                <div className="space-y-6">
                  <motion.div
                    initial={{ opacity: 0, x: -20 }}
                    animate={{ opacity: 1, x: 0 }}
                    className="inline-flex items-center gap-2 px-4 py-1.5 bg-[var(--sji-red)]/10 text-[var(--sji-red)] rounded-full text-xs font-black uppercase tracking-[0.2em]"
                  >
                    <MessageSquare size={14} /> Get in Touch
                  </motion.div>
                  <motion.h1 
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    className="text-5xl md:text-7xl font-black text-slate-900 leading-tight tracking-tighter"
                  >
                    Mari Berdiskusi <br /> Masa Depan <span className="text-[var(--sji-blue)]">Anda.</span>
                  </motion.h1>
                  <p className="text-xl text-slate-500 font-medium leading-relaxed">
                    Punya pertanyaan seputar program kami? Silakan hubungi kami melalui formulir atau kanal komunikasi resmi SJI di bawah ini.
                  </p>
                </div>

                <div className="space-y-6">
                  {[
                    { 
                      icon: <MapPin size={24} />, 
                      title: "Kantor Pusat", 
                      text: "Jl. Kav. Bumi Sedati No.16 Blok C2, Pepe, Kec. Sedati, Sidoarjo 61253",
                      color: "blue"
                    },
                    { 
                      icon: <Phone size={24} />, 
                      title: "WhatsApp Center", 
                      text: "+62 813-3327-0022",
                      color: "red"
                    },
                    { 
                      icon: <Mail size={24} />, 
                      title: "Official Email", 
                      text: "official@sjigroup.co.id",
                      color: "slate"
                    }
                  ].map((item, i) => (
                    <motion.div 
                      key={i}
                      whileHover={{ x: 10 }}
                      className="flex items-start gap-6 p-8 rounded-[2.5rem] bg-white border border-slate-100 shadow-sm hover:shadow-xl transition-all cursor-default group"
                    >
                      <div className={`w-14 h-14 rounded-2xl flex items-center justify-center shadow-inner transition-colors duration-500 ${
                        item.color === 'blue' ? 'bg-blue-50 text-[var(--sji-blue)] group-hover:bg-[var(--sji-blue)] group-hover:text-white' :
                        item.color === 'red' ? 'bg-red-50 text-[var(--sji-red)] group-hover:bg-[var(--sji-red)] group-hover:text-white' :
                        'bg-slate-50 text-slate-900 group-hover:bg-slate-900 group-hover:text-white'
                      }`}>
                        {item.icon}
                      </div>
                      <div>
                        <h4 className="font-black text-slate-900 text-lg mb-1">{item.title}</h4>
                        <p className="text-slate-500 font-medium leading-relaxed">{item.text}</p>
                      </div>
                    </motion.div>
                  ))}
                </div>
              </div>

              {/* Right Side: Form - 3D Perspective Card */}
              <div className="lg:col-span-7 perspective-1000">
                <motion.div 
                  initial={{ opacity: 0, x: 50 }}
                  animate={{ opacity: 1, x: 0 }}
                  whileHover={{ rotateY: -2, rotateX: 2 }}
                  className="bg-white p-10 lg:p-16 rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] border border-slate-50 relative group overflow-hidden"
                >
                  <div className="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full -translate-y-1/2 translate-x-1/2 -z-10 group-hover:bg-blue-50 transition-colors duration-700"></div>
                  
                  <form onSubmit={handleSubmit} className="space-y-8 relative z-10">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                      <div className="space-y-2">
                        <label className="text-xs font-black uppercase text-slate-400 ml-1 tracking-widest">Nama Anda</label>
                        <input required type="text" className="w-full px-8 py-5 rounded-2xl bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none font-bold text-slate-700 shadow-inner" placeholder="Ahmad Fauzi" />
                      </div>
                      <div className="space-y-2">
                        <label className="text-xs font-black uppercase text-slate-400 ml-1 tracking-widest">Email Aktif</label>
                        <input required type="email" className="w-full px-8 py-5 rounded-2xl bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none font-bold text-slate-700 shadow-inner" placeholder="ahmad@example.com" />
                      </div>
                    </div>
                    <div className="space-y-2">
                      <label className="text-xs font-black uppercase text-slate-400 ml-1 tracking-widest">Subjek Pesan</label>
                      <input required type="text" className="w-full px-8 py-5 rounded-2xl bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none font-bold text-slate-700 shadow-inner" placeholder="Tanya Program Magang / SSW" />
                    </div>
                    <div className="space-y-2">
                      <label className="text-xs font-black uppercase text-slate-400 ml-1 tracking-widest">Pesan Lengkap</label>
                      <textarea required rows={6} className="w-full px-8 py-5 rounded-2xl bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none resize-none font-bold text-slate-700 shadow-inner leading-relaxed" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."></textarea>
                    </div>
                    <button type="submit" className="w-full py-6 bg-[var(--sji-blue)] text-white font-black rounded-3xl shadow-2xl shadow-blue-900/30 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3 group">
                      Kirim Pesan Sekarang <Send size={20} className="group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
                    </button>
                  </form>
                </motion.div>
              </div>

            </div>
          </div>
        </div>
      </section>

      {/* Modern Map Integration */}
      <section className="py-24 bg-slate-50">
        <div className="container mx-auto px-6">
          <div className="max-w-7xl mx-auto rounded-[4rem] overflow-hidden shadow-2xl border-[16px] border-white h-[500px] relative group">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.844144123141!2d112.768424!3d-7.371389!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e50000000001%3A0x0!2zN8KwMjInMTcuMCJTIDExMsKwNDYnMDYuMyJF!5e0!3m2!1sid!2sid!4v1710500000000!5m2!1sid!2sid" 
              width="100%" 
              height="100%" 
              style={{ border: 0 }} 
              allowFullScreen 
              loading="lazy"
              className="grayscale group-hover:grayscale-0 transition-all duration-1000"
            ></iframe>
            <div className="absolute top-10 left-10 p-8 bg-white/90 backdrop-blur rounded-[2.5rem] shadow-2xl border border-white max-w-sm space-y-4">
              <h4 className="font-black text-slate-900 text-xl tracking-tight">Kunjungi Kantor Kami</h4>
              <p className="text-slate-500 font-medium text-sm leading-relaxed">Senin - Jumat: 08.00 - 17.00 WIB<br />Sidoarjo, Jawa Timur.</p>
              <a href="https://maps.app.goo.gl/T3fkcdrx35ypHn9GA" target="_blank" rel="noopener noreferrer" className="inline-flex items-center gap-2 text-[var(--sji-blue)] font-black uppercase tracking-widest text-xs hover:underline pt-2">
                <ExternalLink size={14} /> Lihat di Google Maps
              </a>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
