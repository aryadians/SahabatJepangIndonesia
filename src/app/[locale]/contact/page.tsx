'use client';

import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { motion } from "framer-motion";
import { Mail, Phone, MapPin, Send } from "lucide-react";
import { showSuccess } from "@/lib/swal";

export default function ContactPage() {
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    showSuccess("Pesan Terkirim", "Terima kasih telah menghubungi kami. Tim kami akan segera merespon pesan Anda.");
  };

  return (
    <main className="min-h-screen bg-white">
      <Header />
      
      <section className="pt-32 pb-20">
        <div className="container mx-auto px-4">
          <div className="max-w-6xl mx-auto">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
              {/* Contact Info */}
              <div className="space-y-12">
                <div>
                  <motion.h1 
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    className="text-4xl md:text-5xl font-black text-[var(--sji-blue)] mb-6"
                  >
                    Hubungi Kami
                  </motion.h1>
                  <p className="text-gray-600 text-lg leading-relaxed">
                    Punya pertanyaan seputar program kami? Silakan hubungi kami melalui formulir atau kontak di bawah ini.
                  </p>
                </div>

                <div className="space-y-6">
                  <div className="flex items-start gap-6 p-6 rounded-3xl bg-blue-50 border border-blue-100 group hover:bg-[var(--sji-blue)] hover:text-white transition-all">
                    <div className="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[var(--sji-blue)] shadow-sm group-hover:scale-110 transition-transform">
                      <MapPin size={24} />
                    </div>
                    <div>
                      <h4 className="font-bold text-lg mb-1">Kantor Pusat</h4>
                      <p className="text-sm opacity-80">Perumahan Putri Juanda Blok C3/05, Desa Pepe, Kec. Sedati, Sidoarjo, Jawa Timur 61253</p>
                    </div>
                  </div>

                  <div className="flex items-start gap-6 p-6 rounded-3xl bg-red-50 border border-red-100 group hover:bg-[var(--sji-red)] hover:text-white transition-all">
                    <div className="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[var(--sji-red)] shadow-sm group-hover:scale-110 transition-transform">
                      <Phone size={24} />
                    </div>
                    <div>
                      <h4 className="font-bold text-lg mb-1">WhatsApp</h4>
                      <p className="text-sm opacity-80">+62 813-3327-0022</p>
                    </div>
                  </div>

                  <div className="flex items-start gap-6 p-6 rounded-3xl bg-slate-50 border border-slate-100 group hover:bg-slate-900 hover:text-white transition-all">
                    <div className="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-900 shadow-sm group-hover:scale-110 transition-transform">
                      <Mail size={24} />
                    </div>
                    <div>
                      <h4 className="font-bold text-lg mb-1">Email</h4>
                      <p className="text-sm opacity-80">official@sjigroup.co.id</p>
                    </div>
                  </div>
                </div>
              </div>

              {/* Contact Form */}
              <motion.div 
                initial={{ opacity: 0, x: 20 }}
                animate={{ opacity: 1, x: 0 }}
                className="bg-white p-10 rounded-[3rem] shadow-2xl border border-gray-100"
              >
                <form onSubmit={handleSubmit} className="space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label className="text-sm font-bold text-gray-700 ml-1">Nama</label>
                      <input required type="text" className="w-full px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none" placeholder="Ahmad Fauzi" />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-bold text-gray-700 ml-1">Email</label>
                      <input required type="email" className="w-full px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none" placeholder="ahmad@example.com" />
                    </div>
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-bold text-gray-700 ml-1">Subjek</label>
                    <input required type="text" className="w-full px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none" placeholder="Tanya Program Magang" />
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-bold text-gray-700 ml-1">Pesan</label>
                    <textarea required rows={5} className="w-full px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100 focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none resize-none" placeholder="Tuliskan pesan Anda di sini..."></textarea>
                  </div>
                  <button type="submit" className="w-full py-4 bg-[var(--sji-blue)] text-white font-bold rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-blue-700 transition-all flex items-center justify-center gap-2 group">
                    Kirim Pesan <Send size={18} className="group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
                  </button>
                </form>
              </motion.div>
            </div>
          </div>
        </div>
      </section>

      {/* Map Placeholder */}
      <section className="h-96 bg-gray-200 border-t border-b border-gray-300">
        <div className="w-full h-full flex items-center justify-center text-gray-500 font-bold bg-gray-50">
          [ Google Maps Embed - Sidoarjo Head Office ]
        </div>
      </section>

      <Footer />
    </main>
  );
}
