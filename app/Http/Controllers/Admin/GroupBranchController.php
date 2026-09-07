<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\GroupBranch;
use Illuminate\Http\Request;

class GroupBranchController extends Controller
{
    /**
     * Display a listing of group branches and offices.
     */
    public function index(Request $request)
    {
        $country = $request->query('country', 'all');
        $search = $request->query('search');

        $query = GroupBranch::query()->ordered();

        if ($country === 'ID') {
            $query->indonesia();
        } elseif ($country === 'JP') {
            $query->japan();
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('japanese_name', 'like', "%{$search}%")
                  ->orWhere('category_jp', 'like', "%{$search}%")
                  ->orWhere('category_id', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $branches = $query->paginate(20)->withQueryString();
        $totalId = GroupBranch::indonesia()->count();
        $totalJp = GroupBranch::japan()->count();
        $totalActive = GroupBranch::active()->count();

        return view('admin.group_branches.index', compact(
            'branches',
            'country',
            'search',
            'totalId',
            'totalJp',
            'totalActive'
        ));
    }

    /**
     * Store a newly created branch in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'japanese_name' => 'nullable|string|max:255',
            'category_jp' => 'nullable|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:100',
            'secondary_phone' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'country' => 'required|string|in:ID,JP',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? (GroupBranch::max('sort_order') + 1);

        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $mime = $file->getMimeType();
            $base64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
            $validated['logo_url'] = $base64;
        }

        unset($validated['logo_file']);

        $branch = GroupBranch::create($validated);

        // Audit Trail
        AuditLog::record(
            'group_branch_create',
            "Menambahkan entitas/cabang baru: {$branch->name}",
            ['branch_id' => $branch->id, 'name' => $branch->name, 'country' => $branch->country]
        );

        return redirect()->route('admin.group-branches.index')
            ->with('success', "Cabang/entitas {$branch->name} berhasil ditambahkan ke SJI Group.");
    }

    /**
     * Update the specified branch in storage.
     */
    public function update(Request $request, $id)
    {
        $branch = GroupBranch::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'japanese_name' => 'nullable|string|max:255',
            'category_jp' => 'nullable|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:100',
            'secondary_phone' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'country' => 'required|string|in:ID,JP',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $mime = $file->getMimeType();
            $base64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
            $validated['logo_url'] = $base64;
        }

        unset($validated['logo_file']);

        $branch->update($validated);

        // Audit Trail
        AuditLog::record(
            'group_branch_update',
            "Memperbarui data cabang/entitas: {$branch->name}",
            ['branch_id' => $branch->id, 'name' => $branch->name]
        );

        return redirect()->route('admin.group-branches.index')
            ->with('success', "Informasi cabang {$branch->name} berhasil diperbarui.");
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus($id)
    {
        $branch = GroupBranch::findOrFail($id);
        $branch->is_active = !$branch->is_active;
        $branch->save();

        AuditLog::record(
            'group_branch_toggle',
            "Mengubah status cabang {$branch->name} menjadi: " . ($branch->is_active ? 'Aktif' : 'Non-Aktif'),
            ['branch_id' => $branch->id, 'is_active' => $branch->is_active]
        );

        return back()->with('success', "Status cabang {$branch->name} berhasil diubah.");
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroy($id)
    {
        $branch = GroupBranch::findOrFail($id);
        $name = $branch->name;
        $branch->delete();

        AuditLog::record(
            'group_branch_delete',
            "Menghapus cabang/entitas: {$name}",
            ['branch_id' => $id, 'name' => $name]
        );

        return redirect()->route('admin.group-branches.index')
            ->with('success', "Cabang {$name} berhasil dihapus dari sistem.");
    }
}
