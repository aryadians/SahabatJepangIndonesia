'use client';

import { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ChevronRight, ChevronLeft, Check, User, GraduationCap, MapPin, Loader2 } from 'lucide-react';
import { showSuccess, showError } from '@/lib/swal';
import { useRouter } from '@/i18n/routing';

export default function RegistrationWizard() {
  const [step, setStep] = useState(1);
  const [loading, setLoading] = useState(false);
  const router = useRouter();
  
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    program: 'Tokutei Ginou (SSW)',
    address: '',
    education: 'SMA/SMK',
    birthDate: '',
  });

  const nextStep = () => setStep(s => s + 1);
  const prevStep = () => setStep(s => s - 1);

  const handleSubmit = async () => {
    setLoading(true);
    try {
      const res = await fetch('/api/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
      });

      if (!res.ok) throw new Error("Gagal mendaftar");

      showSuccess("Pendaftaran Berhasil", "Selamat! Data Anda telah tersimpan. Tim kami akan menghubungi via WhatsApp.").then(() => {
        router.push('/');
      });
    } catch (error) {
      showError("Oops!", "Terjadi kesalahan sistem. Silakan coba lagi.");
    } finally {
      setLoading(false);
    }
  };

  const steps = [
    { id: 1, name: 'Biodata', icon: <User size={18} /> },
    { id: 2, name: 'Pendidikan', icon: <GraduationCap size={18} /> },
    { id: 3, name: 'Program', icon: <MapPin size={18} /> },
  ];

  return (
    <div className="max-w-4xl mx-auto">
      {/* Progress Bar */}
      <div className="flex items-center justify-between mb-12 px-4">
        {steps.map((s, i) => (
          <div key={s.id} className="flex items-center flex-1 last:flex-none">
            <div className={`flex flex-col items-center relative z-10`}>
              <div className={`w-12 h-12 rounded-2xl flex items-center justify-center font-bold transition-all duration-500 ${
                step >= s.id ? 'bg-[var(--sji-blue)] text-white shadow-lg shadow-blue-900/20' : 'bg-slate-100 text-slate-400'
              }`}>
                {step > s.id ? <Check size={20} /> : s.icon}
              </div>
              <span className={`absolute -bottom-8 text-xs font-bold whitespace-nowrap ${
                step >= s.id ? 'text-[var(--sji-blue)]' : 'text-slate-400'
              }`}>{s.name}</span>
            </div>
            {i !== steps.length - 1 && (
              <div className="flex-1 h-1 mx-4 bg-slate-100 rounded-full overflow-hidden">
                <motion.div 
                  className="h-full bg-[var(--sji-blue)]"
                  initial={{ width: '0%' }}
                  animate={{ width: step > s.id ? '100%' : '0%' }}
                />
              </div>
            )}
          </div>
        ))}
      </div>

      {/* Form Content */}
      <div className="bg-white rounded-[3rem] shadow-2xl border border-slate-100 overflow-hidden min-h-[500px] flex flex-col">
        <div className="p-8 lg:p-12 flex-1">
          <AnimatePresence mode="wait">
            {step === 1 && (
              <motion.div
                key="step1"
                initial={{ opacity: 0, x: 20 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -20 }}
                className="space-y-6"
              >
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div className="space-y-2">
                    <label className="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                    <input 
                      type="text" 
                      className="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none" 
                      placeholder="Sesuai KTP"
                      value={formData.name}
                      onChange={(e) => setFormData({...formData, name: e.target.value})}
                    />
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-bold text-slate-700 ml-1">Tanggal Lahir</label>
                    <input 
                      type="date" 
                      className="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none"
                      value={formData.birthDate}
                      onChange={(e) => setFormData({...formData, birthDate: e.target.value})}
                    />
                  </div>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div className="space-y-2">
                    <label className="text-sm font-bold text-slate-700 ml-1">Email</label>
                    <input 
                      type="email" 
                      className="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none" 
                      placeholder="email@example.com"
                      value={formData.email}
                      onChange={(e) => setFormData({...formData, email: e.target.value})}
                    />
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-bold text-slate-700 ml-1">WhatsApp</label>
                    <input 
                      type="tel" 
                      className="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none" 
                      placeholder="0812xxxx"
                      value={formData.phone}
                      onChange={(e) => setFormData({...formData, phone: e.target.value})}
                    />
                  </div>
                </div>
              </motion.div>
            )}

            {step === 2 && (
              <motion.div
                key="step2"
                initial={{ opacity: 0, x: 20 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -20 }}
                className="space-y-6"
              >
                <div className="space-y-2">
                  <label className="text-sm font-bold text-slate-700 ml-1">Pendidikan Terakhir</label>
                  <select 
                    className="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none"
                    value={formData.education}
                    onChange={(e) => setFormData({...formData, education: e.target.value})}
                  >
                    <option>SMA/SMK</option>
                    <option>Diploma (D3)</option>
                    <option>Sarjana (S1)</option>
                  </select>
                </div>
                <div className="space-y-2">
                  <label className="text-sm font-bold text-slate-700 ml-1">Alamat Lengkap</label>
                  <textarea 
                    rows={4}
                    className="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none resize-none" 
                    placeholder="Alamat domisili saat ini"
                    value={formData.address}
                    onChange={(e) => setFormData({...formData, address: e.target.value})}
                  ></textarea>
                </div>
              </motion.div>
            )}

            {step === 3 && (
              <motion.div
                key="step3"
                initial={{ opacity: 0, x: 20 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -20 }}
                className="space-y-6"
              >
                <div className="space-y-4">
                  <h4 className="font-bold text-slate-900">Pilih Program Anda</h4>
                  <div className="grid grid-cols-1 gap-4">
                    {['Tokutei Ginou (SSW)', 'Magang Jepang (Ginou Jisshuusei)', 'Kursus Bahasa Jepang'].map((p) => (
                      <label key={p} className={`flex items-center justify-between p-6 rounded-[2rem] border-2 cursor-pointer transition-all ${
                        formData.program === p ? 'border-[var(--sji-blue)] bg-blue-50' : 'border-slate-50 hover:border-slate-200'
                      }`}>
                        <div className="flex items-center gap-4">
                          <div className={`w-6 h-6 rounded-full border-2 flex items-center justify-center ${
                            formData.program === p ? 'border-[var(--sji-blue)]' : 'border-slate-300'
                          }`}>
                            {formData.program === p && <div className="w-3 h-3 bg-[var(--sji-blue)] rounded-full" />}
                          </div>
                          <span className="font-bold text-slate-700">{p}</span>
                        </div>
                        <input type="radio" name="program" className="hidden" onChange={() => setFormData({...formData, program: p})} />
                      </label>
                    ))}
                  </div>
                </div>
              </motion.div>
            )}
          </AnimatePresence>
        </div>

        {/* Footer Actions */}
        <div className="p-8 bg-slate-50 flex items-center justify-between">
          <button 
            disabled={step === 1}
            onClick={prevStep}
            className={`flex items-center gap-2 font-bold text-slate-500 hover:text-slate-900 transition-colors disabled:opacity-0`}
          >
            <ChevronLeft size={20} /> Sebelumnya
          </button>
          
          {step < 3 ? (
            <button 
              onClick={nextStep}
              className="px-10 py-4 bg-[var(--sji-blue)] text-white font-bold rounded-[1.5rem] shadow-xl shadow-blue-900/20 hover:bg-blue-700 transition-all flex items-center gap-2"
            >
              Lanjutkan <ChevronRight size={20} />
            </button>
          ) : (
            <button 
              disabled={loading}
              onClick={handleSubmit}
              className="px-10 py-4 bg-[var(--sji-red)] text-white font-bold rounded-[1.5rem] shadow-xl shadow-red-900/20 hover:bg-red-700 transition-all flex items-center gap-2"
            >
              {loading ? <Loader2 className="animate-spin" size={20} /> : 'Kirim Pendaftaran'}
            </button>
          )}
        </div>
      </div>
    </div>
  );
}
