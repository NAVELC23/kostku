<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKamar     = Kamar::count();
        $kamarTersedia  = Kamar::where('status', 'Tersedia')->count();
        $totalPenghuni  = Penghuni::count();
        $totalTagihan   = Tagihan::count();

        return view('admin.dashboard', compact(
            'totalKamar',
            'kamarTersedia',
            'totalPenghuni',
            'totalTagihan'
        ));
    }
}