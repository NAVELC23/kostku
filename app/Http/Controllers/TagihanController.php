<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TagihanController extends Controller
{
    // 1. INDEX
    public function index()
    {
        // Mengambil tagihan beserta data user-nya
        $tagihans = Tagihan::with('user')->get();
        return view('admin.tagihan.index', compact('tagihans'));
    }

    // 2. CREATE
    public function create()
    {
        // Ambil user yang role-nya penghuni untuk pilihan di dropdown form
        $users = User::where('role', 'penghuni')->get();
        return view('admin.tagihan.create', compact('users'));
    }

    // 3. STORE
    public function store(Request $request)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id', // Sesuai migration-mu
            'bulan'           => 'required|string',
            'nominal_tagihan' => 'required|numeric|min:0',
            'status'          => 'required|in:Belum Lunas,Lunas', // Sesuai migration-mu
        ]);

        Tagihan::create($request->all());

        return redirect()->route('admin.tagihan.index')
                         ->with('success', 'Tagihan berhasil dibuat!');
    }

    // 4. EDIT
    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $users = User::where('role', 'penghuni')->get();
        return view('admin.tagihan.edit', compact('tagihan', 'users'));
    }

    // 5. UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'bulan'           => 'required|string',
            'nominal_tagihan' => 'required|numeric|min:0',
            'status'          => 'required|in:Belum Lunas,Lunas',
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
        $tagihans = Tagihan::with('user')->get();
        $pdf = Pdf::loadView('admin.tagihan.pdf', compact('tagihans'));
        return $pdf->download('Laporan_Tagihan_Kostku.pdf');
    }

    // 8. FITUR THEO: TAMPILAN TAGIHAN DI SISI PENGHUNI (Hanya Bisa Melihat)
    public function indexPenghuni()
    {
        // Mengambil data tagihan yang HANYA dimiliki oleh penghuni yang sedang login saat ini
        $tagihans = Tagihan::where('user_id', auth()->id())->get();
        
        return view('penghuni.tagihan.index', compact('tagihans'));
    }
}