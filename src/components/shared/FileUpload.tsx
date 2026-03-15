'use client';

import { useState, useRef } from 'react';
import { Upload, X, File, CheckCircle2, Loader2 } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';

interface FileUploadProps {
  label: string;
  onUpload: (url: string) => void;
}

export default function FileUpload({ label, onUpload }: FileUploadProps) {
  const [file, setFile] = useState<File | null>(null);
  const [uploading, setLoading] = useState(false);
  const [progress, setProgress] = useState(0);
  const fileInputRef = useRef<HTMLInputElement>(null);

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files[0]) {
      const selectedFile = e.target.files[0];
      setFile(selectedFile);
      simulateUpload();
    }
  };

  const simulateUpload = () => {
    setLoading(true);
    setProgress(0);
    const interval = setInterval(() => {
      setProgress((prev) => {
        if (prev >= 100) {
          clearInterval(interval);
          setLoading(false);
          onUpload("https://fake-sji-storage.com/file.pdf");
          return 100;
        }
        return prev + 10;
      });
    }, 200);
  };

  const removeFile = () => {
    setFile(null);
    setProgress(0);
  };

  return (
    <div className="space-y-4">
      <label className="text-sm font-bold text-slate-700 ml-1">{label}</label>
      
      <div 
        onClick={() => !file && fileInputRef.current?.click()}
        className={`relative group border-2 border-dashed rounded-[2rem] p-8 transition-all cursor-pointer ${
          file ? 'border-green-200 bg-green-50/30' : 'border-slate-200 hover:border-[var(--sji-blue)] hover:bg-blue-50/30'
        }`}
      >
        <input 
          type="file" 
          ref={fileInputRef} 
          onChange={handleFileChange} 
          className="hidden" 
          accept=".pdf,.jpg,.jpeg,.png"
        />

        <AnimatePresence mode="wait">
          {!file ? (
            <motion.div 
              key="empty"
              initial={{ opacity: 0 }} animate={{ opacity: 1 }}
              className="flex flex-col items-center gap-2 text-slate-400"
            >
              <Upload className="group-hover:text-[var(--sji-blue)] transition-colors" size={32} />
              <p className="text-sm font-medium">Klik atau drop file di sini</p>
              <p className="text-[10px] font-bold uppercase tracking-widest">PDF, JPG, PNG (Max 5MB)</p>
            </motion.div>
          ) : (
            <motion.div 
              key="file"
              initial={{ opacity: 0, scale: 0.9 }} animate={{ opacity: 1, scale: 1 }}
              className="flex items-center gap-4"
            >
              <div className={`w-12 h-12 rounded-2xl flex items-center justify-center ${uploading ? 'bg-blue-100 text-[var(--sji-blue)]' : 'bg-green-100 text-green-600'}`}>
                {uploading ? <Loader2 className="animate-spin" size={24} /> : <File size={24} />}
              </div>
              <div className="flex-1 min-w-0">
                <p className="text-sm font-bold text-slate-900 truncate">{file.name}</p>
                <div className="flex items-center gap-2 mt-1">
                  <div className="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <motion.div 
                      className={`h-full ${uploading ? 'bg-[var(--sji-blue)]' : 'bg-green-500'}`}
                      initial={{ width: 0 }}
                      animate={{ width: `${progress}%` }}
                    />
                  </div>
                  <span className="text-[10px] font-black text-slate-400">{progress}%</span>
                </div>
              </div>
              {!uploading && (
                <button 
                  onClick={(e) => { e.stopPropagation(); removeFile(); }}
                  className="p-2 hover:bg-red-50 text-red-400 rounded-xl transition-colors"
                >
                  <X size={18} />
                </button>
              )}
            </motion.div>
          )}
        </AnimatePresence>
      </div>
    </div>
  );
}
