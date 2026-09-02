<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Student;
use App\Models\WhatsAppLog;
use App\Models\WhatsAppTemplate;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function index()
    {
        $templates = WhatsAppTemplate::all();
        $logs = WhatsAppLog::latest()->paginate(15);
        $leads = Consultation::latest()->take(20)->get();
        $students = Student::latest()->take(20)->get();

        return view('admin.whatsapp.index', compact('templates', 'logs', 'leads', 'students'));
    }

    public function updateTemplate(Request $request, $id)
    {
        $template = WhatsAppTemplate::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $template->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', "Template pesan \"{$template->title}\" berhasil diperbarui.");
    }

    public function sendDirect(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'name' => 'nullable|string',
            'template_key' => 'nullable|string',
            'message' => 'required|string',
        ]);

        // Clean WhatsApp Phone Format (e.g. 0812 -> 62812)
        $cleanPhone = preg_replace('/[^0-9]/', '', $validated['phone']);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        // Save dispatch log
        WhatsAppLog::create([
            'recipient_phone' => $cleanPhone,
            'recipient_name' => $validated['name'] ?? null,
            'template_key' => $validated['template_key'] ?? 'custom',
            'message_body' => $validated['message'],
            'status' => 'sent',
        ]);

        $waUrl = 'https://api.whatsapp.com/send?phone=' . $cleanPhone . '&text=' . urlencode($validated['message']);

        return redirect()->away($waUrl);
    }
}
