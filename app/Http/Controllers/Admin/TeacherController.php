<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Traits\UploadsImage;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    use UploadsImage;

    /**
     * Tampilkan Daftar Pengajar / Sensei
     */
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('nip', 'like', "%{$q}%")
                    ->orWhere('romaji_name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('specialization', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('jlpt_level') && $request->jlpt_level !== 'all') {
            $query->where('jlpt_level', $request->jlpt_level);
        }

        $teachers = $query->orderBy('id')->paginate(15)->withQueryString();

        $stats = [
            'total_teachers' => Teacher::count(),
            'active_teachers' => Teacher::where('status', 'active')->count(),
            'n1_teachers' => Teacher::where('jlpt_level', 'like', '%N1%')->count(),
        ];

        return view('admin.teachers.index', compact('teachers', 'stats'));
    }

    /**
     * Form Tambah Pengajar Sensei
     */
    public function create()
    {
        return view('admin.teachers.form', ['teacher' => new Teacher()]);
    }

    /**
     * Simpan Pengajar Sensei Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:50|unique:teachers,nip',
            'name' => 'required|string|max:255',
            'romaji_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'join_date' => 'nullable|date',
            'jlpt_level' => 'required|string|max:100',
            'japan_experience' => 'nullable|string|max:255',
            'specialization' => 'required|string|max:255',
            'employment_type' => 'required|string|max:50',
            'status' => 'required|string|max:30',
            'notes' => 'nullable|string',
            'photo_file' => 'nullable|image|max:5120',
            'photo' => 'nullable|string',
        ]);

        $photo = $this->handleImageUpload($request, 'photo_file', 'photo');

        Teacher::create(array_merge($validated, [
            'photo' => $photo,
        ]));

        return redirect()->route('admin.teachers.index')->with('success', 'Data pengajar / sensei berhasil ditambahkan.');
    }

    /**
     * Form Edit Pengajar Sensei
     */
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('admin.teachers.form', compact('teacher'));
    }

    /**
     * Update Pengajar Sensei
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'nip' => 'required|string|max:50|unique:teachers,nip,' . $teacher->id,
            'name' => 'required|string|max:255',
            'romaji_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'join_date' => 'nullable|date',
            'jlpt_level' => 'required|string|max:100',
            'japan_experience' => 'nullable|string|max:255',
            'specialization' => 'required|string|max:255',
            'employment_type' => 'required|string|max:50',
            'status' => 'required|string|max:30',
            'notes' => 'nullable|string',
            'photo_file' => 'nullable|image|max:5120',
            'photo' => 'nullable|string',
        ]);

        $photo = $this->handleImageUpload($request, 'photo_file', 'photo', $teacher->photo);

        $teacher->update(array_merge($validated, [
            'photo' => $photo,
        ]));

        return redirect()->route('admin.teachers.index')->with('success', 'Data pengajar berhasil diperbarui.');
    }

    /**
     * Hapus Data Pengajar Sensei
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return back()->with('success', 'Data pengajar berhasil dihapus.');
    }
}
