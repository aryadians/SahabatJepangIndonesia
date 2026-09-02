<?php

namespace Database\Seeders;

use App\Models\Consultation;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            [
                'name' => 'Bima Satria Wicaksono',
                'phone' => '081298765432',
                'age' => 21,
                'education' => 'SMA / SMK Sederajat',
                'program' => 'Tokutei Ginou (SSW) - Pengolahan Makanan',
                'city' => 'Surabaya, Jawa Timur',
                'message' => 'Saya ingin tahu jadwal pembukaan kelas bahasa Jepang batch berikutnya dan opsi asrama.',
                'status' => 'pending',
                'created_at' => now()->subHours(2),
            ],
            [
                'name' => 'Dewi Anggraini',
                'phone' => '085712345678',
                'age' => 24,
                'education' => 'Diploma (D1 - D3)',
                'program' => 'Tokutei Ginou (SSW) - Kaigo (Caregiver)',
                'city' => 'Bandung, Jawa Barat',
                'message' => 'Lulusan D3 Keperawatan, ingin konsultasi persiapan JFT-Basic dan skill test Kaigo.',
                'status' => 'contacted',
                'created_at' => now()->subHours(6),
            ],
            [
                'name' => 'Fajar Pratama',
                'phone' => '082187654321',
                'age' => 20,
                'education' => 'SMA / SMK Sederajat',
                'program' => 'Ginou Jisshusei (Magang Kerja)',
                'city' => 'Semarang, Jawa Tengah',
                'message' => 'Tertarik magang otomotif di Aichi atau Tokyo.',
                'status' => 'registered',
                'created_at' => now()->subDay(),
            ],
            [
                'name' => 'Hendro Kusumo',
                'phone' => '081377889900',
                'age' => 26,
                'education' => 'Sarjana (S1 / D4)',
                'program' => 'Engineer & Professional Career',
                'city' => 'Yogyakarta',
                'message' => 'Lulusan Teknik Mesin S1, sudah punya sertifikat JLPT N3.',
                'status' => 'contacted',
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Rina Kartika',
                'phone' => '087811223344',
                'age' => 19,
                'education' => 'SMA / SMK Sederajat',
                'program' => 'Kursus Intensif Bahasa & Budaya',
                'city' => 'Malang, Jawa Timur',
                'message' => 'Mau belajar bahasa Jepang dari nol untuk persiapan karir tahun depan.',
                'status' => 'pending',
                'created_at' => now()->subDays(3),
            ]
        ];

        foreach ($samples as $sample) {
            Consultation::create($sample);
        }
    }
}
