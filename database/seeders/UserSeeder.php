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
        User::create([
            'name'     => 'Admin KostKu',
            'email'    => 'admin@kostku.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Penghuni Test',
            'email'    => 'penghuni@kostku.com',
            'password' => bcrypt('password'),
            'role'     => 'penghuni',
        ]);
    }
}
