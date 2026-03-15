'use client';

import { useTranslations } from 'next-intl';
import { motion } from 'framer-motion';
import { ChevronRight } from 'lucide-react';
import { Link } from '@/i18n/routing';

export default function Hero() {
  const t = useTranslations('HomePage');

  return (
    <section className="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
      {/* Background Shapes */}
      <div className="absolute top-0 right-0 -z-10 opacity-10">
        <svg width="600" height="600" viewBox="0 0 600 600" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="400" cy="200" r="200" fill="var(--sji-blue)" />
          <circle cx="200" cy="400" r="200" fill="var(--sji-red)" />
        </svg>
      </div>

      <div className="container mx-auto px-4">
        <div className="flex flex-col lg:flex-row items-center gap-12">
          <div className="flex-1 text-center lg:text-left">
            <motion.span
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5 }}
              className="inline-block px-4 py-1.5 mb-6 text-sm font-bold tracking-wider text-[var(--sji-red)] uppercase bg-red-50 rounded-full"
            >
              {t('subtitle')}
            </motion.span>
            
            <motion.h1
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.1 }}
              className="text-5xl lg:text-7xl font-extrabold text-[var(--sji-blue)] leading-tight mb-6"
            >
              {t('title')}
            </motion.h1>

            <motion.p
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.2 }}
              className="text-xl text-gray-600 mb-10 max-w-2xl mx-auto lg:mx-0"
            >
              {t('hero_description')}
            </motion.p>

            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.3 }}
              className="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4"
            >
              <Link
                href="/registration"
                className="px-8 py-4 bg-[var(--sji-red)] text-white font-bold rounded-lg shadow-lg hover:bg-red-700 transition-all flex items-center gap-2 group"
              >
                {t('cta_join')}
                <ChevronRight size={20} className="group-hover:translate-x-1 transition-transform" />
              </Link>
              <Link
                href="/about"
                className="px-8 py-4 bg-white text-[var(--sji-blue)] font-bold rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 transition-all"
              >
                {t('cta_learn_more')}
              </Link>
            </motion.div>
          </div>

          <div className="flex-1 relative">
            <motion.div
              initial={{ opacity: 0, scale: 0.8 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 0.8, delay: 0.4 }}
              className="relative z-10"
            >
              {/* Placeholder for Hero Image / 3D Asset */}
              <div className="w-full aspect-square max-w-lg mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl relative overflow-hidden shadow-2xl border-8 border-white">
                <div className="absolute inset-0 flex items-center justify-center text-gray-400 font-bold text-lg p-10 text-center">
                  [ 3D Animation / Student Hero Image ]
                </div>
                
                {/* Decorative floating elements */}
                <motion.div
                  animate={{ y: [0, -20, 0] }}
                  transition={{ duration: 4, repeat: Infinity, ease: "easeInOut" }}
                  className="absolute top-10 right-10 w-20 h-20 bg-white/80 backdrop-blur rounded-2xl shadow-lg flex items-center justify-center text-4xl"
                >
                  🇯🇵
                </motion.div>
                <motion.div
                  animate={{ y: [0, 20, 0] }}
                  transition={{ duration: 5, repeat: Infinity, ease: "easeInOut" }}
                  className="absolute bottom-10 left-10 w-20 h-20 bg-white/80 backdrop-blur rounded-2xl shadow-lg flex items-center justify-center text-4xl"
                >
                  🇮🇩
                </motion.div>
              </div>
            </motion.div>
            
            {/* Dots Pattern */}
            <div className="absolute -bottom-10 -right-10 w-48 h-48 -z-10 text-gray-200">
               <svg width="100%" height="100%" fill="currentColor"><pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="2"></circle></pattern><rect width="100%" height="100%" fill="url(#dots)"></rect></svg>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
