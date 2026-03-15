import Header from "@/components/layout/Header";
import Hero from "@/components/home/Hero";
import Stats from "@/components/home/Stats";
import Programs from "@/components/home/Programs";
import Footer from "@/components/layout/Footer";

export default function HomePage() {
  return (
    <main className="min-h-screen bg-white">
      <Header />
      <Hero />
      <Stats />
      <Programs />
      
      {/* Visual Quote Section */}
      <section className="py-24 bg-white relative overflow-hidden">
        <div className="container mx-auto px-4 text-center relative z-10">
          <blockquote className="max-w-4xl mx-auto">
            <p className="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-8">
              "Membuka Gerbang Masa Depan Putra-Putri Indonesia Melalui Karier Profesional di <span className="text-[var(--sji-red)]">Jepang</span>."
            </p>
            <footer className="text-gray-500 font-bold uppercase tracking-widest">— Sahabat Jepang Indonesia</footer>
          </blockquote>
        </div>
        
        {/* Abstract shapes for visual interest */}
        <div className="absolute top-0 left-0 w-64 h-64 bg-blue-50 rounded-full -translate-x-1/2 -translate-y-1/2 -z-10"></div>
        <div className="absolute bottom-0 right-0 w-96 h-96 bg-red-50 rounded-full translate-x-1/3 translate-y-1/3 -z-10"></div>
      </section>

      {/* Official Partners / Mitras */}
      <section className="py-20 bg-gray-50 border-t border-b border-gray-100">
        <div className="container mx-auto px-4">
          <p className="text-center text-gray-400 font-bold uppercase tracking-widest text-sm mb-12">Mitra Resmi & Sending Organization</p>
          <div className="flex flex-wrap justify-center items-center gap-12 opacity-50 grayscale hover:grayscale-0 transition-all duration-700">
            {/* These would be actual partner logos */}
            <div className="h-12 w-32 bg-gray-300 rounded animate-pulse"></div>
            <div className="h-12 w-32 bg-gray-300 rounded animate-pulse"></div>
            <div className="h-12 w-32 bg-gray-300 rounded animate-pulse"></div>
            <div className="h-12 w-32 bg-gray-300 rounded animate-pulse"></div>
            <div className="h-12 w-32 bg-gray-300 rounded animate-pulse"></div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
