'use client';

import { useTranslations } from 'next-intl';
import { Link, usePathname, useRouter } from '@/i18n/routing';
import { useState } from 'react';
import { Menu, X, Globe } from 'lucide-react';

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
    <header className="fixed top-0 left-0 right-0 bg-white/80 backdrop-blur-md z-50 shadow-sm">
      <div className="container mx-auto px-4 h-20 flex items-center justify-between">
        {/* Logo */}
        <Link href="/" className="flex items-center gap-2 group">
          <div className="w-10 h-10 bg-[var(--sji-red)] rounded-full flex items-center justify-center text-white font-bold group-hover:bg-[var(--sji-blue)] transition-colors duration-300">
            SJI
          </div>
          <span className="font-bold text-xl hidden sm:block tracking-tight text-[var(--sji-blue)]">
            Sahabat Jepang <span className="text-[var(--sji-red)]">Indonesia</span>
          </span>
        </Link>

        {/* Desktop Nav */}
        <nav className="hidden lg:flex items-center gap-8">
          {navItems.map((item) => (
            <Link
              key={item.path}
              href={item.path as any}
              className={`font-medium hover:text-[var(--sji-red)] transition-colors ${
                pathname === item.path ? 'text-[var(--sji-red)]' : 'text-gray-600'
              }`}
            >
              {item.name}
            </Link>
          ))}

          {/* Language Switcher */}
          <div className="flex items-center gap-2 border-l pl-6 ml-2">
            <Globe size={18} className="text-gray-400" />
            <div className="flex gap-2">
              {locales.map((loc) => (
                <button
                  key={loc.code}
                  onClick={() => handleLocaleChange(loc.code)}
                  className={`text-xs px-2 py-1 rounded transition-all ${
                    pathname.startsWith(`/${loc.code}`) || (pathname === '/' && loc.code === 'id')
                      ? 'bg-[var(--sji-blue)] text-white'
                      : 'hover:bg-gray-100 text-gray-600'
                  }`}
                >
                  {loc.label}
                </button>
              ))}
            </div>
          </div>
        </nav>

        {/* Mobile Toggle */}
        <button className="lg:hidden p-2" onClick={() => setIsOpen(!isOpen)}>
          {isOpen ? <X /> : <Menu />}
        </button>
      </div>

      {/* Mobile Nav */}
      {isOpen && (
        <div className="lg:hidden bg-white border-t px-4 py-6 flex flex-col gap-4">
          {navItems.map((item) => (
            <Link
              key={item.path}
              href={item.path as any}
              className="text-lg font-medium text-gray-600"
              onClick={() => setIsOpen(false)}
            >
              {item.name}
            </Link>
          ))}
          <div className="pt-4 border-t flex gap-4 items-center">
            <span className="text-sm font-medium text-gray-500">Language:</span>
            {locales.map((loc) => (
              <button
                key={loc.code}
                onClick={() => handleLocaleChange(loc.code)}
                className="text-sm font-bold text-[var(--sji-blue)]"
              >
                {loc.label}
              </button>
            ))}
          </div>
        </div>
      )}
    </header>
  );
}
