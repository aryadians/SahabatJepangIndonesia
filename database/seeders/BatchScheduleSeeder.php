<?php

namespace Database\Seeders;

use App\Models\BatchSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BatchScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                'batch_name' => 'Angkatan 42 - Tokutei Ginou SSW Intensif',
                'program_type' => 'Tokutei Ginou (SSW)',
                'start_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'registration_deadline' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'target_departure' => 'Februari - Maret 2027',
                'quota' => 25,
                'remaining_seats' => 4,
                'status' => 'limited',
                'order' => 1,
            ],
            [
                'batch_name' => 'Angkatan 43 - Magang Industri & Manufaktur',
                'program_type' => 'Ginou Jisshusei (Magang)',
                'start_date' => Carbon::now()->addDays(45)->format('Y-m-d'),
                'registration_deadline' => Carbon::now()->addDays(35)->format('Y-m-d'),
                'target_departure' => 'April - Mei 2027',
                'quota' => 30,
                'remaining_seats' => 12,
                'status' => 'open',
                'order' => 2,
            ],
            [
                'batch_name' => 'Angkatan 44 - Tokutei Ginou Kaigo (Caregiver)',
                'program_type' => 'Tokutei Ginou (SSW)',
                'start_date' => Carbon::now()->addDays(60)->format('Y-m-d'),
                'registration_deadline' => Carbon::now()->addDays(50)->format('Y-m-d'),
                'target_departure' => 'Juni - Juli 2027',
                'quota' => 20,
                'remaining_seats' => 8,
                'status' => 'open',
                'order' => 3,
            ],
            [
                'batch_name' => 'Kelas Reguler Bahasa Jepang N4 / JFT A2',
                'program_type' => 'Kursus Bahasa Jepang',
                'start_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'registration_deadline' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'target_departure' => 'Sesuai Target Siswa',
                'quota' => 15,
                'remaining_seats' => 2,
                'status' => 'limited',
                'order' => 4,
            ]
        ];

        foreach ($schedules as $item) {
            BatchSchedule::updateOrCreate(
                ['batch_name' => $item['batch_name']],
                $item
            );
        }
    }
}
