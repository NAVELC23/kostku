<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitas = [
            'AC',
            'Kipas Angin',
            'WiFi',
            'Kamar Mandi Dalam',
            'Kamar Mandi Luar',
            'Kasur Springbed',
            'Lemari Pakaian',
            'Meja Belajar',
            'Kursi',
            'Jendela Luar',
            'Water Heater'
        ];

        foreach ($fasilitas as $item) {
            DB::table('fasilitas')->insert([
                'nama_fasilitas' => $item,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}