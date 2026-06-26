<?php
 
namespace App\Http\Controllers;
 
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;
use Illuminate\Support\Facades\DB;
 
class DashboardController extends Controller
{
   public function index()
   {
       // --- Kartu statistik ---
       $totalKamar     = Kamar::count();
       $kamarTersedia  = Kamar::where('status', 'Tersedia')->count();
       $kamarTerisi    = Kamar::where('status', 'Terisi')->count();
       $totalPenghuni  = Penghuni::count();
 
       // Pendapatan = total tagihan yang sudah LUNAS
       $totalPendapatan = Tagihan::where('status_bayar', 'Lunas')
           ->sum('nominal_tagihan');
 
       // --- Data grafik pendapatan per bulan ---
       $pendapatanPerBulan = Tagihan::where('status_bayar', 'Lunas')
           ->select('bulan', DB::raw('SUM(nominal_tagihan) as total'))
           ->groupBy('bulan')
           ->get();
 
       $labelBulan     = $pendapatanPerBulan->pluck('bulan');
       $dataPendapatan = $pendapatanPerBulan->pluck('total');
 
       return view('admin.dashboard', compact(
           'totalKamar',
           'kamarTersedia',
           'kamarTerisi',
           'totalPenghuni',
           'totalPendapatan',
           'labelBulan',
           'dataPendapatan'
       ));
   }
}