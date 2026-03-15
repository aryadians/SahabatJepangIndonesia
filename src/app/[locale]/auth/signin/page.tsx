'use client';

import { signIn } from "next-auth/react";
import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { Link, useRouter } from "@/i18n/routing";
import { Mail, Lock, ArrowRight, Loader2, ShieldCheck, ChevronLeft } from "lucide-react";
import { showError, showSuccess } from "@/lib/swal";
import Image from "next/image";

export default function SignInPage() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const router = useRouter();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);

    const res = await signIn("credentials", {
      email,
      password,
      redirect: false,
    });

    if (res?.error) {
      showError("Akses Ditolak", "Kombinasi email atau password tidak ditemukan dalam sistem kami.");
      setLoading(false);
    } else {
      showSuccess("Login Berhasil", "Selamat datang kembali di Management System SJI.").then(() => {
        router.push("/admin/dashboard");
      });
    }
  };

  return (
    <main className="min-h-screen bg-[#050A1A] flex items-center justify-center p-6 relative overflow-hidden">
      {/* 3D Background Decor */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        <motion.div 
          animate={{ 
            scale: [1, 1.2, 1],
            opacity: [0.1, 0.2, 0.1]
          }}
          transition={{ duration: 10, repeat: Infinity }}
          className="absolute -top-1/4 -right-1/4 w-full h-full bg-[var(--sji-blue)] rounded-full blur-[120px]"
        />
        <motion.div 
          animate={{ 
            scale: [1.2, 1, 1.2],
            opacity: [0.05, 0.15, 0.05]
          }}
          transition={{ duration: 15, repeat: Infinity }}
          className="absolute -bottom-1/4 -left-1/4 w-full h-full bg-[var(--sji-red)] rounded-full blur-[120px]"
        />
      </div>

      <div className="container max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
        
        {/* Left Side: Visual Info */}
        <div className="hidden lg:block space-y-10">
          <Link href="/" className="inline-flex items-center gap-3 text-white hover:text-slate-300 transition-colors group">
            <ChevronLeft size={20} className="group-hover:-translate-x-1 transition-transform" />
            <span className="font-black uppercase tracking-[0.2em] text-xs">Kembali ke Beranda</span>
          </Link>
          
          <div className="space-y-6">
            <h1 className="text-6xl xl:text-8xl font-black text-white leading-none tracking-tighter">
              Portal <br /> <span className="text-[var(--sji-blue)]">Manajemen</span> <br /> SJI.
            </h1>
            <p className="text-slate-400 text-xl font-medium max-w-md leading-relaxed">
              Satu sistem terintegrasi untuk mengelola ribuan masa depan putra-putri terbaik Indonesia di Jepang.
            </p>
          </div>

          <div className="flex gap-8 items-center pt-10">
            <div className="flex -space-x-4">
              {[1, 2, 3, 4].map(i => (
                <div key={i} className="w-12 h-12 rounded-2xl border-4 border-[#050A1A] bg-slate-800 flex items-center justify-center text-white text-xs font-black">
                  {i}
                </div>
              ))}
            </div>
            <p className="text-slate-500 font-bold text-sm uppercase tracking-widest">Digunakan oleh 50+ Staff SJI</p>
          </div>
        </div>

        {/* Right Side: Login Card with 3D-ish Hover */}
        <motion.div 
          initial={{ opacity: 0, x: 50 }}
          animate={{ opacity: 1, x: 0 }}
          className="perspective-1000"
        >
          <motion.div 
            whileHover={{ rotateY: -5, rotateX: 5 }}
            className="max-w-md w-full mx-auto bg-white rounded-[3.5rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] overflow-hidden border border-white/10 relative group"
          >
            <div className="p-10 lg:p-14 space-y-10">
              <div className="text-center space-y-4">
                <div className="w-16 h-16 bg-[var(--sji-red)] rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto shadow-2xl shadow-red-500/40 group-hover:scale-110 transition-transform duration-500">
                  SJI
                </div>
                <div className="space-y-1">
                  <h2 className="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang</h2>
                  <p className="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Silakan masuk untuk melanjutkan</p>
                </div>
              </div>

              <form onSubmit={handleSubmit} className="space-y-6">
                <div className="space-y-4">
                  <div className="group/input space-y-2">
                    <label className="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Email System</label>
                    <div className="relative">
                      <Mail className="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-[var(--sji-blue)] transition-colors" size={20} />
                      <input
                        required
                        type="email"
                        placeholder="admin@sjigroup.co.id"
                        className="w-full pl-14 pr-6 py-5 bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white rounded-2xl outline-none transition-all font-bold text-slate-700"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                      />
                    </div>
                  </div>
                  
                  <div className="group/input space-y-2">
                    <label className="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Password</label>
                    <div className="relative">
                      <Lock className="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-[var(--sji-blue)] transition-colors" size={20} />
                      <input
                        required
                        type="password"
                        placeholder="••••••••"
                        className="w-full pl-14 pr-6 py-5 bg-slate-50 border-2 border-transparent focus:border-[var(--sji-blue)] focus:bg-white rounded-2xl outline-none transition-all font-bold text-slate-700"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                      />
                    </div>
                  </div>
                </div>

                <div className="flex items-center justify-between px-1">
                  <label className="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" className="w-4 h-4 rounded border-slate-200 text-[var(--sji-blue)] focus:ring-[var(--sji-blue)]" />
                    <span className="text-xs font-bold text-slate-500 group-hover:text-slate-700 transition-colors">Ingat Saya</span>
                  </label>
                  <a href="#" className="text-xs font-black text-[var(--sji-blue)] uppercase tracking-widest hover:underline">Lupa?</a>
                </div>

                <button
                  disabled={loading}
                  type="submit"
                  className="w-full py-5 bg-[var(--sji-blue)] text-white font-black rounded-[1.5rem] shadow-2xl shadow-blue-900/30 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3 group disabled:bg-slate-300 disabled:shadow-none"
                >
                  {loading ? (
                    <Loader2 className="animate-spin" size={24} />
                  ) : (
                    <>Masuk Sekarang <ArrowRight size={20} className="group-hover:translate-x-1 transition-transform" /></>
                  )}
                </button>
              </form>

              <div className="pt-4 flex items-center justify-center gap-2 text-slate-400">
                <ShieldCheck size={16} className="text-green-500" />
                <span className="text-[10px] font-black uppercase tracking-[0.2em]">Secure Encryption Active</span>
              </div>
            </div>
            
            <div className="bg-slate-900 p-6 text-center">
              <p className="text-slate-500 text-[10px] font-black uppercase tracking-[0.3em]">Management System v2.0</p>
            </div>
          </motion.div>
        </motion.div>
      </div>

      {/* Decorative Text */}
      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[300px] font-black text-white/[0.02] select-none pointer-events-none tracking-tighter rotate-12">
        SJI
      </div>
    </main>
  );
}
