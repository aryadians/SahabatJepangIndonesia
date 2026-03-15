import DashboardAnalytics from "@/components/admin/DashboardAnalytics";

export default function DashboardPage() {
  const stats = [
    { label: 'Total Siswa', value: '2,543', change: '+12%', color: 'blue' },
    { label: 'Siswa Aktif', value: '842', change: '+5%', color: 'green' },
    { label: 'Menunggu Match', value: '156', change: '-2%', color: 'yellow' },
    { label: 'Total Tagihan', value: 'Rp 4.2M', change: '+18%', color: 'red' },
  ];

  return (
    <div className="space-y-8">
      {/* Stats Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats.map((stat) => (
          <div key={stat.label} className="p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <p className="text-slate-500 text-sm font-medium mb-1">{stat.label}</p>
            <div className="flex items-end justify-between">
              <h3 className="text-3xl font-black text-slate-900">{stat.value}</h3>
              <span className={`text-xs font-bold px-2 py-1 rounded-lg ${
                stat.change.startsWith('+') ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600'
              }`}>
                {stat.change}
              </span>
            </div>
          </div>
        ))}
      </div>

      <DashboardAnalytics />

      {/* Main Content Area */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {/* Recent Students */}
        <div className="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
          <div className="flex items-center justify-between mb-8">
            <h4 className="text-xl font-bold text-slate-900">Siswa Terbaru</h4>
            <button className="text-sm font-bold text-[var(--sji-blue)] hover:underline">Lihat Semua</button>
          </div>
          <div className="overflow-x-auto">
            <table className="w-full text-left">
              <thead>
                <tr className="border-b border-slate-50">
                  <th className="pb-4 font-bold text-slate-400 text-xs uppercase tracking-wider">Nama</th>
                  <th className="pb-4 font-bold text-slate-400 text-xs uppercase tracking-wider">Program</th>
                  <th className="pb-4 font-bold text-slate-400 text-xs uppercase tracking-wider">Status</th>
                  <th className="pb-4 font-bold text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-50">
                {[1, 2, 3, 4, 5].map((i) => (
                  <tr key={i} className="group hover:bg-slate-50 transition-colors">
                    <td className="py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                          S
                        </div>
                        <div>
                          <p className="font-bold text-slate-900 text-sm">Ahmad Fauzi</p>
                          <p className="text-xs text-slate-500">Sidoarjo, Jatim</p>
                        </div>
                      </div>
                    </td>
                    <td className="py-4">
                      <span className="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase">Tokutei Ginou</span>
                    </td>
                    <td className="py-4">
                      <div className="flex items-center gap-1.5">
                        <div className="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                        <span className="text-xs font-medium text-slate-600">Pelatihan</span>
                      </div>
                    </td>
                    <td className="py-4">
                      <button className="p-2 hover:bg-white rounded-lg transition-colors text-slate-400 hover:text-[var(--sji-blue)]">
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Quick Actions / Announcements */}
        <div className="space-y-6">
          <div className="bg-gradient-to-br from-[var(--sji-blue)] to-blue-900 rounded-3xl p-8 text-white shadow-xl shadow-blue-900/20">
            <h4 className="text-lg font-bold mb-4">Butuh Bantuan?</h4>
            <p className="text-blue-100 text-sm mb-6 leading-relaxed">System Admin SJI v1.0. Jika anda mengalami kendala, silakan hubungi tim IT Support.</p>
            <button className="w-full py-3 bg-white text-[var(--sji-blue)] font-bold rounded-xl hover:bg-blue-50 transition-colors">
              Chat Support
            </button>
          </div>
          
          <div className="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
            <h4 className="text-lg font-bold text-slate-900 mb-6">Upcoming Events</h4>
            <div className="space-y-4">
              {[
                { date: '18 Mar', event: 'Ujian JFT-Basic A2' },
                { date: '22 Mar', event: 'Wawancara User (Kaigo)' },
                { date: '25 Mar', event: 'Pemberangkatan Batch 14' },
              ].map((item) => (
                <div key={item.event} className="flex gap-4 items-center">
                  <div className="w-12 h-12 rounded-2xl bg-slate-50 flex flex-col items-center justify-center text-[10px] font-bold text-slate-400 uppercase">
                    <span className="text-slate-900 leading-none">{item.date.split(' ')[0]}</span>
                    <span>{item.date.split(' ')[1]}</span>
                  </div>
                  <p className="text-sm font-bold text-slate-700">{item.event}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
