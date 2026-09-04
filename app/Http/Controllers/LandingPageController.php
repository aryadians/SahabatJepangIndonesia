<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Facility;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    /**
     * Tampilkan Halaman Utama Landing Page dengan Data Dinamis dari Database
     */
    public function index()
    {
        // 1. Ambil Settings (General, Hero, Stats, Contact)
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        // 2. Ambil Programs Aktif
        $programsFromDb = Program::where('is_active', true)->orderBy('order')->get();
        $programs = $programsFromDb->map(function ($p) {
            return [
                'id' => $p->slug,
                'title' => $p->title,
                'subtitle' => $p->subtitle,
                'badge' => $p->badge,
                'badge_color' => $p->badge_color,
                'icon' => $p->icon ?? 'briefcase',
                'japanese_title' => $p->japanese_title,
                'salary_yen' => $p->salary_yen,
                'salary_idr' => $p->salary_idr,
                'duration' => $p->duration,
                'description' => $p->description,
                'sectors' => $p->sectors ?? [],
                'requirements' => $p->requirements ?? [],
                'benefits' => $p->benefits ?? []
            ];
        })->toArray();

        // 3. Ambil Testimonials
        $testimonialsFromDb = Testimonial::orderBy('order')->get();
        $testimonials = $testimonialsFromDb->map(function ($t) {
            return [
                'name' => $t->name,
                'origin' => $t->origin,
                'prefecture' => $t->prefecture,
                'program' => $t->program,
                'company' => $t->company,
                'salary' => $t->salary,
                'quote' => $t->quote,
                'avatar' => $t->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                'tag' => $t->tag ?? 'Alumni'
            ];
        })->toArray();

        // 4. Ambil FAQs
        $faqs = Faq::orderBy('order')->get()->map(function ($f) {
            return [
                'q' => $f->question,
                'a' => $f->answer
            ];
        })->toArray();

        // 5. Ambil Facilities
        $facilities = Facility::orderBy('order')->get()->map(function ($fac) {
            return [
                'title' => $fac->title,
                'category' => $fac->category,
                'description' => $fac->description,
                'desc' => $fac->description,
                'image' => $fac->image
            ];
        })->toArray();

        // 6. Ambil Partners
        $partners = Partner::orderBy('order')->get();

        // 7. Ambil Jadwal Gelombang & Kuota Kelas (Batch Schedules)
        $schedules = \App\Models\BatchSchedule::orderBy('order')->get();

        // 8. Ambil Tenaga Pengajar / Sensei
        $teachers = \App\Models\Teacher::where('status', 'active')->orderBy('id')->get();

        // 9. Ambil Artikel Edukasi & Berita Terbaru
        $articles = \App\Models\Article::where('is_published', true)->latest()->take(3)->get();

        return view('landing.index', compact('settings', 'programs', 'testimonials', 'faqs', 'facilities', 'partners', 'schedules', 'teachers', 'articles'));
    }

    /**
     * Simpan Formulir Konsultasi & Pendaftaran Calon Siswa
     */
    public function storeConsultation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'age' => 'nullable|integer|min:16|max:50',
            'education' => 'nullable|string|max:100',
            'program' => 'required|string|max:150',
            'city' => 'nullable|string|max:150',
            'message' => 'nullable|string|max:1000',
            'affiliate_code' => 'nullable|string|max:50',
        ]);

        try {
            $affCode = $validated['affiliate_code'] ?? $request->query('ref') ?? session('ref_code');

            $consultation = Consultation::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'age' => $validated['age'] ?? null,
                'education' => $validated['education'] ?? null,
                'program' => $validated['program'],
                'city' => $validated['city'] ?? null,
                'message' => $validated['message'] ?? null,
                'affiliate_code' => $affCode,
                'status' => 'pending'
            ]);

            // Ambil WA dari SiteSetting jika ada
            $waAdmin = SiteSetting::get('contact_whatsapp', '6281234567890');
            $cleanWaAdmin = preg_replace('/[^0-9]/', '', $waAdmin);

            // Automasi WhatsApp Log: Catat pengiriman salam sambutan pendaftar baru
            $cleanUserPhone = preg_replace('/[^0-9]/', '', $validated['phone']);
            if (str_starts_with($cleanUserPhone, '0')) {
                $cleanUserPhone = '62' . substr($cleanUserPhone, 1);
            }

            $template = \App\Models\WhatsAppTemplate::where('trigger_key', 'new_lead')->first();
            if ($template && !empty($template->message)) {
                $logMsg = str_replace(
                    ['{nama}', '{program}'],
                    [$validated['name'], $validated['program']],
                    $template->message
                );
            } else {
                $logMsg = "Konnichiwa Kak {$validated['name']}! Terima kasih telah mendaftar konsultasi program {$validated['program']} di LPK Sahabat Jepang Indonesia. Tim konselor kami siap membantu.";
            }

            if (\App\Services\FonnteService::isConfigured()) {
                \App\Services\FonnteService::send($cleanUserPhone, $logMsg, [
                    'recipient_name' => $validated['name'],
                    'template_key' => 'new_lead',
                ]);
            } else {
                \App\Models\WhatsAppLog::create([
                    'recipient_phone' => $cleanUserPhone,
                    'recipient_name' => $validated['name'],
                    'template_key' => 'new_lead',
                    'message_body' => $logMsg,
                    'status' => 'sent',
                ]);
            }

            // Format WhatsApp URL untuk direct follow up
            $waMessage = urlencode("Halo Admin LPK Sahabat Jepang Indonesia, saya sudah mengisi form konsultasi di website.\n\nNama: {$validated['name']}\nUmur: " . ($validated['age'] ?? '-') . " Tahun\nPendidikan: " . ($validated['education'] ?? '-') . "\nProgram Minat: {$validated['program']}\nKota Asal: " . ($validated['city'] ?? '-') . "\n\nSaya ingin berkonsultasi mengenai proses keberangkatan ke Jepang. Terima kasih!");
            $waUrl = "https://api.whatsapp.com/send?phone={$cleanWaAdmin}&text={$waMessage}";

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Terima kasih! Data pendaftaran dan konsultasi Anda berhasil dikirim. Tim konselor kami akan segera menghubungi Anda melalui WhatsApp.',
                    'wa_url' => $waUrl,
                    'data' => $consultation
                ]);
            }

            return redirect()->route('home')->with('success', 'Pendaftaran Anda berhasil dikirim! Tim konselor kami akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            Log::error('Error saving consultation: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem saat menyimpan data. Silakan coba lagi atau hubungi via WhatsApp langsung.'
                ], 500);
            }

            return back()->withInput()->with('error', 'Terjadi kesalahan saat memproses data. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan Halaman Mandiri FAQ & Konsultasi Interaktif Publik
     */
    public function faq(Request $request)
    {
        $settings = SiteSetting::allCached();
        $selectedCategory = $request->query('category', 'all');

        $query = Faq::orderBy('order');
        if ($selectedCategory !== 'all') {
            $query->where('category', $selectedCategory);
        }
        $faqs = $query->get();

        // Kategori statistik & nama label
        $categories = [
            'all' => ['label' => 'Semua Pertanyaan', 'count' => Faq::count()],
            'syarat_fisik' => ['label' => 'Syarat Fisik & Medis', 'count' => Faq::where('category', 'syarat_fisik')->count()],
            'biaya' => ['label' => 'Biaya & Dana Talangan', 'count' => Faq::where('category', 'biaya')->count()],
            'program' => ['label' => 'SMILE Project & Beasiswa', 'count' => Faq::where('category', 'program')->count()],
            'pelatihan' => ['label' => 'Pelatihan & Alur Visa', 'count' => Faq::where('category', 'pelatihan')->count()],
            'umum' => ['label' => 'Legalitas & Umum', 'count' => Faq::where('category', 'umum')->count()],
        ];

        return view('landing.faq', compact('settings', 'faqs', 'selectedCategory', 'categories'));
    }
}
