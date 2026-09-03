<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Student;
use Illuminate\Http\Request;

class DocumentVerificationController extends Controller
{
    /**
     * Halaman Publik Verifikasi Keaslian QR Code Dokumen (Kwitansi / Invoice)
     */
    public function verify(Request $request, $code = null)
    {
        $settings = SiteSetting::allCached();
        $queryCode = trim($code ?: $request->query('code', ''));

        $student = null;
        $docType = 'Kwitansi Pembayaran Resmi';
        $docNo = $queryCode;
        $isValid = false;

        if (!empty($queryCode)) {
            // Normalisasi pemisah tanda strip dan slash
            $cleanCode = str_replace(['/', '_'], '-', strtoupper($queryCode));

            // Deteksi tipe dokumen
            if (str_contains($cleanCode, 'INV')) {
                $docType = 'Invoice Tagihan Pelatihan';
            } elseif (str_contains($cleanCode, 'KW')) {
                $docType = 'Kwitansi Pembayaran Resmi';
            } else {
                $docType = 'Dokumen Registrasi Siswa';
            }

            // 1. Cek pencarian via NIS siswa
            $student = Student::where('nis', $queryCode)
                ->orWhere('nis', $cleanCode)
                ->first();

            // 2. Jika tidak cocok NIS, coba ekstrak ID dari format KW-SJI-YYYYMM-0001
            if (!$student && preg_match('/(?:KW|INV)-SJI-?[0-9]{4,6}-?([0-9]+)/i', $cleanCode, $matches)) {
                $studentId = (int)$matches[1];
                $student = Student::find($studentId);
            }

            // 3. Fallback: jika formatnya hanya angka ID siswa
            if (!$student && is_numeric($queryCode)) {
                $student = Student::find((int)$queryCode);
            }

            if ($student) {
                $isValid = true;
                // Generate nomor dokumen kanonikal
                if ($docType === 'Invoice Tagihan Pelatihan') {
                    $docNo = 'INV-SJI/' . date('Ym') . '/' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
                } else {
                    $docNo = 'KW-SJI/' . date('Ym') . '/' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
                }
            }
        }

        return view('landing.verify-document', compact('settings', 'queryCode', 'student', 'docType', 'docNo', 'isValid'));
    }
}
