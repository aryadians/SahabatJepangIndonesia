<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Reimbursement;
use App\Models\DigitalArchive;
use Illuminate\Database\Seeder;

class SampleReimbursementSeeder extends Seeder
{
    public function run(): void
    {
        $ceo = Teacher::firstOrCreate(['nip' => 'EXEC-001'], [
            'role' => 'ceo_owner',
            'name' => 'Drs. H. Bambang Suryono, M.M.',
            'position_title' => 'Chief Executive Officer & Founder',
            'department' => 'Dewan Direksi & Manajemen Puncak',
            'gender' => 'Laki-laki',
            'phone' => '081234567890',
            'status' => 'active',
            'is_executive' => true,
            'order' => 1,
            'notes' => 'Memimpin visi ekspansi penempatan tenaga kerja profesional dan magang Indonesia di Jepang.',
        ]);

        $dir = Teacher::firstOrCreate(['nip' => 'EXEC-002'], [
            'role' => 'direktur',
            'name' => 'Takeshi Morimoto, B.Sc.',
            'position_title' => 'Direktur Kemitraan Jepang & Hubungan Industri',
            'department' => 'Kemitraan Internasional & Kaisha Relations',
            'gender' => 'Laki-laki',
            'phone' => '081298765432',
            'status' => 'active',
            'is_executive' => true,
            'order' => 2,
            'notes' => 'Mengoordinasikan verifikasi kaisha, kuota SSW Tokutei Ginou, dan MoU asosiasi penerima di Tokyo dan Osaka.',
        ]);

        $bendahara = Teacher::firstOrCreate(['nip' => 'FIN-001'], [
            'role' => 'bendahara',
            'name' => 'Siti Rahmawati, S.E., Ak.',
            'position_title' => 'Kepala Bagian Keuangan & Bendahara LPK',
            'department' => 'Divisi Keuangan & Pembukuan SPJ',
            'gender' => 'Perempuan',
            'phone' => '081345678901',
            'status' => 'active',
            'is_executive' => false,
            'order' => 3,
            'notes' => 'Penanggung jawab kas masuk, rekonsiliasi SPJ kasbon dinas luar kota, dan pencairan klaim reimburse.',
        ]);

        if (Reimbursement::count() === 0) {
            Reimbursement::create([
                'reimbursement_no' => 'RMB-2026-0001',
                'type' => 'reimbursement',
                'teacher_id' => $dir->id,
                'employee_name' => $dir->name,
                'category' => 'mou_perjalanan_dinas',
                'title' => 'Perjalanan Dinas MoU Poltekkes Kemenkes & RS Swasta Jawa Barat',
                'destination' => 'Bandung',
                'start_date' => '2026-08-20',
                'end_date' => '2026-08-22',
                'amount_requested' => 1850000,
                'amount_approved' => 1850000,
                'amount_spent' => 1850000,
                'amount_diff' => 0,
                'status' => 'paid',
                'notes' => 'Penandatanganan nota kesepahaman (MoU) rekrutmen perawat lansia (Kaigo) & pertemuan koordinasi penempatan SSW di Bandung.',
                'approved_by' => 'Drs. H. Bambang Suryono, M.M.',
                'paid_at' => now()->subDays(2),
            ]);

            Reimbursement::create([
                'reimbursement_no' => 'CSH-2026-0002',
                'type' => 'cash_advance',
                'teacher_id' => $bendahara->id,
                'employee_name' => $bendahara->name,
                'category' => 'transportasi',
                'title' => 'Uang Muka Dinas Verifikasi Lembaga Sertifikasi & BNSP Jakarta',
                'destination' => 'Jakarta Selatan',
                'start_date' => '2026-09-08',
                'end_date' => '2026-09-09',
                'amount_requested' => 2500000,
                'amount_approved' => 2500000,
                'amount_spent' => 0,
                'amount_diff' => -2500000,
                'status' => 'paid',
                'notes' => 'Biaya tiket kereta Whoosh PP, akomodasi hotel 1 malam, transportasi taksi, dan konsumsi operasional pengurusan perpanjangan akreditasi LPK di BNSP Jakarta.',
                'approved_by' => 'Takeshi Morimoto, B.Sc.',
                'paid_at' => now()->subHours(12),
            ]);
        }

        if (DigitalArchive::count() === 0) {
            DigitalArchive::create([
                'archive_no' => 'ARC-2026-0001',
                'title' => 'Salinan Scan MoU Kerjasama Penempatan Perawat Kaigo Jawa Barat',
                'category' => 'dokumen_mou',
                'document_date' => '2026-08-21',
                'uploader_name' => 'Admin Keuangan',
                'file_name' => 'mou_resmi_kaigo_jabar_2026.pdf',
                'file_type' => 'application/pdf',
                'file_size' => '102.4 KB',
                'file_base64' => 'data:application/pdf;base64,JVBERi0xLjQKJcTl8uXrCjEgMCBvYmoKPDwKL1R5cGUgL0NhdGFsb2cKL1BhZ2VzIDIgMCBSCj4+CmVuZG9iagoyIDAgb2JqCjw8Ci9UeXBlIC9QYWdlcwovS2lkcyBbMyAwIFJdCi9Db3VudCAxCj4+CmVuZG9iagozIDAgb2JqCjw8Ci9UeXBlIC9QYWdlCi9QYXJlbnQgMiAwIFIKL01lZGlhQm94IFswIDAgNjEyIDc5Ml0KPj4KZW5kb2JqCnhyZWYKMCA0CjAwMDAwMDAwMDAgNjU1MzUgZiAKMDAwMDAwMDAxOCAwMDAwMCBuIAowMDAwMDAwMDY5IDAwMDAwIG4gCjAwMDAwMDAxMjIgMDAwMDAgbiAKdHJhaWxlcgo8PAovU2l6ZSA0Ci9Sb290IDEgMCBSCj4+CnN0YXJ0eHJlZgoxOTAKJSVFT0YK',
                'notes' => 'Arsip digital resmi kerjasama pendidikan dan pelatihan penempatan tenaga kerja ke Jepang.',
            ]);
        }
    }
}
