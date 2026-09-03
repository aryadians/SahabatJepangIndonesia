<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    /**
     * Halaman Publik Cek Status Mandiri Siswa
     */
    public function index(Request $request)
    {
        $settings = SiteSetting::allCached();
        $keyword = trim($request->query('keyword', ''));
        $student = null;
        $searched = false;

        if (!empty($keyword)) {
            $searched = true;
            $cleanPhone = preg_replace('/[^0-9]/', '', $keyword);
            
            $student = Student::where('nis', $keyword)
                ->orWhere('nik', $keyword)
                ->when(strlen($cleanPhone) >= 8, function ($q) use ($cleanPhone) {
                    $q->orWhere('phone', 'like', "%{$cleanPhone}%")
                      ->orWhere('emergency_contact_phone', 'like', "%{$cleanPhone}%");
                })
                ->first();
        }

        // Hitung progres tahapan
        $progressSteps = [];
        if ($student) {
            $statusMap = [
                'registered' => 1,
                'training' => 2,
                'interview' => 3,
                'passed_user' => 4,
                'processing_docs' => 5,
                'ready_to_depart' => 6,
                'departed' => 7,
                'completed' => 7,
            ];

            $currentStepIndex = $statusMap[$student->status] ?? 1;

            $progressSteps = [
                [
                    'step' => 1,
                    'title' => 'Pendaftaran & Seleksi',
                    'desc' => 'Pemberkasan dan tes minat awal',
                    'is_done' => $currentStepIndex >= 1,
                    'is_current' => $currentStepIndex === 1,
                ],
                [
                    'step' => 2,
                    'title' => 'Pelatihan Bahasa & Budaya',
                    'desc' => ($student->japanese_level ?: 'Persiapan N5/N4') . ' - Kehadiran ' . ($student->attendance_percentage ?: '100') . '%',
                    'is_done' => $currentStepIndex >= 2,
                    'is_current' => $currentStepIndex === 2,
                ],
                [
                    'step' => 3,
                    'title' => 'Medical Check-Up (MCU)',
                    'desc' => $student->mcu_result ? 'Hasil: ' . strtoupper($student->mcu_result) : 'Tahap pemeriksaan medis',
                    'is_done' => $currentStepIndex >= 3 || $student->mcu_result === 'fit',
                    'is_current' => $currentStepIndex === 3,
                ],
                [
                    'step' => 4,
                    'title' => 'Matching Kaisha (User)',
                    'desc' => $student->destination_company ? 'Kaisha: ' . $student->destination_company : 'Seleksi wawancara kerja',
                    'is_done' => $currentStepIndex >= 4,
                    'is_current' => $currentStepIndex === 4,
                ],
                [
                    'step' => 5,
                    'title' => 'CoE & Visa Jepang',
                    'desc' => $student->coe_number ? 'CoE: ' . $student->coe_number : 'Pengajuan imigrasi Jepang',
                    'is_done' => $currentStepIndex >= 5,
                    'is_current' => $currentStepIndex === 5,
                ],
                [
                    'step' => 6,
                    'title' => 'Keberangkatan / Terbang',
                    'desc' => $student->departure_date ? 'Jadwal: ' . $student->departure_date->format('d M Y') : 'Persiapan tiket & asrama',
                    'is_done' => $currentStepIndex >= 6,
                    'is_current' => $currentStepIndex >= 6,
                ],
            ];
        }

        return view('landing.student-status', compact('settings', 'keyword', 'student', 'searched', 'progressSteps'));
    }

    /**
     * Unduh / Cetak Kwitansi Pembayaran Resmi Siswa secara Publik
     */
    public function publicReceipt($nis)
    {
        $student = Student::where('nis', $nis)->firstOrFail();
        $settings = SiteSetting::allCached();
        $receiptNo = 'KW-SJI/' . date('Ym') . '/' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
        $terbilang = trim($this->terbilang((int)$student->paid_amount)) . ' Rupiah';

        return view('admin.students.receipt', compact('student', 'settings', 'receiptNo', 'terbilang'));
    }

    /**
     * Unduh / Cetak Invoice Tagihan Biaya Siswa secara Publik
     */
    public function publicInvoice($nis)
    {
        $student = Student::where('nis', $nis)->firstOrFail();
        $settings = SiteSetting::allCached();
        $invoiceNo = 'INV-SJI/' . date('Ym') . '/' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
        $terbilangRemaining = trim($this->terbilang((int)$student->remaining_balance)) . ' Rupiah';

        return view('admin.students.invoice', compact('student', 'settings', 'invoiceNo', 'terbilangRemaining'));
    }

    /**
     * Konversi Angka ke Kata Terbilang Rupiah
     */
    private function terbilang($number)
    {
        $number = abs((int)$number);
        $bilang = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        
        if ($number < 12) {
            return $bilang[$number];
        } elseif ($number < 20) {
            return $this->terbilang($number - 10) . ' Belas';
        } elseif ($number < 100) {
            return $this->terbilang((int)($number / 10)) . ' Puluh ' . $this->terbilang($number % 10);
        } elseif ($number < 200) {
            return 'Seratus ' . $this->terbilang($number - 100);
        } elseif ($number < 1000) {
            return $this->terbilang((int)($number / 100)) . ' Ratus ' . $this->terbilang($number % 100);
        } elseif ($number < 2000) {
            return 'Seribu ' . $this->terbilang($number - 1000);
        } elseif ($number < 1000000) {
            return $this->terbilang((int)($number / 1000)) . ' Ribu ' . $this->terbilang($number % 1000);
        } elseif ($number < 1000000000) {
            return $this->terbilang((int)($number / 1000000)) . ' Juta ' . $this->terbilang($number % 1000000);
        }
        return (string)$number;
    }
}
