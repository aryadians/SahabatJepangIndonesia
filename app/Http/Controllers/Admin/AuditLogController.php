<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    /**
     * Tampilkan Riwayat Audit Log & Aktivitas Sistem LPK
     */
    public function index(Request $request)
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403, 'Akses terbatas hanya untuk Administrator Utama.');
        }

        $query = AuditLog::with('user')->latest();

        // Filter Kategori Aksi
        if ($request->filled('action_category')) {
            $cat = $request->action_category;
            $query->where('action', 'like', "{$cat}%");
        }

        // Filter Pengguna
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter Pencarian Teks
        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
            });
        }

        // Filter Rentang Tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20)->withQueryString();

        $stats = [
            'total' => AuditLog::count(),
            'logins_today' => AuditLog::where('action', 'auth.login')->whereDate('created_at', today())->count(),
            'failed_attempts' => AuditLog::where('action', 'auth.failed')->count(),
            'rbac_events' => AuditLog::where('action', 'like', 'user.%')->count(),
        ];

        $users = User::select('id', 'name', 'role')->orderBy('name')->get();

        return view('admin.audit_logs.index', compact('logs', 'stats', 'users'));
    }

    /**
     * Bersihkan riwayat log yang lebih lama dari 30 hari
     */
    public function clear(Request $request)
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403);
        }

        $deletedCount = AuditLog::where('created_at', '<', now()->subDays(30))->delete();

        AuditLog::record(
            'system.audit_cleared',
            "Administrator membersihkan arsip log audit lama ({$deletedCount} rekaman dihapus)."
        );

        return back()->with('success', "Sebanyak {$deletedCount} catatan audit log yang lebih lama dari 30 hari berhasil dibersihkan.");
    }
}
