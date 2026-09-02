<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('order')->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.form', ['program' => new Program()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'japanese_title' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:100',
            'badge_color' => 'nullable|string|max:100',
            'salary_yen' => 'nullable|string|max:100',
            'salary_idr' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sectors_raw' => 'nullable|string',
            'requirements_raw' => 'nullable|string',
            'benefits_raw' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $sectors = array_filter(array_map('trim', explode("\n", $request->sectors_raw ?? '')));
        $requirements = array_filter(array_map('trim', explode("\n", $request->requirements_raw ?? '')));
        $benefits = array_filter(array_map('trim', explode("\n", $request->benefits_raw ?? '')));

        Program::create([
            'slug' => Str::slug($validated['title']) . '-' . rand(100, 999),
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'japanese_title' => $validated['japanese_title'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'badge_color' => $validated['badge_color'] ?? 'bg-red-600 text-white',
            'salary_yen' => $validated['salary_yen'] ?? null,
            'salary_idr' => $validated['salary_idr'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'description' => $validated['description'] ?? null,
            'sectors' => array_values($sectors),
            'requirements' => array_values($requirements),
            'benefits' => array_values($benefits),
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Program karir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.programs.form', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'japanese_title' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:100',
            'badge_color' => 'nullable|string|max:100',
            'salary_yen' => 'nullable|string|max:100',
            'salary_idr' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sectors_raw' => 'nullable|string',
            'requirements_raw' => 'nullable|string',
            'benefits_raw' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $sectors = array_filter(array_map('trim', explode("\n", $request->sectors_raw ?? '')));
        $requirements = array_filter(array_map('trim', explode("\n", $request->requirements_raw ?? '')));
        $benefits = array_filter(array_map('trim', explode("\n", $request->benefits_raw ?? '')));

        $program->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'japanese_title' => $validated['japanese_title'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'badge_color' => $validated['badge_color'] ?? 'bg-red-600 text-white',
            'salary_yen' => $validated['salary_yen'] ?? null,
            'salary_idr' => $validated['salary_idr'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'description' => $validated['description'] ?? null,
            'sectors' => array_values($sectors),
            'requirements' => array_values($requirements),
            'benefits' => array_values($benefits),
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Program karir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();
        return back()->with('success', 'Program karir berhasil dihapus.');
    }
}
