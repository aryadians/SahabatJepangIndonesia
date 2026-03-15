import Header from "@/components/layout/Header";
import Hero from "@/components/home/Hero";

export default function HomePage() {
  return (
    <main className="min-h-screen bg-white">
      <Header />
      <Hero />
      
      {/* Other sections like Programs, Testimonials, etc. will go here */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold text-[var(--sji-blue)] mb-8">
            Kenapa Memilih Sahabat Jepang Indonesia?
          </h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow">
              <div className="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-[var(--sji-red)] mb-4 mx-auto">
                <span className="font-bold">01</span>
              </div>
              <h3 className="font-bold text-xl mb-2">Ribuan Alumni</h3>
              <p className="text-gray-600 text-sm">Telah memberangkatkan ribuan siswa ke berbagai kota di Jepang.</p>
            </div>
            <div className="p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow">
              <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-[var(--sji-blue)] mb-4 mx-auto">
                <span className="font-bold">02</span>
              </div>
              <h3 className="font-bold text-xl mb-2">Metode Visual</h3>
              <p className="text-gray-600 text-sm">Metode pembelajaran Kitte Mitte Oboite yang efektif dan menyenangkan.</p>
            </div>
            <div className="p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow">
              <div className="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-4 mx-auto">
                <span className="font-bold">03</span>
              </div>
              <h3 className="font-bold text-xl mb-2">Terpercaya</h3>
              <p className="text-gray-600 text-sm">Berizin resmi dari Kemnaker RI sebagai Sending Organization (SO).</p>
            </div>
          </div>
        </div>
      </section>
    </main>
  );
}
