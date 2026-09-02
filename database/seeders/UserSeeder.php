<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Administrator
        User::updateOrCreate(
            ['email' => 'admin@sahabatjepangindonesia.com'],
            [
                'name' => 'Administrator LPK SJI',
                'role' => 'admin',
                'phone' => '081234567890',
                'is_active' => true,
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Head Teacher / Sensei
        User::updateOrCreate(
            ['email' => 'sensei@sahabatjepangindonesia.com'],
            [
                'name' => 'Takeshi Yamada Sensei',
                'role' => 'teacher',
                'phone' => '081298765432',
                'is_active' => true,
                'password' => Hash::make('admin123'),
            ]
        );

        // 3. Senior Instructor
        User::updateOrCreate(
            ['email' => 'sensei2@sahabatjepangindonesia.com'],
            [
                'name' => 'Dewi Lestari, S.Pd (N2)',
                'role' => 'teacher',
                'phone' => '081377889900',
                'is_active' => true,
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
