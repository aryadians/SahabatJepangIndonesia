import { Link } from '@/i18n/routing';
import { Facebook, Instagram, Youtube, Mail, Phone, MapPin } from 'lucide-react';

export default function Footer() {
  return (
    <footer className="bg-gray-900 text-white pt-20 pb-10">
      <div className="container mx-auto px-4">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
          {/* Brand */}
          <div className="space-y-6">
            <Link href="/" className="flex items-center gap-2">
              <div className="w-10 h-10 bg-[var(--sji-red)] rounded-full flex items-center justify-center text-white font-bold">
                SJI
              </div>
              <span className="font-bold text-xl tracking-tight">
                Sahabat Jepang <span className="text-[var(--sji-red)]">Indonesia</span>
              </span>
            </Link>
            <p className="text-gray-400 leading-relaxed">
              Lembaga Pelatihan Kerja (LPK) resmi yang berdedikasi membantu putra-putri Indonesia meraih karier sukses di Jepang.
            </p>
            <div className="flex gap-4">
              <a href="#" className="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[var(--sji-red)] transition-colors"><Facebook size={20} /></a>
              <a href="#" className="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[var(--sji-red)] transition-colors"><Instagram size={20} /></a>
              <a href="#" className="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[var(--sji-red)] transition-colors"><Youtube size={20} /></a>
            </div>
          </div>

          {/* Programs */}
          <div>
            <h4 className="font-bold text-lg mb-6">Program Kami</h4>
            <ul className="space-y-4 text-gray-400">
              <li><Link href="/programs/ssw" className="hover:text-white transition-colors">Tokutei Ginou (SSW)</Link></li>
              <li><Link href="/programs/magang" className="hover:text-white transition-colors">Magang Jepang</Link></li>
              <li><Link href="/classes/bahasa" className="hover:text-white transition-colors">Kursus Bahasa Jepang</Link></li>
              <li><Link href="/news" className="hover:text-white transition-colors">Info Lowongan Kerja</Link></li>
            </ul>
          </div>

          {/* Quick Links */}
          <div>
            <h4 className="font-bold text-lg mb-6">Tautan Cepat</h4>
            <ul className="space-y-4 text-gray-400">
              <li><Link href="/about" className="hover:text-white transition-colors">Tentang Kami</Link></li>
              <li><Link href="/faq" className="hover:text-white transition-colors">FAQ</Link></li>
              <li><Link href="/registration" className="hover:text-white transition-colors">Pendaftaran Online</Link></li>
              <li><Link href="/contact" className="hover:text-white transition-colors">Kontak</Link></li>
            </ul>
          </div>

          {/* Contact */}
          <div>
            <h4 className="font-bold text-lg mb-6">Hubungi Kami</h4>
            <ul className="space-y-4 text-gray-400">
              <li className="flex gap-3">
                <MapPin className="text-[var(--sji-red)] shrink-0" size={20} />
                <span>Perum Putri Juanda Blok C3/05, Sidoarjo, Jawa Timur</span>
              </li>
              <li className="flex gap-3">
                <Phone className="text-[var(--sji-red)] shrink-0" size={20} />
                <span>+62 813-3327-0022</span>
              </li>
              <li className="flex gap-3">
                <Mail className="text-[var(--sji-red)] shrink-0" size={20} />
                <span>official@sjigroup.co.id</span>
              </li>
            </ul>
          </div>
        </div>

        <div className="pt-10 border-t border-gray-800 text-center text-gray-500 text-sm">
          <p>© {new Date().getFullYear()} Sahabat Jepang Indonesia. All rights reserved.</p>
        </div>
      </div>
    </footer>
  );
}
