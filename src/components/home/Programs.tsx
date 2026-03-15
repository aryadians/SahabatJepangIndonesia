'use client';

import { useTranslations } from 'next-intl';
import { motion } from 'framer-motion';
import { BookOpen, Briefcase, GraduationCap } from 'lucide-react';

export default function Programs() {
  const t = useTranslations('Programs');

  const programs = [
    {
      id: 'ssw',
      title: t('ssw'),
      desc: t('ssw_desc'),
      icon: <Briefcase className="w-8 h-8 text-blue-600" />,
      color: 'bg-blue-50'
    },
    {
      id: 'magang',
      title: t('magang'),
      desc: t('magang_desc'),
      icon: <GraduationCap className="w-8 h-8 text-red-600" />,
      color: 'bg-red-50'
    },
    {
      id: 'kursus',
      title: t('kursus'),
      desc: t('kursus_desc'),
      icon: <BookOpen className="w-8 h-8 text-green-600" />,
      color: 'bg-green-50'
    }
  ];

  return (
    <section className="py-24 bg-white">
      <div className="container mx-auto px-4">
        <div className="text-center mb-16">
          <motion.h2 
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="text-4xl font-extrabold text-[var(--sji-blue)] mb-4"
          >
            {t('title')}
          </motion.h2>
          <div className="w-20 h-1.5 bg-[var(--sji-red)] mx-auto rounded-full"></div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {programs.map((program, index) => (
            <motion.div
              key={program.id}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              whileHover={{ y: -10 }}
              className="p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all group"
            >
              <div className={`w-16 h-16 ${program.color} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform`}>
                {program.icon}
              </div>
              <h3 className="text-2xl font-bold text-gray-800 mb-4">{program.title}</h3>
              <p className="text-gray-600 leading-relaxed mb-6">{program.desc}</p>
              <button className="text-[var(--sji-blue)] font-bold flex items-center gap-2 hover:gap-3 transition-all">
                Detail Program →
              </button>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
