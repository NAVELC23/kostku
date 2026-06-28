<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TagihanExport;
use Maatwebsite\Excel\Facades\Excel;

class TagihanController extends Controller
{
    // 1. INDEX
    public function index()
    {
        // Ambil tagihan beserta data penghuni dan user-nya
        $tagihans = Tagihan::with('penghuni.user')->get();
        return view('admin.tagihan.index', compact('tagihans'));
    }

    // 2. CREATE
    public function create()
    {
        $penghunis = Penghuni::with('user', 'kamar')->get();

        $hargaKamar = $penghunis->mapWithKeys(function ($p) {
            return [$p->id_penghuni => [
                'harga'          => $p->kamar->harga ?? 0,
                'tanggal_masuk'  => $p->tanggal_masuk,
                'tanggal_keluar' => $p->tanggal_keluar, // tambah ini
            ]];
        });

        return view('admin.tagihan.create', compact('penghunis', 'hargaKamar'));
    }
    // 3. STORE
    public function store(Request $request)
    {
        $request->validate([
            'id_penghuni'     => 'required|exists:penghunis,id_penghuni',
            'bulan'           => 'required|date_format:Y-m',
            'nominal_tagihan' => 'required|numeric|min:1',
            'status_bayar'    => 'required|in:Belum Lunas,Lunas',
        ]);

        Tagihan::create($request->all());
        return redirect()->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil dibuat!');
    }

    // 4. EDIT
    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $penghunis = Penghuni::with('user', 'kamar')->get();

        $hargaKamar = $penghunis->mapWithKeys(function ($p) {
            return [$p->id_penghuni => [
                'harga' => $p->kamar->harga ?? 0,
                'tanggal_masuk' => $p->tanggal_masuk,
                'tanggal_keluar' => $p->tanggal_keluar,
            ]];
        });

        return view('admin.tagihan.edit', compact('tagihan', 'penghunis', 'hargaKamar'));
    }

    // 5. UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_penghuni'     => 'required|exists:penghunis,id_penghuni',
            'bulan'           => 'required|date_format:Y-m',
            'nominal_tagihan' => 'required|numeric|min:1',
            'status_bayar'    => 'required|in:Belum Lunas,Lunas',
        ]);

        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update($request->all());
        return redirect()->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil diupdate!');
    }

    // 6. DESTROY
    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();

        return redirect()->route('admin.tagihan.index')
                         ->with('success', 'Tagihan berhasil dihapus!');
    }

    // 7. EKSPOR PDF
    public function exportPdf()
    {
        $tagihans = Tagihan::with('penghuni.user')->get();
        $pdf = Pdf::loadView('admin.tagihan.pdf', compact('tagihans'));
        return $pdf->download('Laporan_Tagihan_Kostku.pdf');
    }

    // 8. TAGIHAN DI SISI PENGHUNI (hanya lihat)
    public function indexPenghuni()
    {
        // Cari data penghuni milik user yang sedang login
        $penghuni = Penghuni::where('id_user', auth()->id())->first();

        // Ambil tagihan milik penghuni itu (kalau belum terdaftar sebagai penghuni, kosong)
        $tagihans = $penghuni
            ? Tagihan::where('id_penghuni', $penghuni->id_penghuni)->get()
            : collect();

        return view('penghuni.tagihan.index', compact('tagihans'));
    }

    // 9. FITUR THEO: API UNTUK MENGAMBIL DATA TAGIHAN BERDASARKAN ID
    public function apiShow($id)
    {
        // Mengambil data tagihan spesifik beserta data user/penghuninya
        $tagihan = Tagihan::with('user')->find($id);

        // Jika data tagihan tidak ditemukan di database
        if (!$tagihan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tagihan tidak ditemukan'
            ], 404);
        }

        // Jika ditemukan, kembalikan data dalam format JSON yang rapi
        return response()->json([
            'status' => 'success',
            'data' => $tagihan
        ], 200);
    }
            // 10. API TAGIHAN UNTUK PENGHUNI YANG SEDANG LOGIN
        public function apiPenghuni()
        {
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.',
                    'data'    => [],
                ], 401);
            }

            $penghuni = Penghuni::where('id_user', auth()->id())->first();

            if (!$penghuni) {
                return response()->json([
                    'success' => false,
                    'data'    => [],
                ]);
            }

            $tagihans = Tagihan::where('id_penghuni', $penghuni->id_penghuni)->get();

            return response()->json([
                'success' => true,
                'data'    => $tagihans,
            ]);
        }

        // 11. EKSPOR DATA TAGIHAN KE EXCEL
        public function exportExcel()
        {
            return Excel::download(new TagihanExport, 'Laporan_Tagihan_Kostku.xlsx');
        }
}