'use client';

import { useState, useEffect } from 'react';
import { 
  Search, 
  Plus, 
  Filter, 
  MoreVertical, 
  Download,
  UserPlus,
  Mail,
  Phone,
  ArrowUpDown,
  Loader2,
  Award
} from 'lucide-react';

import { exportToExcel } from '@/lib/ExcelExport';
import { generateCertificatePDF } from '@/lib/CertificateGenerator';

export default function StudentsPage() {
  const [searchTerm, setSearchTerm] = useState('');
  const [students, setStudents] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchStudents();
  }, []);

  const handleExport = () => {
    const exportData = students.map(s => ({
      'ID Siswa': s.studentId,
      'Nama': s.user.name,
      'Email': s.user.email,
      'Program': s.program?.name || '-',
      'Status': s.status,
      'Tanggal Daftar': new Date(s.createdAt).toLocaleDateString()
    }));
    exportToExcel(exportData, 'Data_Siswa_SJI');
  };

  const handleCertificate = (student: any) => {
    generateCertificatePDF({
      studentName: student.user.name,
      studentId: student.studentId,
      programName: student.program?.name || 'Program Pelatihan SJI',
      issueDate: new Date().toLocaleDateString(),
      certNumber: `CERT/SJI/${new Date().getFullYear()}/${student.studentId.split('-')[1]}`
    });
  };

  const fetchStudents = async () => {
    try {
      const res = await fetch('/api/students');
      const data = await res.json();
      if (Array.isArray(data)) {
        setStudents(data);
      }
    } catch (error) {
      console.error("Failed to fetch", error);
    } finally {
      setLoading(false);
    }
  };

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'TRAINING': return 'bg-blue-50 text-blue-600';
      case 'INTERVIEW': return 'bg-purple-50 text-purple-600';
      case 'COE_PROCESS': return 'bg-yellow-50 text-yellow-600';
      case 'DEPARTED': return 'bg-green-50 text-green-600';
      default: return 'bg-slate-50 text-slate-600';
    }
  };

  return (
    <div className="space-y-6">
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h2 className="text-2xl font-bold text-slate-900">Manajemen Siswa</h2>
          <p className="text-slate-500 text-sm">Kelola data ribuan siswa LPK Sahabat Jepang Indonesia</p>
        </div>
        <div className="flex items-center gap-3">
          <button 
            onClick={handleExport}
            className="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm shadow-sm"
          >
            <Download size={18} /> Export
          </button>
          <button className="flex items-center gap-2 px-6 py-2.5 bg-[var(--sji-blue)] text-white font-bold rounded-xl hover:bg-blue-700 transition-all text-sm shadow-lg shadow-blue-900/20">
            <UserPlus size={18} /> Tambah Siswa
          </button>
        </div>
      </div>

      <div className="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col md:flex-row gap-4 items-center">
        <div className="relative flex-1 w-full">
          <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={18} />
          <input 
            type="text" 
            placeholder="Cari nama, ID, atau program..."
            className="w-full pl-11 pr-4 py-3 bg-slate-50 border border-transparent focus:border-[var(--sji-blue)] focus:bg-white rounded-xl outline-none transition-all text-sm"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>
      </div>

      <div className="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        {loading ? (
          <div className="p-20 flex flex-col items-center justify-center gap-4">
            <Loader2 className="animate-spin text-[var(--sji-blue)]" size={40} />
            <p className="text-slate-400 font-bold">Memuat Data Siswa...</p>
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full text-left">
              <thead>
                <tr className="bg-slate-50/50 border-b border-slate-100">
                  <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">ID Siswa</th>
                  <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
                  <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Program</th>
                  <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                  <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-50">
                {students.map((student) => (
                  <tr key={student.id} className="hover:bg-slate-50/50 transition-colors group">
                    <td className="px-8 py-5 text-sm font-bold text-[var(--sji-blue)]">{student.studentId}</td>
                    <td className="px-8 py-5">
                      <div>
                        <p className="text-sm font-bold text-slate-900">{student.user.name}</p>
                        <p className="text-xs text-slate-400">{student.user.email}</p>
                      </div>
                    </td>
                    <td className="px-8 py-5">
                      <p className="text-sm font-medium text-slate-700">{student.program?.name || 'Belum Pilih'}</p>
                    </td>
                    <td className="px-8 py-5">
                      <span className={`px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ${getStatusColor(student.status)}`}>
                        {student.status}
                      </span>
                    </td>
                    <td className="px-8 py-5 text-right">
                      <div className="flex items-center justify-end gap-2">
                        <button 
                          onClick={() => handleCertificate(student)}
                          className="p-2 bg-white border border-slate-100 rounded-lg text-slate-400 hover:text-yellow-600 hover:border-yellow-100 transition-all"
                          title="Generate Certificate"
                        >
                          <Award size={16} />
                        </button>
                        <button className="p-2 bg-white border border-slate-100 rounded-lg text-slate-400 hover:text-[var(--sji-blue)]">
                          <Mail size={16} />
                        </button>
                        <button className="p-2 bg-white border border-slate-100 rounded-lg text-slate-400 hover:text-slate-900">
                          <MoreVertical size={16} />
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
                {students.length === 0 && (
                  <tr>
                    <td colSpan={5} className="p-20 text-center text-slate-400 font-medium">Belum ada data siswa.</td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        )}
      </div>
    </div>
  );
}
