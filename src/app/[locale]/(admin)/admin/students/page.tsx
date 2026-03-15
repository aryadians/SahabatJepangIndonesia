'use client';

import { useState } from 'react';
import { 
  Search, 
  Plus, 
  Filter, 
  MoreVertical, 
  Download,
  UserPlus,
  Mail,
  Phone,
  ArrowUpDown
} from 'lucide-react';

export default function StudentsPage() {
  const [searchTerm, setSearchTerm] = useState('');

  const students = [
    { id: 'SJI-001', name: 'Ahmad Fauzi', program: 'Tokutei Ginou', category: 'Kaigo', status: 'Pelatihan', batch: '14', date: '2024-03-01' },
    { id: 'SJI-002', name: 'Siti Aminah', program: 'Magang', category: 'Food Processing', status: 'Match', batch: '12', date: '2024-02-15' },
    { id: 'SJI-003', name: 'Budi Santoso', program: 'Tokutei Ginou', category: 'Construction', status: 'Process COE', batch: '14', date: '2024-03-05' },
    { id: 'SJI-004', name: 'Dewi Lestari', program: 'Kursus', category: 'N4 Class', status: 'Pelatihan', batch: '15', date: '2024-03-10' },
    { id: 'SJI-005', name: 'Rizky Pratama', program: 'Magang', category: 'Agriculture', status: 'Departed', batch: '10', date: '2023-12-20' },
  ];

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'Pelatihan': return 'bg-blue-50 text-blue-600';
      case 'Match': return 'bg-purple-50 text-purple-600';
      case 'Process COE': return 'bg-yellow-50 text-yellow-600';
      case 'Departed': return 'bg-green-50 text-green-600';
      default: return 'bg-slate-50 text-slate-600';
    }
  };

  return (
    <div className="space-y-6">
      {/* Page Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h2 className="text-2xl font-bold text-slate-900">Manajemen Siswa</h2>
          <p className="text-slate-500 text-sm">Kelola data ribuan siswa LPK Sahabat Jepang Indonesia</p>
        </div>
        <div className="flex items-center gap-3">
          <button className="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm shadow-sm">
            <Download size={18} /> Export
          </button>
          <button className="flex items-center gap-2 px-6 py-2.5 bg-[var(--sji-blue)] text-white font-bold rounded-xl hover:bg-blue-700 transition-all text-sm shadow-lg shadow-blue-900/20">
            <UserPlus size={18} /> Tambah Siswa
          </button>
        </div>
      </div>

      {/* Filters & Search */}
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
        <div className="flex items-center gap-2 w-full md:w-auto">
          <select className="px-4 py-3 bg-slate-50 border border-transparent rounded-xl text-sm font-medium outline-none focus:bg-white focus:border-[var(--sji-blue)] transition-all flex-1 md:flex-none">
            <option>Semua Program</option>
            <option>Tokutei Ginou</option>
            <option>Magang</option>
            <option>Kursus</option>
          </select>
          <button className="p-3 bg-slate-50 border border-transparent rounded-xl text-slate-500 hover:bg-slate-100 transition-all">
            <Filter size={18} />
          </button>
        </div>
      </div>

      {/* Table Section */}
      <div className="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left">
            <thead>
              <tr className="bg-slate-50/50 border-b border-slate-100">
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">
                  <div className="flex items-center gap-2 cursor-pointer hover:text-slate-600 transition-colors">
                    ID Siswa <ArrowUpDown size={12} />
                  </div>
                </th>
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Program / Bidang</th>
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Angkatan</th>
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                <th className="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {students.map((student) => (
                <tr key={student.id} className="hover:bg-slate-50/50 transition-colors group">
                  <td className="px-8 py-5 text-sm font-bold text-[var(--sji-blue)]">{student.id}</td>
                  <td className="px-8 py-5">
                    <div>
                      <p className="text-sm font-bold text-slate-900">{student.name}</p>
                      <p className="text-xs text-slate-400">Terdaftar: {student.date}</p>
                    </div>
                  </td>
                  <td className="px-8 py-5">
                    <div>
                      <p className="text-sm font-medium text-slate-700">{student.program}</p>
                      <p className="text-xs text-slate-400">{student.category}</p>
                    </div>
                  </td>
                  <td className="px-8 py-5">
                    <span className="text-sm font-medium text-slate-600">Batch {student.batch}</span>
                  </td>
                  <td className="px-8 py-5">
                    <span className={`px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ${getStatusColor(student.status)}`}>
                      {student.status}
                    </span>
                  </td>
                  <td className="px-8 py-5 text-right">
                    <div className="flex items-center justify-end gap-2">
                      <button className="p-2 bg-white border border-slate-100 rounded-lg text-slate-400 hover:text-[var(--sji-blue)] hover:border-blue-100 transition-all">
                        <Mail size={16} />
                      </button>
                      <button className="p-2 bg-white border border-slate-100 rounded-lg text-slate-400 hover:text-green-600 hover:border-green-100 transition-all">
                        <Phone size={16} />
                      </button>
                      <button className="p-2 bg-white border border-slate-100 rounded-lg text-slate-400 hover:text-slate-900 hover:border-slate-200 transition-all">
                        <MoreVertical size={16} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {/* Pagination */}
        <div className="px-8 py-6 border-t border-slate-100 flex items-center justify-between">
          <p className="text-sm text-slate-500">Menampilkan 5 dari 2,543 siswa</p>
          <div className="flex items-center gap-2">
            <button className="px-4 py-2 text-sm font-bold text-slate-400 bg-slate-50 rounded-xl cursor-not-allowed">Previous</button>
            <div className="flex items-center gap-1">
              <button className="w-10 h-10 text-sm font-bold bg-[var(--sji-blue)] text-white rounded-xl shadow-lg shadow-blue-900/20">1</button>
              <button className="w-10 h-10 text-sm font-bold text-slate-600 hover:bg-slate-50 rounded-xl transition-all">2</button>
              <button className="w-10 h-10 text-sm font-bold text-slate-600 hover:bg-slate-50 rounded-xl transition-all">3</button>
            </div>
            <button className="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">Next</button>
          </div>
        </div>
      </div>
    </div>
  );
}
