<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;
use App\Models\Fasilitas;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil id fasilitas berdasarkan nama, supaya bisa di-attach ke kamar.
        // Kalau fasilitas belum ada, dibuat (jaga-jaga FasilitasSeeder belum jalan).
        $fasilitasId = fn (string $nama) => Fasilitas::firstOrCreate(['nama_fasilitas' => $nama])->id;

        // Lantai 1 — Ekonomis (101 sampai 110)
        $fasilitasEkonomis = [
            $fasilitasId('Kipas Angin'),
            $fasilitasId('Lemari Pakaian'),
            $fasilitasId('Meja Belajar'),
            $fasilitasId('Kursi'),
            $fasilitasId('Kamar Mandi Luar'),
        ];
        for ($i = 101; $i <= 110; $i++) {
            $kamar = Kamar::firstOrCreate(
                ['nomor_kamar' => (string) $i],
                [
                    'tipe'   => 'Ekonomis',
                    'harga'  => 700000,
                    'status' => 'Tersedia',
                ]
            );
            // sync: lampirkan fasilitas, tidak dobel kalau seeder dijalankan ulang
            $kamar->fasilitas()->sync($fasilitasEkonomis);
        }

        // Lantai 2 — Standar (201 sampai 207)
        $fasilitasStandar = [
            $fasilitasId('AC'),
            $fasilitasId('Kasur Springbed'),
            $fasilitasId('Lemari Pakaian'),
            $fasilitasId('Meja Belajar'),
            $fasilitasId('Kursi'),
            $fasilitasId('Kamar Mandi Dalam'),
            $fasilitasId('WiFi'),
        ];
        for ($i = 201; $i <= 207; $i++) {
            $kamar = Kamar::firstOrCreate(
                ['nomor_kamar' => (string) $i],
                [
                    'tipe'   => 'Standar',
                    'harga'  => 1400000,
                    'status' => 'Tersedia',
                ]
            );
            $kamar->fasilitas()->sync($fasilitasStandar);
        }

        // Lantai 3 — VIP (301 sampai 305)
        $fasilitasVip = [
            $fasilitasId('AC'),
            $fasilitasId('Kasur Springbed'),
            $fasilitasId('Lemari Pakaian'),
            $fasilitasId('Meja Belajar'),
            $fasilitasId('Kursi'),
            $fasilitasId('Kamar Mandi Dalam'),
            $fasilitasId('Water Heater'),
            $fasilitasId('WiFi'),
            $fasilitasId('Jendela Luar'),
        ];
        for ($i = 301; $i <= 305; $i++) {
            $kamar = Kamar::firstOrCreate(
                ['nomor_kamar' => (string) $i],
                [
                    'tipe'   => 'VIP',
                    'harga'  => 2500000,
                    'status' => 'Tersedia',
                ]
            );
            $kamar->fasilitas()->sync($fasilitasVip);
        }
    }
}