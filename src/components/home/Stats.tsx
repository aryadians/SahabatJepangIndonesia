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
    <section className="py-16 bg-[var(--sji-blue)] text-white">
      <div className="container mx-auto px-4">
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
          {stats.map((stat, index) => (
            <motion.div
              key={stat.label}
              initial={{ opacity: 0, scale: 0.5 }}
              whileInView={{ opacity: 1, scale: 1 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
              className="text-center"
            >
              <div className="text-4xl lg:text-5xl font-black mb-2 text-white">
                {stat.value}
              </div>
              <div className="text-blue-100 text-sm font-medium uppercase tracking-widest">
                {stat.label}
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
