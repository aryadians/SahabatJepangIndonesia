'use client';

import { motion } from 'framer-motion';

export default function Stats() {
  const stats = [
    { label: 'Alumni Berangkat', value: '2,500+' },
    { label: 'Mitra Perusahaan', value: '150+' },
    { label: 'Tahun Pengalaman', value: '10+' },
    { label: 'Izin Resmi SO', value: 'Lengkap' }
  ];

  return (
    <section className="relative py-20 bg-slate-900 overflow-hidden">
      {/* Background Decor */}
      <div className="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
        <div className="absolute top-0 right-0 w-96 h-96 bg-[var(--sji-blue)] rounded-full blur-[120px]"></div>
        <div className="absolute bottom-0 left-0 w-96 h-96 bg-[var(--sji-red)] rounded-full blur-[120px]"></div>
      </div>

      <div className="container mx-auto px-6 relative z-10">
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
          {stats.map((stat, index) => (
            <motion.div
              key={stat.label}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1, duration: 0.6 }}
              className="text-center group"
            >
              <div className="text-5xl lg:text-6xl font-black mb-3 text-white tracking-tighter group-hover:scale-110 transition-transform duration-500">
                {stat.value}
              </div>
              <div className="text-slate-400 text-xs lg:text-sm font-black uppercase tracking-[0.2em]">
                {stat.label}
              </div>
              {/* Connector line for desktop */}
              {index !== stats.length - 1 && (
                <div className="hidden lg:block absolute top-1/2 -right-4 w-px h-12 bg-slate-800 -translate-y-1/2"></div>
              )}
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
