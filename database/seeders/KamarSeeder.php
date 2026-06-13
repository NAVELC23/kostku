<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        // Lantai 1 — Ekonomis (101 sampai 110)
        for ($i = 101; $i <= 110; $i++) {
            Kamar::create([
                'nomor_kamar' => (string) $i,
                'tipe'        => 'Ekonomis',
                'harga'       => 700000,
                'status'      => 'Tersedia',
                'fasilitas'   => 'Kasur Single Bed, Meja, Lemari, Kipas Angin, Kamar Mandi Luar (ukuran kecil)',
            ]);
        }

        // Lantai 2 — Standar (201 sampai 207)
        for ($i = 201; $i <= 207; $i++) {
            Kamar::create([
                'nomor_kamar' => (string) $i,
                'tipe'        => 'Standar',
                'harga'       => 1400000,
                'status'      => 'Tersedia',
                'fasilitas'   => 'Kasur Double Bed, Lemari, Meja, AC, TV, Kamar Mandi Dalam, Balkon (ukuran sedang)',
            ]);
        }

        // Lantai 3 — VIP (301 sampai 305)
        for ($i = 301; $i <= 305; $i++) {
            Kamar::create([
                'nomor_kamar' => (string) $i,
                'tipe'        => 'VIP',
                'harga'       => 2500000,
                'status'      => 'Tersedia',
                'fasilitas'   => 'Kasur King Size, Lemari, Meja, AC, TV, Kamar Mandi Dalam + Water Heater, Balkon, Kulkas (ukuran besar)',
            ]);
        }
    }
}