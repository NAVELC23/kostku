<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // firstOrCreate: kalau user sudah ada (berdasarkan email), tidak dibuat ulang
        User::firstOrCreate(
            ['email' => 'admin@kostku.com'],
            [
                'name'     => 'Admin KostKu',
                'password' => bcrypt('password'),
                'role'     => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'penghuni@kostku.com'],
            [
                'name'     => 'Penghuni Test',
                'password' => bcrypt('password'),
                'role'     => 'penghuni',
            ]
        );
    }
}