<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalKamar = Kamar::count();
        $kamarTersedia = Kamar::where('status', 'Tersedia')->count();
        $totalPenghuni = Penghuni::count();
        $totalTagihan = Tagihan::count();

        // Kamar terisi
        $kamarTerisi = $totalKamar - $kamarTersedia;

        // Total pendapatan
        $totalPendapatan = Tagihan::where('status_bayar', 'Lunas')
            ->sum('nominal_tagihan');

        // Data grafik pendapatan per bulan
        $pendapatanPerBulan = Tagihan::where('status_bayar', 'Lunas')
            ->get()
            ->groupBy('bulan')
            ->map(function ($items) {
                return $items->sum('nominal_tagihan');
            });

        $labelBulan = $pendapatanPerBulan->keys();
        $dataPendapatan = $pendapatanPerBulan->values();

        return view('admin.dashboard', compact(
            'totalKamar',
            'kamarTersedia',
            'kamarTerisi',
            'totalPenghuni',
            'totalTagihan',
            'totalPendapatan',
            'labelBulan',
            'dataPendapatan'
        ));
    }
}