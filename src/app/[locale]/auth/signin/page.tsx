'use client';

import { signIn } from "next-auth/react";
import { useState } from "react";
import { motion } from "framer-motion";
import { Link, useRouter } from "@/i18n/routing";
import { Mail, Lock, ArrowRight, Loader2 } from "lucide-react";
import { showError } from "@/lib/swal";

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
      showError("Login Gagal", "Email atau password salah.");
      setLoading(false);
    } else {
      router.push("/admin/dashboard");
    }
  };

  return (
    <main className="min-h-screen bg-slate-50 flex items-center justify-center p-4">
      <motion.div 
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="max-w-md w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100"
      >
        <div className="p-10 space-y-8">
          <div className="text-center space-y-2">
            <Link href="/" className="inline-flex items-center gap-2 mb-6">
              <div className="w-10 h-10 bg-[var(--sji-red)] rounded-full flex items-center justify-center text-white font-bold">SJI</div>
              <span className="font-bold text-xl text-[var(--sji-blue)]">Sahabat Jepang</span>
            </Link>
            <h1 className="text-3xl font-black text-slate-900">Selamat Datang</h1>
            <p className="text-slate-500 font-medium">Masuk ke sistem manajemen SJI</p>
          </div>

          <form onSubmit={handleSubmit} className="space-y-6">
            <div className="space-y-4">
              <div className="relative">
                <Mail className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={18} />
                <input
                  required
                  type="email"
                  placeholder="Email Address"
                  className="w-full pl-12 pr-4 py-4 bg-slate-50 border border-transparent focus:border-[var(--sji-blue)] focus:bg-white rounded-2xl outline-none transition-all"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                />
              </div>
              <div className="relative">
                <Lock className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={18} />
                <input
                  required
                  type="password"
                  placeholder="Password"
                  className="w-full pl-12 pr-4 py-4 bg-slate-50 border border-transparent focus:border-[var(--sji-blue)] focus:bg-white rounded-2xl outline-none transition-all"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                />
              </div>
            </div>

            <button
              disabled={loading}
              type="submit"
              className="w-full py-4 bg-[var(--sji-blue)] text-white font-bold rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-blue-700 transition-all flex items-center justify-center gap-2 group disabled:bg-slate-300"
            >
              {loading ? (
                <Loader2 className="animate-spin" size={20} />
              ) : (
                <>Masuk Sekarang <ArrowRight size={18} className="group-hover:translate-x-1 transition-transform" /></>
              )}
            </button>
          </form>

          <div className="text-center pt-4">
            <p className="text-slate-400 text-sm">Lupa password? <a href="#" className="text-[var(--sji-blue)] font-bold">Hubungi IT Support</a></p>
          </div>
        </div>
        
        <div className="bg-slate-900 p-6 text-center">
          <p className="text-slate-500 text-xs font-bold uppercase tracking-widest">Sahabat Jepang Indonesia © 2026</p>
        </div>
      </motion.div>
    </main>
  );
}
