'use client';

import { Link, usePathname } from '@/i18n/routing';
import { 
  LayoutDashboard, 
  Users, 
  GraduationCap, 
  FileText, 
  CreditCard, 
  Settings,
  LogOut,
  ChevronLeft,
  ChevronRight
} from 'lucide-react';
import { useState } from 'react';

export default function AdminSidebar() {
  const pathname = usePathname();
  const [isCollapsed, setIsCollapsed] = useState(false);

  const menuItems = [
    { name: 'Dashboard', path: '/admin/dashboard', icon: <LayoutDashboard size={20} /> },
    { name: 'Data Siswa', path: '/admin/students', icon: <Users size={20} /> },
    { name: 'Data Pengajar', path: '/admin/teachers', icon: <GraduationCap size={20} /> },
    { name: 'Program & Kelas', path: '/admin/programs', icon: <FileText size={20} /> },
    { name: 'Tagihan Biaya', path: '/admin/billing', icon: <CreditCard size={20} /> },
    { name: 'Berita & Info', path: '/admin/news', icon: <FileText size={20} /> },
  ];

  return (
    <aside 
      className={`bg-slate-900 text-white h-screen fixed left-0 top-0 transition-all duration-300 z-50 flex flex-col ${
        isCollapsed ? 'w-20' : 'w-64'
      }`}
    >
      {/* Brand */}
      <div className="h-20 border-b border-slate-800 flex items-center justify-between px-6">
        {!isCollapsed && (
          <span className="font-bold text-lg tracking-tight">SJI <span className="text-[var(--sji-red)]">Admin</span></span>
        )}
        <button 
          onClick={() => setIsCollapsed(!isCollapsed)}
          className="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 transition-colors"
        >
          {isCollapsed ? <ChevronRight size={16} /> : <ChevronLeft size={16} />}
        </button>
      </div>

      {/* Menu */}
      <nav className="flex-1 py-6 px-3 space-y-2 overflow-y-auto">
        {menuItems.map((item) => (
          <Link
            key={item.path}
            href={item.path as any}
            className={`flex items-center gap-4 px-4 py-3 rounded-xl transition-all ${
              pathname === item.path 
                ? 'bg-[var(--sji-blue)] text-white shadow-lg shadow-blue-900/20' 
                : 'text-slate-400 hover:bg-slate-800 hover:text-white'
            }`}
          >
            <div className="shrink-0">{item.icon}</div>
            {!isCollapsed && <span className="font-medium">{item.name}</span>}
          </Link>
        ))}
      </nav>

      {/* Bottom Actions */}
      <div className="p-3 border-t border-slate-800 space-y-2">
        <Link
          href="/admin/settings"
          className="flex items-center gap-4 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-all"
        >
          <Settings size={20} />
          {!isCollapsed && <span className="font-medium">Settings</span>}
        </Link>
        <button
          className="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-red-400 hover:bg-red-950/30 transition-all"
        >
          <LogOut size={20} />
          {!isCollapsed && <span className="font-medium">Logout</span>}
        </button>
      </div>
    </aside>
  );
}
