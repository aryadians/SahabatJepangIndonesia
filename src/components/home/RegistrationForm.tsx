'use client';

import { useTranslations } from 'next-intl';
import { motion } from 'framer-motion';
import { useState } from 'react';
import { showSuccess } from '@/lib/swal';
import { useRouter } from '@/i18n/routing';

export default function RegistrationForm() {
  const t = useTranslations('Registration');
  const router = useRouter();
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    
    // Simulate API Call
    setTimeout(() => {
      setLoading(false);
      showSuccess(t('success_title'), t('success_msg')).then(() => {
        router.push('/');
      });
    }, 1500);
  };

  return (
    <motion.div
      initial={{ opacity: 0, scale: 0.95 }}
      animate={{ opacity: 1, scale: 1 }}
      className="max-w-3xl mx-auto bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100"
    >
      <div className="flex flex-col md:flex-row h-full">
        {/* Left Side Info */}
        <div className="md:w-1/3 bg-[var(--sji-blue)] p-10 text-white flex flex-col justify-between relative overflow-hidden">
          <div className="z-10">
            <h3 className="text-2xl font-bold mb-4">{t('personal_data')}</h3>
            <p className="text-blue-100 text-sm leading-relaxed">
              Pastikan data yang diisi benar sesuai KTP dan dokumen resmi lainnya.
            </p>
          </div>
          
          <div className="mt-20 z-10">
            <div className="flex -space-x-3">
              {[1, 2, 3, 4].map((i) => (
                <div key={i} className="w-10 h-10 rounded-full border-2 border-[var(--sji-blue)] bg-gray-200"></div>
              ))}
            </div>
            <p className="text-xs text-blue-100 mt-4">+2.5k alumni telah bergabung</p>
          </div>

          {/* Decorative Circle */}
          <div className="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full"></div>
        </div>

        {/* Form Side */}
        <form onSubmit={handleSubmit} className="md:w-2/3 p-10 space-y-6">
          <div className="space-y-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">{t('full_name')}</label>
              <input
                required
                type="text"
                className="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[var(--sji-blue)] focus:border-transparent outline-none transition-all text-gray-700"
                placeholder="Contoh: Ahmad Fauzi"
              />
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">{t('email')}</label>
                <input
                  required
                  type="email"
                  className="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[var(--sji-blue)] focus:border-transparent outline-none transition-all text-gray-700"
                  placeholder="ahmad@example.com"
                />
              </div>
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">{t('phone')}</label>
                <input
                  required
                  type="tel"
                  className="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[var(--sji-blue)] focus:border-transparent outline-none transition-all text-gray-700"
                  placeholder="081234567xxx"
                />
              </div>
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">{t('program_interest')}</label>
              <select className="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[var(--sji-blue)] focus:border-transparent outline-none transition-all text-gray-700 bg-white">
                <option>Tokutei Ginou (SSW)</option>
                <option>Magang Jepang</option>
                <option>Kursus Bahasa Jepang</option>
              </select>
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">{t('address')}</label>
              <textarea
                rows={3}
                className="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[var(--sji-blue)] focus:border-transparent outline-none transition-all text-gray-700 resize-none"
                placeholder="Jl. Raya Utama No. 123, Sidoarjo..."
              ></textarea>
            </div>
          </div>

          <button
            type="submit"
            disabled={loading}
            className={`w-full py-4 rounded-xl font-bold text-white transition-all transform hover:scale-[1.02] active:scale-95 shadow-lg ${
              loading ? 'bg-gray-400 cursor-not-allowed' : 'bg-[var(--sji-red)] hover:bg-red-700'
            }`}
          >
            {loading ? 'Processing...' : t('submit')}
          </button>
        </form>
      </div>
    </motion.div>
  );
}
