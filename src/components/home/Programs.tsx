'use client';

import { useTranslations } from 'next-intl';
import { motion } from 'framer-motion';
import { BookOpen, Briefcase, GraduationCap, ChevronRight } from 'lucide-react';
import { Link } from '@/i18n/routing';

export default function Programs() {
  const t = useTranslations('Programs');

  const programs = [
    {
      id: 'ssw',
      title: t('ssw'),
      desc: t('ssw_desc'),
      icon: <Briefcase className="w-8 h-8 text-blue-600" />,
      color: 'bg-blue-50',
      borderColor: 'group-hover:border-blue-200'
    },
    {
      id: 'magang',
      title: t('magang'),
      desc: t('magang_desc'),
      icon: <GraduationCap className="w-8 h-8 text-red-600" />,
      color: 'bg-red-50',
      borderColor: 'group-hover:border-red-200'
    },
    {
      id: 'kursus',
      title: t('kursus'),
      desc: t('kursus_desc'),
      icon: <BookOpen className="w-8 h-8 text-green-600" />,
      color: 'bg-green-50',
      borderColor: 'group-hover:border-green-200'
    }
  ];

  return (
    <section className="py-32 bg-white relative overflow-hidden">
      <div className="container mx-auto px-6">
        <div className="text-center max-w-3xl mx-auto mb-20">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="text-[var(--sji-red)] font-black uppercase tracking-[0.2em] text-xs mb-4"
          >
            Explore Career Paths
          </motion.div>
          <motion.h2 
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ delay: 0.1 }}
            className="text-4xl md:text-6xl font-black text-slate-900 mb-6 tracking-tight"
          >
            {t('title')}
          </motion.h2>
          <motion.p
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ delay: 0.2 }}
            className="text-lg text-slate-500 font-medium"
          >
            Pilih program yang paling sesuai dengan kualifikasi dan tujuan karir Anda di Jepang.
          </motion.p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
          {programs.map((program, index) => (
            <motion.div
              key={program.id}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              whileHover={{ y: -12 }}
              className="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] hover:shadow-[0_40px_80px_-15px_rgba(0,0,0,0.1)] transition-all duration-500 group relative"
            >
              <div className={`w-20 h-20 ${program.color} rounded-[2rem] flex items-center justify-center mb-10 group-hover:scale-110 transition-transform duration-500 shadow-inner`}>
                {program.icon}
              </div>
              <h3 className="text-2xl font-black text-slate-900 mb-4 tracking-tight">{program.title}</h3>
              <p className="text-slate-500 font-medium leading-relaxed mb-10">{program.desc}</p>
              
              <Link 
                href="/programs" 
                className="inline-flex items-center gap-2 text-slate-900 font-black hover:text-[var(--sji-blue)] transition-colors"
              >
                Detail Program <ChevronRight size={18} className="group-hover:translate-x-1 transition-transform" />
              </Link>

              {/* Decorative corner */}
              <div className="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-slate-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-tr-[3rem]"></div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
