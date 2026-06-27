<?php
<<<<<<< HEAD
 
=======
>>>>>>> 65f3b272f3070848d8aac8ee6f725a25e66ead72
namespace App\Http\Controllers;
 
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;
<<<<<<< HEAD
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
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKamar    = Kamar::count();
        $kamarTersedia = Kamar::where('status', 'Tersedia')->count();
        $kamarTerisi   = Kamar::where('status', 'Terisi')->count();
        $totalPenghuni = Penghuni::count();
        $totalTagihan  = Tagihan::count();

        // Chart 1: Donut — Status Kamar
        $kamarStatusData = [
            'labels' => ['Tersedia', 'Terisi'],
            'data'   => [$kamarTersedia, $kamarTerisi],
        ];

        // Map nama bulan Indonesia -> angka
        $namaBulanMap = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3,
            'April'   => 4, 'Mei'      => 5, 'Juni'  => 6,
            'Juli'    => 7, 'Agustus'  => 8, 'September' => 9,
            'Oktober' => 10, 'November' => 11, 'Desember' => 12,
        ];

        $namaBulanAngka = ['','Jan','Feb','Mar','Apr','Mei','Jun',
                               'Jul','Agu','Sep','Okt','Nov','Des'];

        // Ambil semua tagihan, lalu parse kolom `bulan`
        $semuaTagihan = Tagihan::all(['bulan', 'nominal_tagihan', 'status_bayar']);

        // Kelompokkan per bulan-tahun dari kolom `bulan`
        $grouped = [];
        foreach ($semuaTagihan as $t) {
            // Format: "Juni 2026" -> pisah jadi ["Juni", "2026"]
            $parts = explode(' ', trim($t->bulan));
            if (count($parts) < 2) continue;

            $namaBln  = $parts[0];
            $tahun    = $parts[1];
            $bulanInt = $namaBulanMap[$namaBln] ?? null;
            if (!$bulanInt) continue;

            $key = $tahun . '-' . str_pad($bulanInt, 2, '0', STR_PAD_LEFT);
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'label'       => $namaBulanAngka[$bulanInt] . ' ' . $tahun,
                    'revenue'     => 0,
                    'lunas'       => 0,
                    'belum_lunas' => 0,
                ];
            }

            if ($t->status_bayar === 'Lunas') {
                $grouped[$key]['revenue'] += $t->nominal_tagihan;
                $grouped[$key]['lunas']   += 1;
            } else {
                $grouped[$key]['belum_lunas'] += 1;
            }
        }

        // Urutkan berdasarkan key (YYYY-MM)
        ksort($grouped);

        // Ambil 6 bulan terakhir saja
        $grouped = array_slice($grouped, -6, 6, true);

        // Susun label + data
        $bulanLabel   = [];
        $bulanRevenue = [];
        $trendLabels  = [];
        $trendLunas   = [];
        $trendBelum   = [];

        // Buat daftar 6 bulan terakhir sebagai kerangka (agar bulan kosong tetap muncul)
        $kerangka = [];
        for ($i = 5; $i >= 0; $i--) {
            $date       = now()->subMonths($i);
            $bulanInt   = (int) $date->format('n');
            $tahun      = $date->format('Y');
            $key        = $tahun . '-' . str_pad($bulanInt, 2, '0', STR_PAD_LEFT);
            $kerangka[$key] = $namaBulanAngka[$bulanInt] . ' ' . $tahun;
        }

        foreach ($kerangka as $key => $label) {
            $trendLabels[]  = $label;
            $bulanLabel[]   = $label;
            $bulanRevenue[] = $grouped[$key]['revenue']     ?? 0;
            $trendLunas[]   = $grouped[$key]['lunas']       ?? 0;
            $trendBelum[]   = $grouped[$key]['belum_lunas'] ?? 0;
        }

        $revenueData = [
            'labels' => $bulanLabel,
            'data'   => $bulanRevenue,
        ];

        $trendData = [
            'labels'      => $trendLabels,
            'lunas'       => $trendLunas,
            'belum_lunas' => $trendBelum,
        ];

        return view('admin.dashboard', compact(
            'totalKamar', 'kamarTersedia', 'totalPenghuni', 'totalTagihan',
            'kamarStatusData', 'revenueData', 'trendData'
        ));
    }
>>>>>>> 65f3b272f3070848d8aac8ee6f725a25e66ead72
}