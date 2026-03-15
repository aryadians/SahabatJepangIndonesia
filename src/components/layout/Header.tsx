'use client';

import { useTranslations } from 'next-intl';
import { Link, usePathname, useRouter } from '@/i18n/routing';
import { useState } from 'react';
import { Menu, X, Globe } from 'lucide-react';

import { AnimatePresence, motion } from 'framer-motion';

export default function Header() {
  const t = useTranslations('Navigation');
  const [isOpen, setIsOpen] = useState(false);
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
    { name: t('programs'), path: '/programs' },
    { name: t('classes'), path: '/classes' },
    { name: t('news'), path: '/news' },
    { name: t('contact'), path: '/contact' }
  ];

  return (
    <header className="fixed top-0 left-0 right-0 bg-white/90 backdrop-blur-xl z-50 border-b border-gray-100/50">
      <div className="container mx-auto px-6 h-20 flex items-center justify-between">
        {/* Logo */}
        <Link href="/" className="flex items-center gap-3 group">
          <div className="w-11 h-11 bg-[var(--sji-red)] rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-red-500/20 group-hover:rotate-6 transition-transform duration-300">
            SJI
          </div>
          <span className="font-black text-xl hidden sm:block tracking-tighter text-[var(--sji-blue)]">
            Sahabat Jepang <span className="text-[var(--sji-red)] underline decoration-2 underline-offset-4 decoration-red-200">Indonesia</span>
          </span>
        </Link>

        {/* Desktop Nav */}
        <nav className="hidden lg:flex items-center gap-1">
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

          {/* Language Switcher */}
          <div className="flex items-center gap-1 border-l border-slate-100 pl-4 ml-4">
            {locales.map((loc) => (
              <button
                key={loc.code}
                onClick={() => handleLocaleChange(loc.code)}
                className={`text-[10px] font-black px-2.5 py-1.5 rounded-lg transition-all ${
                  pathname.startsWith(`/${loc.code}`) || (pathname === '/' && loc.code === 'id')
                    ? 'bg-[var(--sji-blue)] text-white shadow-md shadow-blue-900/20'
                    : 'text-slate-400 hover:text-slate-600'
                }`}
              >
                {loc.label}
              </button>
            ))}
          </div>
        </nav>

        {/* Mobile Toggle */}
        <button 
          className="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-900 active:scale-90 transition-all" 
          onClick={() => setIsOpen(!isOpen)}
        >
          {isOpen ? <X size={20} /> : <Menu size={20} />}
        </button>
      </div>

      {/* Mobile Nav */}
      <AnimatePresence>
        {isOpen && (
          <motion.div 
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: 'auto' }}
            exit={{ opacity: 0, height: 0 }}
            className="lg:hidden bg-white border-t border-slate-50 overflow-hidden"
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
              <div className="mt-6 pt-6 border-t border-slate-50 flex items-center justify-between px-4">
                <span className="text-xs font-black uppercase tracking-widest text-slate-400">Language</span>
                <div className="flex gap-2">
                  {locales.map((loc) => (
                    <button
                      key={loc.code}
                      onClick={() => handleLocaleChange(loc.code)}
                      className={`text-xs font-black px-4 py-2 rounded-xl border ${
                        pathname.startsWith(`/${loc.code}`) || (pathname === '/' && loc.code === 'id')
                          ? 'bg-[var(--sji-blue)] text-white border-[var(--sji-blue)] shadow-lg shadow-blue-900/20'
                          : 'border-slate-100 text-slate-600'
                      }`}
                    >
                      {loc.label}
                    </button>
                  ))}
                </div>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </header>
  );
}
