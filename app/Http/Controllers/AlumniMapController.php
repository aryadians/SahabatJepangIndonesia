<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AlumniMapController extends Controller
{
    public function index(Request $request)
    {
        $settings = SiteSetting::allCached();
        $selectedSector = $request->query('sector');
        $selectedRegion = $request->query('region');

        // Data 8 Region & 47 Prefektur di Jepang dengan data sebaran alumni
        $regions = [
            'kanto' => [
                'name' => 'Kantō (関東)',
                'hub' => 'Tokyo, Yokohama, Chiba, Saitama',
                'prefectures' => ['Tokyo', 'Kanagawa', 'Chiba', 'Saitama', 'Ibaraki', 'Tochigi', 'Gunma'],
                'color' => 'bg-red-500',
                'count' => 148,
            ],
            'chubu' => [
                'name' => 'Chūbu / Tōkai (中部)',
                'hub' => 'Aichi (Nagoya), Shizuoka, Gifu',
                'prefectures' => ['Aichi', 'Shizuoka', 'Gifu', 'Mie', 'Niigata', 'Nagano', 'Yamanashi', 'Toyama', 'Ishikawa', 'Fukui'],
                'color' => 'bg-blue-500',
                'count' => 132,
            ],
            'kansai' => [
                'name' => 'Kansai / Kinki (関西)',
                'hub' => 'Osaka, Kyoto, Hyogo (Kobe)',
                'prefectures' => ['Osaka', 'Kyoto', 'Hyogo', 'Nara', 'Shiga', 'Wakayama'],
                'color' => 'bg-amber-500',
                'count' => 96,
            ],
            'kyushu' => [
                'name' => 'Kyūshū & Okinawa (九州)',
                'hub' => 'Fukuoka, Kumamoto, Kagoshima',
                'prefectures' => ['Fukuoka', 'Kumamoto', 'Kagoshima', 'Nagasaki', 'Oita', 'Miyazaki', 'Saga', 'Okinawa'],
                'color' => 'bg-emerald-500',
                'count' => 64,
            ],
            'tohoku' => [
                'name' => 'Tōhoku (東北)',
                'hub' => 'Miyagi (Sendai), Fukushima',
                'prefectures' => ['Miyagi', 'Fukushima', 'Aomori', 'Iwate', 'Akita', 'Yamagata'],
                'color' => 'bg-purple-500',
                'count' => 38,
            ],
            'chugoku' => [
                'name' => 'Chūgoku (中国)',
                'hub' => 'Hiroshima, Okayama',
                'prefectures' => ['Hiroshima', 'Okayama', 'Yamaguchi', 'Shimane', 'Tottori'],
                'color' => 'bg-indigo-500',
                'count' => 45,
            ],
            'shikoku' => [
                'name' => 'Shikoku (四国)',
                'hub' => 'Ehime, Kagawa, Tokushima',
                'prefectures' => ['Ehime', 'Kagawa', 'Tokushima', 'Kochi'],
                'color' => 'bg-teal-500',
                'count' => 28,
            ],
            'hokkaido' => [
                'name' => 'Hokkaidō (北海道)',
                'hub' => 'Sapporo, Asahikawa, Hakodate',
                'prefectures' => ['Hokkaido'],
                'color' => 'bg-cyan-500',
                'count' => 35,
            ],
        ];

        // Query Alumni & Testimoni
        $testimonialsQuery = Testimonial::query();
        if ($selectedSector) {
            $testimonialsQuery->where('program', 'like', "%{$selectedSector}%");
        }
        $testimonials = $testimonialsQuery->orderBy('order')->get();

        $studentsQuery = Student::whereIn('status', ['terbang', 'matching', 'pelatihan']);
        if ($selectedSector) {
            $studentsQuery->where('sector', 'like', "%{$selectedSector}%");
        }
        $departedStudents = $studentsQuery->latest()->take(12)->get();

        $totalAlumniCount = array_sum(array_column($regions, 'count'));

        return view('landing.alumni-map', compact('settings', 'regions', 'testimonials', 'departedStudents', 'totalAlumniCount', 'selectedSector', 'selectedRegion'));
    }
}
