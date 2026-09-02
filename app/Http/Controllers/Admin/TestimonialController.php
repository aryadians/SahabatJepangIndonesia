<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:150',
            'prefecture' => 'required|string|max:100',
            'program' => 'required|string|max:150',
            'company' => 'required|string|max:200',
            'salary' => 'required|string|max:100',
            'quote' => 'required|string',
            'avatar' => 'nullable|string',
            'tag' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'origin' => $validated['origin'] ?? null,
            'prefecture' => $validated['prefecture'],
            'program' => $validated['program'],
            'company' => $validated['company'],
            'salary' => $validated['salary'],
            'quote' => $validated['quote'],
            'avatar' => $validated['avatar'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
            'tag' => $validated['tag'] ?? 'Alumni',
            'order' => $validated['order'] ?? 0,
        ]);

        return back()->with('success', 'Testimoni alumni berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:150',
            'prefecture' => 'required|string|max:100',
            'program' => 'required|string|max:150',
            'company' => 'required|string|max:200',
            'salary' => 'required|string|max:100',
            'quote' => 'required|string',
            'avatar' => 'nullable|string',
            'tag' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        $testimonial->update($validated);

        return back()->with('success', 'Testimoni alumni berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        return back()->with('success', 'Testimoni alumni berhasil dihapus.');
    }
}
