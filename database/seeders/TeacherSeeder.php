<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'nip' => 'SNS-001',
                'name' => 'Budi Santoso, S.Pd., M.Hum.',
                'romaji_name' => 'Budi Sensei (ブディ先生)',
                'phone' => '081234567001',
                'email' => 'budi.sensei@sahabatjepangindonesia.com',
                'gender' => 'Laki-laki',
                'join_date' => '2023-01-15',
                'jlpt_level' => 'JLPT N1 (Certified)',
                'japan_experience' => 'Alumni Tohoku University & 5 Tahun Bekerja di Tokyo Tech',
                'specialization' => 'Tata Bahasa (Bunpou) N4/N3 & Persiapan Wawancara User',
                'employment_type' => 'full_time',
                'status' => 'active',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80',
                'notes' => 'Kepala Kurikulum & Master Trainer Bahasa Jepang LPK SJI.',
            ],
            [
                'nip' => 'SNS-002',
                'name' => 'Nurul Aini, S.Hum.',
                'romaji_name' => 'Aini Sensei (アイニ先生)',
                'phone' => '081234567002',
                'email' => 'aini.sensei@sahabatjepangindonesia.com',
                'gender' => 'Perempuan',
                'join_date' => '2024-03-01',
                'jlpt_level' => 'JLPT N2',
                'japan_experience' => 'Ex-Ginou Jisshusei Kaigo di Osaka (3 Tahun)',
                'specialization' => 'Percakapan (Kaiwa), Istilah Kaigo / Medis & Budaya Kerja Horenso',
                'employment_type' => 'full_time',
                'status' => 'active',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80',
                'notes' => 'Instruktur spesialis program Tokutei Ginou Kaigo.',
            ],
            [
                'nip' => 'SNS-003',
                'name' => 'Kenji Takahashi',
                'romaji_name' => 'Takahashi Sensei (高橋先生)',
                'phone' => '081234567003',
                'email' => 'kenji.takahashi@sahabatjepangindonesia.com',
                'gender' => 'Laki-laki',
                'join_date' => '2024-08-10',
                'jlpt_level' => 'Native Speaker (日本語ネイティブ)',
                'japan_experience' => 'Native Japanese Instructor & Ex-HR Recruiter di Nagoya',
                'specialization' => 'Simulasi Wawancara Kerja (Mensetsu), Aksen & Pengucapan Alami',
                'employment_type' => 'part_time',
                'status' => 'active',
                'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=400&q=80',
                'notes' => 'Native speaker untuk pengasahan mental interview calon peserta.',
            ]
        ];

        foreach ($teachers as $data) {
            Teacher::updateOrCreate(
                ['nip' => $data['nip']],
                $data
            );
        }
    }
}
