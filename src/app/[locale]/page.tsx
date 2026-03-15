import Header from "@/components/layout/Header";
import Hero from "@/components/home/Hero";
import Stats from "@/components/home/Stats";
import Programs from "@/components/home/Programs";
import RegistrationWizard from "@/components/home/RegistrationWizard";
import Footer from "@/components/layout/Footer";
import { Link } from "@/i18n/routing";
import { Star, Quote, ArrowRight, ShieldCheck, Zap } from "lucide-react";

export default function HomePage() {
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

      {/* About Summary Section */}
      <section className="py-32 bg-white relative overflow-hidden">
        <div className="container mx-auto px-6">
          <div className="flex flex-col lg:flex-row items-center gap-24">
            <div className="lg:w-1/2 relative group">
              <div className="relative z-10">
                <div className="w-full aspect-[4/3] bg-slate-100 rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] border-[16px] border-white overflow-hidden flex items-center justify-center text-slate-300 font-black text-2xl group-hover:scale-[1.02] transition-transform duration-700">
                  [ COMPANY PROFILE PHOTO ]
                </div>
                {/* Floating badge */}
                <div className="absolute -bottom-8 -right-8 w-40 h-40 bg-[var(--sji-red)] rounded-[3rem] flex flex-col items-center justify-center text-white shadow-2xl shadow-red-500/40 rotate-12 group-hover:rotate-0 transition-transform duration-500">
                  <span className="font-black text-5xl">10+</span>
                  <span className="text-[10px] font-black uppercase tracking-widest">Years Exp</span>
                </div>
              </div>
              {/* Decorative shapes */}
              <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-blue-50/50 rounded-full blur-3xl -z-10"></div>
            </div>

            <div className="lg:w-1/2 space-y-10">
              <div className="space-y-4">
                <div className="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-50 text-[var(--sji-blue)] rounded-full text-xs font-black uppercase tracking-[0.2em]">
                  <ShieldCheck size={14} /> Jembatan Masa Depan
                </div>
                <h2 className="text-4xl lg:text-6xl font-black text-slate-900 leading-tight tracking-tighter">
                  Mencetak SDM Indonesia yang <span className="text-[var(--sji-blue)]">Unggul</span> & Berintegritas
                </h2>
              </div>
              
              <p className="text-xl text-slate-500 leading-relaxed font-medium">
                Sejak berdiri, SJI telah berkomitmen untuk menjadi jembatan bagi putra-putri terbaik bangsa untuk meraih impian mereka berkarir secara profesional di Negeri Sakura. Kami tidak hanya mengajarkan bahasa, tapi juga mentalitas dan etos kerja Jepang.
              </p>

              <div className="grid grid-cols-2 gap-8 pt-4">
                <div className="space-y-2">
                  <div className="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-[var(--sji-red)]"><Zap size={20} fill="currentColor" /></div>
                  <h4 className="font-black text-slate-900">Proses Cepat</h4>
                  <p className="text-sm text-slate-500 font-medium">Pelatihan intensif 4-6 bulan hingga siap terbang.</p>
                </div>
                <div className="space-y-2">
                  <div className="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-[var(--sji-blue)]"><ShieldCheck size={20} /></div>
                  <h4 className="font-black text-slate-900">Resmi & Legal</h4>
                  <p className="text-sm text-slate-500 font-medium">Sending Organization (SO) resmi berizin Kemnaker.</p>
                </div>
              </div>

              <div className="pt-6">
                <Link href="/about" className="inline-flex items-center gap-3 px-8 py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-slate-800 transition-all shadow-xl shadow-black/10 group">
                  Selengkapnya <span>→</span>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>

      <Programs />

      {/* Testimonials Section */}
      <section className="py-32 bg-slate-50 relative overflow-hidden">
        <div className="container mx-auto px-6 relative z-10">
          <div className="text-center max-w-3xl mx-auto mb-20 space-y-4">
            <span className="text-[var(--sji-red)] font-black uppercase tracking-[0.2em] text-xs">Success Stories</span>
            <h2 className="text-4xl md:text-6xl font-black text-slate-900 tracking-tight">Apa Kata Alumni SJI?</h2>
            <p className="text-lg text-slate-500 font-medium">Cerita sukses mereka yang telah mewujudkan impian bersama kami.</p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            {testimonials.map((t, i) => (
              <div key={i} className="bg-white p-12 rounded-[3.5rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] border border-white relative group hover:shadow-2xl transition-all duration-500">
                <Quote className="absolute top-10 right-10 text-slate-100 w-16 h-16 -rotate-12 transition-transform group-hover:rotate-0" />
                <div className="flex gap-1 mb-8">
                  {[1, 2, 3, 4, 5].map((s) => (
                    <Star key={s} size={16} className="fill-yellow-400 text-yellow-400" />
                  ))}
                </div>
                <p className="text-slate-600 font-bold leading-relaxed mb-10 relative z-10 italic text-lg">"{t.text}"</p>
                <div className="flex items-center gap-5 border-t border-slate-50 pt-8 mt-auto">
                  <div className="w-14 h-14 rounded-[1.5rem] bg-slate-100 shrink-0 flex items-center justify-center font-black text-slate-300">AF</div>
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
      
      {/* Official Partners / Mitras */}
      <section className="py-24 bg-slate-50 border-t border-slate-100">
        <div className="container mx-auto px-6">
          <p className="text-center text-slate-400 font-black uppercase tracking-[0.3em] text-[10px] mb-16">Mitra Resmi & Sending Organization</p>
          <div className="flex flex-wrap justify-center items-center gap-16 lg:gap-24 opacity-30 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-700">
            {[1, 2, 3, 4, 5].map(i => (
              <div key={i} className="h-10 w-32 bg-slate-300 rounded-lg hover:bg-slate-400 transition-colors"></div>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
