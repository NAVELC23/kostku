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
            // updateOrInsert: tidak akan dobel kalau seeder dijalankan ulang
            DB::table('fasilitas')->updateOrInsert(
                ['nama_fasilitas' => $item],
                ['updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}