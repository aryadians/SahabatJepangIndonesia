'use client';

import { useTranslations } from 'next-intl';
import { Link, usePathname, useRouter } from '@/i18n/routing';
import { useState } from 'react';
import { Menu, X, Globe, LogIn, UserCircle } from 'lucide-react';
import { useSession, signOut } from "next-auth/react";
import { AnimatePresence, motion } from 'framer-motion';

export default function Header() {
  const t = useTranslations('Navigation');
  const [isOpen, setIsOpen] = useState(false);
  const { data: session } = useSession();
  const pathname = usePathname();
  const router = useRouter();

  const locales = [
    { code: 'id', label: 'ID' },
    { code: 'ja', label: 'JP' },
    { code: 'en', label: 'EN' }
  ];

  const handleLocaleChange = (newLocale: string) => {
    router.replace(pathname, { locale: newLocale });
  };

  const navItems = [
    { name: t('home'), path: '/' },
    { name: t('about'), path: '/about' },
    { name: 'Sensei', path: '/about/teachers' },
    { name: t('programs'), path: '/programs' },
    { name: t('classes'), path: '/classes' },
    { name: t('news'), path: '/news' },
    { name: t('faq'), path: '/faq' },
    { name: t('contact'), path: '/contact' }
  ];

  return (
    <header className="fixed top-0 left-0 right-0 bg-white/90 backdrop-blur-xl z-50 border-b border-gray-100/50">
      <div className="container mx-auto px-6 h-24 flex items-center justify-between">
        {/* Logo */}
        <Link href="/" className="flex items-center gap-3 group">
          <div className="w-12 h-12 bg-[var(--sji-red)] rounded-2xl flex items-center justify-center text-white font-black shadow-xl shadow-red-500/20 group-hover:rotate-12 transition-transform duration-500">
            SJI
          </div>
          <div className="flex flex-col">
            <span className="font-black text-xl tracking-tighter text-[var(--sji-blue)] leading-none">
              Sahabat Jepang
            </span>
            <span className="text-[var(--sji-red)] font-black uppercase tracking-[0.2em] text-[10px] mt-1">Indonesia</span>
          </div>
        </Link>

        {/* Desktop Nav */}
        <nav className="hidden xl:flex items-center gap-1">
          {navItems.map((item) => (
            <Link
              key={item.path}
              href={item.path as any}
              className={`px-4 py-2 rounded-xl text-sm font-bold transition-all ${
                pathname === item.path 
                  ? 'text-[var(--sji-red)] bg-red-50' 
                  : 'text-slate-600 hover:text-[var(--sji-blue)] hover:bg-slate-50'
              }`}
            >
              {item.name}
            </Link>
          ))}

          {/* User Auth / Login Button */}
          <div className="flex items-center gap-4 border-l border-slate-100 pl-6 ml-4">
            <div className="flex gap-1 mr-2">
              {locales.map((loc) => (
                <button
                  key={loc.code}
                  onClick={() => handleLocaleChange(loc.code)}
                  className={`text-[10px] font-black px-2 py-1 rounded-lg transition-all ${
                    pathname.startsWith(`/${loc.code}`) || (pathname === '/' && loc.code === 'id')
                      ? 'bg-slate-900 text-white shadow-lg'
                      : 'text-slate-400 hover:text-slate-600'
                  }`}
                >
                  {loc.label}
                </button>
              ))}
            </div>

            {session ? (
              <Link 
                href={session.user.role === 'STUDENT' ? '/student/portal' : '/admin/dashboard' as any}
                className="flex items-center gap-3 bg-slate-50 p-1 pr-4 rounded-full border border-slate-100 hover:bg-white transition-all shadow-sm group"
              >
                <div className="w-8 h-8 rounded-full bg-[var(--sji-blue)] flex items-center justify-center text-white text-xs font-black">
                  {session.user.name?.charAt(0)}
                </div>
                <span className="text-xs font-black text-slate-700 uppercase tracking-widest">{session.user.role}</span>
              </Link>
            ) : (
              <Link 
                href="/auth/signin"
                className="flex items-center gap-2 px-6 py-3 bg-[var(--sji-blue)] text-white font-black text-xs uppercase tracking-[0.1em] rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-blue-700 hover:scale-105 active:scale-95 transition-all group"
              >
                <LogIn size={16} className="group-hover:-translate-x-1 transition-transform" />
                Login SJI
              </Link>
            )}
          </div>
        </nav>

        {/* Mobile Toggle */}
        <div className="flex items-center gap-4 xl:hidden">
          {!session && (
            <Link href="/auth/signin" className="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-50 text-[var(--sji-blue)]">
              <LogIn size={20} />
            </Link>
          )}
          <button 
            className="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-900 active:scale-90 transition-all shadow-sm" 
            onClick={() => setIsOpen(!isOpen)}
          >
            {isOpen ? <X size={20} /> : <Menu size={20} />}
          </button>
        </div>
      </div>

      {/* Mobile Nav */}
      <AnimatePresence>
        {isOpen && (
          <motion.div 
            initial={{ opacity: 0, y: -20 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -20 }}
            className="xl:hidden bg-white border-t border-slate-50 overflow-hidden shadow-2xl"
          >
            <div className="px-6 py-8 flex flex-col gap-2">
              {navItems.map((item) => (
                <Link
                  key={item.path}
                  href={item.path as any}
                  className={`px-4 py-3 rounded-2xl font-bold transition-all ${
                    pathname === item.path 
                      ? 'bg-red-50 text-[var(--sji-red)]' 
                      : 'text-slate-600 active:bg-slate-50'
                  }`}
                  onClick={() => setIsOpen(false)}
                >
                  {item.name}
                </Link>
              ))}
              <div className="mt-6 pt-6 border-t border-slate-50">
                {session ? (
                  <button 
                    onClick={() => signOut()}
                    className="w-full py-4 bg-red-50 text-[var(--sji-red)] font-black rounded-2xl flex items-center justify-center gap-2"
                  >
                    Keluar Sistem
                  </button>
                ) : (
                  <Link 
                    href="/auth/signin"
                    className="w-full py-4 bg-[var(--sji-blue)] text-white font-black rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20"
                    onClick={() => setIsOpen(false)}
                  >
                    Login ke Portal
                  </Link>
                )}
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </header>
  );
}
