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

          {/* Contact */}
          <div className="space-y-8">
            <h4 className="font-black text-lg uppercase tracking-widest text-slate-500">Kontak</h4>
            <ul className="space-y-6">
              {[
                { icon: <MapPin className="text-[var(--sji-red)]" size={20} />, text: 'Perum Putri Juanda Blok C3/05, Sidoarjo, Jawa Timur' },
                { icon: <Phone className="text-[var(--sji-red)]" size={20} />, text: '+62 813-3327-0022' },
                { icon: <Mail className="text-[var(--sji-red)]" size={20} />, text: 'official@sjigroup.co.id' },
              ].map((item, i) => (
                <li key={i} className="flex gap-4 group cursor-default">
                  <div className="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-slate-700 transition-colors">
                    {item.icon}
                  </div>
                  <span className="text-slate-400 text-sm font-bold leading-relaxed">{item.text}</span>
                </li>
              ))}
            </ul>
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
