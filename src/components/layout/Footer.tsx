import { Link } from '@/i18n/routing';
import { Facebook, Instagram, Youtube, Mail, Phone, MapPin, ExternalLink } from 'lucide-react';

export default function Footer() {
  return (
    <footer className="bg-slate-900 text-white pt-24 pb-12 overflow-hidden relative">
      {/* Background Decor */}
      <div className="absolute top-0 right-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
      <div className="absolute bottom-0 left-0 w-64 h-64 bg-red-500/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

      <div className="container mx-auto px-6 relative z-10">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-20">
          {/* Brand */}
          <div className="space-y-8">
            <Link href="/" className="flex items-center gap-3">
              <div className="w-12 h-12 bg-[var(--sji-red)] rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-red-500/20">
                SJI
              </div>
              <span className="font-black text-2xl tracking-tighter">
                Sahabat Jepang <span className="text-[var(--sji-red)]">Indo</span>
              </span>
            </Link>
            <p className="text-slate-400 leading-relaxed font-medium">
              Lembaga Pelatihan Kerja (LPK) resmi yang berdedikasi membantu putra-putri Indonesia meraih karier sukses dan profesional di Jepang.
            </p>
            <div className="flex gap-4">
              {[
                { icon: <Facebook size={20} />, href: "#" },
                { icon: <Instagram size={20} />, href: "#" },
                { icon: <Youtube size={20} />, href: "#" },
              ].map((social, i) => (
                <a 
                  key={i} 
                  href={social.href} 
                  className="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center hover:bg-[var(--sji-red)] hover:scale-110 transition-all duration-300 shadow-lg shadow-black/20"
                >
                  {social.icon}
                </a>
              ))}
            </div>
          </div>

          {/* Programs */}
          <div className="space-y-8">
            <h4 className="font-black text-lg uppercase tracking-widest text-slate-500">Program</h4>
            <ul className="space-y-4">
              {[
                { name: 'Tokutei Ginou (SSW)', href: '/programs' },
                { name: 'Magang Jepang', href: '/programs' },
                { name: 'Kursus Bahasa', href: '/classes' },
                { name: 'Lowongan Kerja', href: '/news' },
              ].map((link) => (
                <li key={link.name}>
                  <Link href={link.href as any} className="text-slate-400 hover:text-white font-bold flex items-center gap-2 group transition-colors">
                    <div className="w-1.5 h-1.5 rounded-full bg-[var(--sji-red)] scale-0 group-hover:scale-100 transition-transform"></div>
                    {link.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Quick Links */}
          <div className="space-y-8">
            <h4 className="font-black text-lg uppercase tracking-widest text-slate-500">Tautan</h4>
            <ul className="space-y-4">
              {[
                { name: 'Tentang SJI', href: '/about' },
                { name: 'FAQ', href: '/faq' },
                { name: 'Pendaftaran', href: '/registration' },
                { name: 'Hubungi Kami', href: '/contact' },
              ].map((link) => (
                <li key={link.name}>
                  <Link href={link.href as any} className="text-slate-400 hover:text-white font-bold flex items-center gap-2 group transition-colors">
                    <div className="w-1.5 h-1.5 rounded-full bg-[var(--sji-blue)] scale-0 group-hover:scale-100 transition-transform"></div>
                    {link.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact & Map */}
          <div className="space-y-8 lg:col-span-1">
            <h4 className="font-black text-lg uppercase tracking-widest text-slate-500">Kontak & Lokasi</h4>
            <ul className="space-y-6 mb-8">
              {[
                { 
                  icon: <MapPin className="text-[var(--sji-red)]" size={20} />, 
                  text: 'Jl. Kav. Bumi Sedati No.16 Blok C2, Pepe, Kec. Sedati, Sidoarjo 61253',
                  href: 'https://maps.app.goo.gl/T3fkcdrx35ypHn9GA'
                },
                { icon: <Phone className="text-[var(--sji-red)]" size={20} />, text: '+62 813-3327-0022', href: 'https://wa.me/6281333270022' },
                { icon: <Mail className="text-[var(--sji-red)]" size={20} />, text: 'official@sjigroup.co.id', href: 'mailto:official@sjigroup.co.id' },
              ].map((item, i) => (
                <li key={i}>
                  <a 
                    href={item.href} 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    className="flex gap-4 group hover:bg-slate-800/50 p-2 -m-2 rounded-xl transition-all"
                  >
                    <div className="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-[var(--sji-blue)] transition-colors">
                      {item.icon}
                    </div>
                    <span className="text-slate-400 text-sm font-bold leading-relaxed group-hover:text-white transition-colors">{item.text}</span>
                  </a>
                </li>
              ))}
            </ul>
            
            {/* Map Embed */}
            <div className="space-y-4">
              <div className="w-full h-40 rounded-2xl overflow-hidden border-2 border-slate-800 group relative">
                <iframe 
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.844144123141!2d112.768424!3d-7.371389!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e50000000001%3A0x0!2zN8KwMjInMTcuMCJTIDExMsKwNDYnMDYuMyJF!5e0!3m2!1sid!2sid!4v1710500000000!5m2!1sid!2sid" 
                  width="100%" 
                  height="100%" 
                  style={{ border: 0 }} 
                  allowFullScreen 
                  loading="lazy"
                ></iframe>
                <a 
                  href="https://maps.app.goo.gl/T3fkcdrx35ypHn9GA" 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity backdrop-blur-sm"
                >
                  <span className="bg-white text-slate-900 px-4 py-2 rounded-xl font-black text-xs uppercase flex items-center gap-2">
                    <ExternalLink size={14} /> Petunjuk Arah
                  </span>
                </a>
              </div>
              <p className="text-[10px] text-slate-500 font-bold uppercase tracking-widest text-center">JQ28+F4 Pepe, Kabupaten Sidoarjo</p>
            </div>
          </div>
        </div>

        <div className="pt-12 border-t border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6">
          <p className="text-slate-500 text-sm font-bold">
            © {new Date().getFullYear()} Sahabat Jepang Indonesia. Built with ❤️ for Future Leaders.
          </p>
          <div className="flex gap-8">
            <a href="#" className="text-slate-500 hover:text-white text-xs font-black uppercase tracking-widest transition-colors">Privacy Policy</a>
            <a href="#" className="text-slate-500 hover:text-white text-xs font-black uppercase tracking-widest transition-colors">Terms of Service</a>
          </div>
        </div>
      </div>
    </footer>
  );
}
