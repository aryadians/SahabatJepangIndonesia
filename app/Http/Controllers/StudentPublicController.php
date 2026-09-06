<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use App\Models\SiteSetting;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentPublicController extends Controller
{
    /**
     * Tampilkan Kwitansi Pembayaran Digital Publik Resmi
     * Dapat diakses langsung oleh Siswa / Wali melalui tautan WhatsApp
     */
    public function publicReceipt($nis)
    {
        $student = Student::where('nis', $nis)
            ->orWhere('id', $nis)
            ->firstOrFail();

        $settings = SiteSetting::allCached();
        $receiptNo = 'KW-SJI/' . date('Ym') . '/' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
        $terbilang = trim($this->terbilang((int)$student->paid_amount)) . ' Rupiah';

        // Cari riwayat cicilan kas masuk yang terafiliasi dengan NIS siswa
        $recentTransactions = CashTransaction::where('type', 'income')
            ->where(function ($q) use ($student) {
                $q->where(function ($sq) use ($student) {
                    $sq->where('reference_type', 'student')
                       ->where('reference_id', $student->id);
                })
                ->orWhere('title', 'like', "%{$student->nis}%")
                ->orWhere('title', 'like', "%{$student->name}%")
                ->orWhere('notes', 'like', "%{$student->nis}%");
            })
            ->orderBy('transaction_date', 'desc')
            ->limit(10)
            ->get();

        $verificationUrl = url('/kwitansi/' . $student->nis);

        return view('public.students.public_receipt', compact(
            'student',
            'settings',
            'receiptNo',
            'terbilang',
            'recentTransactions',
            'verificationUrl'
        ));
    }

    /**
     * Portal Publik Cek Kesiapan Keberangkatan & Tracking Dokumen Mandiri
     */
    public function publicTracking(Request $request, $nis = null)
    {
        $settings = SiteSetting::allCached();
        $queryNis = $nis ?: $request->input('nis');

        $student = null;
        $searchPerformed = false;
        $searchResults = collect();

        if (!empty($queryNis)) {
            $searchPerformed = true;
            // Cari presisi berdasarkan NIS atau ID
            $student = Student::where('nis', $queryNis)
                ->orWhere('id', $queryNis)
                ->first();

            // Jika tidak ditemukan dengan NIS, coba cari dengan nama jika pencarian umum
            if (!$student && strlen($queryNis) >= 3) {
                $searchResults = Student::where('name', 'like', "%{$queryNis}%")
                    ->limit(5)
                    ->get();
                if ($searchResults->count() === 1) {
                    $student = $searchResults->first();
                }
            }
        }

        $docs = [];
        $completedPercent = 0;
        $stages = [];

        if ($student) {
            $docs = [
                'ktp' => [
                    'label' => 'KTP Elektronik Siswa',
                    'status' => !empty($student->document_ktp),
                    'desc' => 'Identitas kependudukan WNI sah.',
                ],
                'kk' => [
                    'label' => 'Kartu Keluarga (KK)',
                    'status' => !empty($student->document_kk),
                    'desc' => 'Dokumen verifikasi keluarga & ahli waris.',
                ],
                'ijazah' => [
                    'label' => 'Ijazah Terakhir',
                    'status' => !empty($student->document_ijazah),
                    'desc' => 'Bukti pendidikan formal (SMA/SMK/Diploma/S1).',
                ],
                'passport' => [
                    'label' => 'Paspor RI (Min. 12 Bulan)',
                    'status' => !empty($student->document_passport),
                    'number' => $student->passport_number,
                    'expiry' => $student->passport_expiry,
                    'desc' => 'Dokumen perjalanan internasional resmi Ditjen Imigrasi.',
                ],
                'certificate' => [
                    'label' => 'Sertifikat Bahasa Jepang (JLPT/JFT)',
                    'status' => !empty($student->document_certificate),
                    'level' => $student->japanese_level,
                    'desc' => 'Bukti kecakapan bahasa (standar N5 / N4 / JFT A2).',
                ],
                'ssw' => [
                    'label' => 'Sertifikat Keahlian (SSW / Magang)',
                    'status' => !empty($student->document_ssw),
                    'desc' => 'Sertifikasi kompetensi kerja di bidang spesifik.',
                ],
                'mcu' => [
                    'label' => 'Hasil Medical Check Up (Fit to Fly)',
                    'status' => !empty($student->document_mcu) && $student->mcu_result === 'fit',
                    'result' => $student->mcu_result,
                    'clinic' => $student->mcu_clinic,
                    'date' => $student->mcu_date,
                    'desc' => 'Pemeriksaan kesehatan standar klinik rujukan OTIT/Kedubes.',
                ],
                'coe_visa' => [
                    'label' => 'CoE & Visa Kerja Resmi Jepang',
                    'status' => !empty($student->document_coe_visa),
                    'coe' => $student->coe_number,
                    'visa' => $student->visa_number,
                    'desc' => 'Izin kelayakan tinggal imigrasi dan visa kerja Kedutaan Jepang.',
                ],
            ];

            $completedCount = count(array_filter(array_column($docs, 'status')));
            $completedPercent = round(($completedCount / count($docs)) * 100);

            // Tahapan Perjalanan Siswa Menuju Jepang
            $stages = [
                [
                    'title' => 'Pendaftaran & Seleksi Berkas',
                    'status' => 'completed',
                    'desc' => 'Verifikasi KTP, KK, Ijazah, dan administrasi lembaga selesai.',
                ],
                [
                    'title' => 'Pelatihan Bahasa & Budaya (N5/N4)',
                    'status' => in_array($student->status, ['active', 'interview', 'passed_interview', 'matched', 'visa_processing', 'ready_to_depart', 'departed']) ? 'completed' : 'current',
                    'desc' => 'Pendidikan intensif bahasa, etos kerja (Shingitai), dan persiapan wawancara.',
                ],
                [
                    'title' => 'Wawancara & Matching Kaisha',
                    'status' => in_array($student->status, ['passed_interview', 'matched', 'visa_processing', 'ready_to_depart', 'departed']) ? 'completed' : (in_array($student->status, ['interview']) ? 'current' : 'pending'),
                    'desc' => $student->destination_company ? "Lolos seleksi di {$student->destination_company}." : 'Proses pencocokan dan wawancara dengan perusahaan Jepang.',
                ],
                [
                    'title' => 'Penerbitan CoE (Imigrasi Jepang)',
                    'status' => !empty($student->coe_number) ? 'completed' : (in_array($student->status, ['passed_interview', 'matched', 'visa_processing']) ? 'current' : 'pending'),
                    'desc' => $student->coe_number ? "CoE No: {$student->coe_number} telah terbit." : 'Pengajuan berkas ke Imigrasi Jepang oleh pihak Kumiai / Kaisha.',
                ],
                [
                    'title' => 'Penerbitan Visa Kerja & E-KTKLN',
                    'status' => !empty($student->visa_number) ? 'completed' : (!empty($student->coe_number) ? 'current' : 'pending'),
                    'desc' => $student->visa_number ? "Visa No: {$student->visa_number} disetujui." : 'Pengajuan visa kerja di Kedutaan Besar / Konsulat Jenderal Jepang.',
                ],
                [
                    'title' => 'Keberangkatan Menuju Jepang',
                    'status' => $student->status === 'departed' ? 'completed' : ($student->status === 'ready_to_depart' ? 'ready' : 'pending'),
                    'desc' => $student->departure_date ? "Estimasi jadwal terbang: " . Carbon::parse($student->departure_date)->format('d F Y') : 'Menunggu penetapan tanggal tiket penerbangan internasional.',
                ],
            ];
        }

        return view('public.students.public_tracking', compact(
            'student',
            'queryNis',
            'searchPerformed',
            'searchResults',
            'settings',
            'docs',
            'completedPercent',
            'stages'
        ));
    }

    /**
     * Konversi Angka Menjadi Teks Terbilang Bahasa Indonesia
     */
    private function terbilang($angka): string
    {
        $angka = abs((float)$angka);
        $baca = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];

        if ($angka < 12) {
            return ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            return $this->terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            return $this->terbilang(floor($angka / 10)) . ' Puluh' . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            return ' Seratus' . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return $this->terbilang(floor($angka / 100)) . ' Ratus' . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return ' Seribu' . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return $this->terbilang(floor($angka / 1000)) . ' Ribu' . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return $this->terbilang(floor($angka / 1000000)) . ' Juta' . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            return $this->terbilang(floor($angka / 1000000000)) . ' Miliar' . $this->terbilang(fmod($angka, 1000000000));
        }

        return '';
    }
}
