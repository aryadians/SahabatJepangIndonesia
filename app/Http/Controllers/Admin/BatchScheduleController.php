<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchSchedule;
use Illuminate\Http\Request;

class BatchScheduleController extends Controller
{
    public function index()
    {
        $schedules = BatchSchedule::orderBy('order')->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_name' => 'required|string|max:255',
            'program_type' => 'required|string|max:100',
            'start_date' => 'required|date',
            'registration_deadline' => 'required|date',
            'target_departure' => 'nullable|string|max:100',
            'quota' => 'required|integer|min:1',
            'remaining_seats' => 'required|integer|min:0',
            'status' => 'required|in:open,limited,closed',
            'order' => 'nullable|integer',
        ]);

        BatchSchedule::create($validated);

        return back()->with('success', 'Jadwal angkatan kelas baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $schedule = BatchSchedule::findOrFail($id);

        $validated = $request->validate([
            'batch_name' => 'required|string|max:255',
            'program_type' => 'required|string|max:100',
            'start_date' => 'required|date',
            'registration_deadline' => 'required|date',
            'target_departure' => 'nullable|string|max:100',
            'quota' => 'required|integer|min:1',
            'remaining_seats' => 'required|integer|min:0',
            'status' => 'required|in:open,limited,closed',
            'order' => 'nullable|integer',
        ]);

        $schedule->update($validated);

        return back()->with('success', 'Jadwal angkatan kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $schedule = BatchSchedule::findOrFail($id);
        $schedule->delete();

        return back()->with('success', 'Jadwal angkatan kelas berhasil dihapus.');
    }
}
