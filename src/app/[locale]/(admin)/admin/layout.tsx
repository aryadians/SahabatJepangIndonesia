import AdminSidebar from "@/components/layout/AdminSidebar";

export default function AdminLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <div className="min-h-screen bg-slate-50 flex">
      <AdminSidebar />
      <div className="flex-1 transition-all duration-300 ml-64 p-8">
        <header className="mb-10 flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold text-slate-900">SJI Management System</h1>
            <p className="text-slate-500 text-sm">Dashboard Administrator LPK Sahabat Jepang Indonesia</p>
          </div>
          <div className="flex items-center gap-4">
            <div className="text-right hidden sm:block">
              <p className="text-sm font-bold text-slate-900">Administrator</p>
              <p className="text-xs text-slate-500">Super Admin</p>
            </div>
            <div className="w-12 h-12 rounded-2xl bg-[var(--sji-blue)] flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-900/20">
              A
            </div>
          </div>
        </header>
        <main>{children}</main>
      </div>
    </div>
  );
}
