'use client';

import { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ChevronRight, ChevronLeft, Check, User, GraduationCap, MapPin, Loader2, Sparkles } from 'lucide-react';
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
    <div className="max-w-4xl mx-auto px-4">
      {/* Progress Bar */}
      <div className="flex items-center justify-between mb-16 relative">
        <div className="absolute top-6 left-0 right-0 h-1 bg-slate-100 -z-10 rounded-full mx-8"></div>
        {steps.map((s, i) => (
          <div key={s.id} className="flex flex-col items-center gap-4 flex-1">
            <div className={`w-12 h-12 rounded-2xl flex items-center justify-center font-bold transition-all duration-500 z-10 border-4 border-slate-50 ${
              step >= s.id ? 'bg-[var(--sji-blue)] text-white shadow-xl shadow-blue-900/30' : 'bg-white text-slate-300 border-slate-50 shadow-sm'
            }`}>
              {step > s.id ? <Check size={20} /> : s.icon}
            </div>
            <span className={`text-[10px] font-black uppercase tracking-[0.2em] ${
              step >= s.id ? 'text-[var(--sji-blue)]' : 'text-slate-400'
            }`}>{s.name}</span>
          </div>
        ))}
      </div>

      {/* Form Content */}
      <div className="bg-white rounded-[3rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.08)] border border-slate-100 overflow-hidden flex flex-col min-h-[550px] relative">
        {/* Animated Background Decor */}
        <div className="absolute top-0 right-0 w-64 h-64 bg-slate-50/50 rounded-full -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

        <div className="p-8 lg:p-16 flex-1 relative z-10">
          <AnimatePresence mode="wait">
            {step === 1 && (
              <motion.div
                key="step1"
                initial={{ opacity: 0, x: 30 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -30 }}
                className="space-y-8"
              >
                <div className="space-y-2">
                  <h3 className="text-2xl font-black text-slate-900 flex items-center gap-3">
                    Informasi Personal <Sparkles className="text-yellow-400" size={20} />
                  </h3>
                  <p className="text-slate-500 font-medium">Lengkapi biodata diri Anda sesuai dengan dokumen resmi.</p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                  <div className="space-y-3">
                    <label className="text-xs font-black uppercase tracking-widest text-slate-400 ml-1">Nama Lengkap</label>
                    <input 
                      type="text" 
                      className="w-full px-6 py-4 rounded-[1.5rem] bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none font-bold text-slate-700" 
                      placeholder="Contoh: Ahmad Fauzi"
                      value={formData.name}
                      onChange={(e) => setFormData({...formData, name: e.target.value})}
                    />
                  </div>
                  <div className="space-y-3">
                    <label className="text-xs font-black uppercase tracking-widest text-slate-400 ml-1">Tanggal Lahir</label>
                    <input 
                      type="date" 
                      className="w-full px-6 py-4 rounded-[1.5rem] bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none font-bold text-slate-700"
                      value={formData.birthDate}
                      onChange={(e) => setFormData({...formData, birthDate: e.target.value})}
                    />
                  </div>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                  <div className="space-y-3">
                    <label className="text-xs font-black uppercase tracking-widest text-slate-400 ml-1">Email Aktif</label>
                    <input 
                      type="email" 
                      className="w-full px-6 py-4 rounded-[1.5rem] bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none font-bold text-slate-700" 
                      placeholder="email@example.com"
                      value={formData.email}
                      onChange={(e) => setFormData({...formData, email: e.target.value})}
                    />
                  </div>
                  <div className="space-y-3">
                    <label className="text-xs font-black uppercase tracking-widest text-slate-400 ml-1">Nomor WhatsApp</label>
                    <input 
                      type="tel" 
                      className="w-full px-6 py-4 rounded-[1.5rem] bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none font-bold text-slate-700" 
                      placeholder="081234567xxx"
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
                initial={{ opacity: 0, x: 30 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -30 }}
                className="space-y-8"
              >
                <div className="space-y-2">
                  <h3 className="text-2xl font-black text-slate-900 flex items-center gap-3">
                    Latar Belakang <GraduationCap className="text-[var(--sji-blue)]" size={24} />
                  </h3>
                  <p className="text-slate-500 font-medium">Informasi pendidikan dan domisili terbaru Anda.</p>
                </div>

                <div className="space-y-6">
                  <div className="space-y-3">
                    <label className="text-xs font-black uppercase tracking-widest text-slate-400 ml-1">Pendidikan Terakhir</label>
                    <select 
                      className="w-full px-6 py-4 rounded-[1.5rem] bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none font-bold text-slate-700"
                      value={formData.education}
                      onChange={(e) => setFormData({...formData, education: e.target.value})}
                    >
                      <option>SMA/SMK Sederajat</option>
                      <option>Diploma (D3)</option>
                      <option>Sarjana (S1/S2)</option>
                    </select>
                  </div>
                  <div className="space-y-3">
                    <label className="text-xs font-black uppercase tracking-widest text-slate-400 ml-1">Alamat Lengkap</label>
                    <textarea 
                      rows={4}
                      className="w-full px-6 py-4 rounded-[1.5rem] bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white transition-all outline-none resize-none font-bold text-slate-700 leading-relaxed" 
                      placeholder="Tuliskan alamat lengkap sesuai domisili saat ini"
                      value={formData.address}
                      onChange={(e) => setFormData({...formData, address: e.target.value})}
                    ></textarea>
                  </div>
                </div>
              </motion.div>
            )}

            {step === 3 && (
              <motion.div
                key="step3"
                initial={{ opacity: 0, x: 30 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -30 }}
                className="space-y-8"
              >
                <div className="space-y-2">
                  <h3 className="text-2xl font-black text-slate-900 flex items-center gap-3">
                    Pilihan Program <Sparkles className="text-red-500" size={20} />
                  </h3>
                  <p className="text-slate-500 font-medium">Pilih jalur karir yang Anda inginkan di Jepang.</p>
                </div>

                <div className="grid grid-cols-1 gap-4">
                  {['Tokutei Ginou (SSW)', 'Magang Jepang (Ginou Jisshuusei)', 'Kursus Bahasa Jepang'].map((p) => (
                    <label key={p} className={`flex items-center justify-between p-6 rounded-[2rem] border-2 cursor-pointer transition-all duration-300 ${
                      formData.program === p ? 'border-[var(--sji-blue)] bg-blue-50/50' : 'border-slate-50 hover:border-slate-200'
                    }`}>
                      <div className="flex items-center gap-5">
                        <div className={`w-7 h-7 rounded-full border-2 flex items-center justify-center transition-all ${
                          formData.program === p ? 'border-[var(--sji-blue)] bg-[var(--sji-blue)]' : 'border-slate-300'
                        }`}>
                          {formData.program === p && <Check className="text-white" size={14} />}
                        </div>
                        <span className={`font-black text-lg transition-colors ${formData.program === p ? 'text-slate-900' : 'text-slate-500'}`}>{p}</span>
                      </div>
                      <input type="radio" name="program" className="hidden" onChange={() => setFormData({...formData, program: p})} />
                    </label>
                  ))}
                </div>
              </motion.div>
            )}
          </AnimatePresence>
        </div>

        {/* Footer Actions */}
        <div className="p-8 lg:p-10 bg-slate-50/50 flex items-center justify-between border-t border-slate-100">
          <button 
            disabled={step === 1}
            onClick={prevStep}
            className={`flex items-center gap-2 font-black text-slate-400 hover:text-slate-900 transition-colors disabled:opacity-0 py-2 px-4`}
          >
            <ChevronLeft size={20} /> Kembali
          </button>
          
          {step < 3 ? (
            <button 
              onClick={nextStep}
              className="px-12 py-5 bg-[var(--sji-blue)] text-white font-black rounded-[1.5rem] shadow-2xl shadow-blue-900/30 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-3"
            >
              Lanjutkan <ChevronRight size={20} />
            </button>
          ) : (
            <button 
              disabled={loading}
              onClick={handleSubmit}
              className="px-12 py-5 bg-[var(--sji-red)] text-white font-black rounded-[1.5rem] shadow-2xl shadow-red-900/30 hover:bg-red-700 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-3"
            >
              {loading ? <Loader2 className="animate-spin" size={24} /> : (
                <>Kirim Pendaftaran <Check size={20} /></>
              )}
            </button>
          )}
        </div>
      </div>
    </div>
  );
}
