import Header from "@/components/layout/Header";
import Hero from "@/components/home/Hero";
import Stats from "@/components/home/Stats";
import Programs from "@/components/home/Programs";
import RegistrationForm from "@/components/home/RegistrationForm";
import Footer from "@/components/layout/Footer";
import { Link } from "@/i18n/routing";
import { Star, Quote } from "lucide-react";

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
    <main className="min-h-screen bg-white">
      <Header />
      <Hero />
      <Stats />

      {/* About Summary Section */}
      <section className="py-24 bg-white">
        <div className="container mx-auto px-4">
          <div className="flex flex-col lg:flex-row items-center gap-16">
            <div className="lg:w-1/2">
              <div className="relative">
                <div className="w-full aspect-video bg-gray-100 rounded-[3rem] shadow-2xl border-8 border-white overflow-hidden flex items-center justify-center text-gray-400 font-bold">
                  [ Video Profile / SJI Building Image ]
                </div>
                <div className="absolute -bottom-6 -right-6 w-32 h-32 bg-[var(--sji-red)] rounded-[2rem] flex items-center justify-center text-white font-black text-3xl shadow-xl">
                  10+
                </div>
              </div>
            </div>
            <div className="lg:w-1/2 space-y-6">
              <span className="text-[var(--sji-red)] font-bold tracking-widest uppercase text-sm">Tentang Sahabat Jepang Indonesia</span>
              <h2 className="text-4xl lg:text-5xl font-black text-[var(--sji-blue)] leading-tight">Mencetak SDM Indonesia yang Unggul & Berintegritas</h2>
              <p className="text-gray-600 leading-relaxed text-lg">
                Sejak berdiri, SJI telah berkomitmen untuk menjadi jembatan bagi putra-putri terbaik bangsa untuk meraih impian mereka berkarir secara profesional di Negeri Sakura. Kami tidak hanya mengajarkan bahasa, tapi juga mentalitas dan etos kerja Jepang.
              </p>
              <div className="pt-4">
                <Link href="/about" className="inline-flex items-center gap-2 text-[var(--sji-blue)] font-bold text-lg hover:gap-4 transition-all">
                  Selengkapnya tentang kami <span>→</span>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>

      <Programs />

      {/* Testimonials Section */}
      <section className="py-24 bg-blue-50/50">
        <div className="container mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-extrabold text-[var(--sji-blue)] mb-4">Apa Kata Alumni SJI?</h2>
            <p className="text-gray-500 max-w-2xl mx-auto">Cerita sukses mereka yang telah mewujudkan impian berkarir di Jepang bersama kami.</p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {testimonials.map((t, i) => (
              <div key={i} className="bg-white p-10 rounded-[2.5rem] shadow-sm border border-blue-50 relative group hover:shadow-xl transition-all">
                <Quote className="absolute top-8 right-8 text-blue-100 w-12 h-12" />
                <div className="flex gap-1 mb-6">
                  {[1, 2, 3, 4, 5].map((s) => (
                    <Star key={s} size={16} className="fill-yellow-400 text-yellow-400" />
                  ))}
                </div>
                <p className="text-gray-600 italic leading-relaxed mb-8 relative z-10">"{t.text}"</p>
                <div className="flex items-center gap-4 border-t border-gray-50 pt-6">
                  <div className="w-12 h-12 rounded-full bg-slate-100 shrink-0"></div>
                  <div>
                    <h4 className="font-bold text-slate-900">{t.name}</h4>
                    <p className="text-xs text-[var(--sji-red)] font-bold uppercase tracking-wider">{t.program}</p>
                    <p className="text-[10px] text-gray-400">{t.location}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
      
      {/* Registration Section on Home */}
      <section className="py-24 bg-white relative overflow-hidden">
        <div className="container mx-auto px-4 relative z-10">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-extrabold text-[var(--sji-blue)] mb-4">Mulai Karier Anda Hari Ini</h2>
            <p className="text-gray-500 max-w-2xl mx-auto">Jangan tunda impian Anda. Daftar sekarang dan tim kami akan membimbing Anda hingga berangkat ke Jepang.</p>
          </div>
          <RegistrationForm />
        </div>
      </section>
      
      {/* Official Partners / Mitras */}
      <section className="py-20 bg-gray-50 border-t border-b border-gray-100">
        <div className="container mx-auto px-4">
          <p className="text-center text-gray-400 font-bold uppercase tracking-widest text-sm mb-12">Mitra Resmi & Sending Organization</p>
          <div className="flex flex-wrap justify-center items-center gap-12 opacity-50 grayscale hover:grayscale-0 transition-all duration-700">
            {/* These would be actual partner logos */}
            <div className="h-12 w-32 bg-gray-300 rounded"></div>
            <div className="h-12 w-32 bg-gray-300 rounded"></div>
            <div className="h-12 w-32 bg-gray-300 rounded"></div>
            <div className="h-12 w-32 bg-gray-300 rounded"></div>
            <div className="h-12 w-32 bg-gray-300 rounded"></div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
