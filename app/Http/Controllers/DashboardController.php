<?php
namespace App\Http\Controllers;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;
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

        $namaBulanAngka = ['','Jan','Feb','Mar','Apr','Mei','Jun',
                           'Jul','Agu','Sep','Okt','Nov','Des'];

        // Ambil semua tagihan
        $semuaTagihan = Tagihan::all(['bulan', 'nominal_tagihan', 'status_bayar']);

        // Kelompokkan per bulan-tahun — format baru: "2026-06"
        $grouped = [];
        foreach ($semuaTagihan as $t) {
            $parts = explode('-', trim($t->bulan));
            if (count($parts) < 2) continue;

            $tahun    = $parts[0];
            $bulanInt = (int) $parts[1];

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

        // Buat kerangka 6 bulan terakhir agar bulan kosong tetap muncul
        // Kerangka dinamis dari bulan pertama sampai bulan terakhir di database
        $kerangka = [];

        if (!empty($grouped)) {
            $keyPertama  = array_key_first($grouped); // bulan terlama
            $keyTerakhir = array_key_last($grouped);  // bulan terbaru

            $current = Carbon::createFromFormat('Y-m', $keyPertama)->startOfMonth();
            $akhir   = Carbon::createFromFormat('Y-m', $keyTerakhir)->startOfMonth();

            while ($current->lte($akhir)) {
                $bulanInt = (int) $current->format('n');
                $tahun    = $current->format('Y');
                $key      = $tahun . '-' . str_pad($bulanInt, 2, '0', STR_PAD_LEFT);
                $kerangka[$key] = $namaBulanAngka[$bulanInt] . ' ' . $tahun;
                $current->addMonth();
            }
        }

        $bulanLabel   = [];
        $bulanRevenue = [];
        $trendLabels  = [];
        $trendLunas   = [];
        $trendBelum   = [];

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
}