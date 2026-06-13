<?php

namespace App\Http\Controllers;

use App\Models\Perbaikan;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    // ===== SISI ADMIN =====

    // Daftar semua laporan perbaikan
    public function index()
    {
        $perbaikans = Perbaikan::with('penghuni.user')->latest()->get();
        return view('admin.perbaikan.index', compact('perbaikans'));
    }

    // Form ubah status (admin)
    public function edit($id)
    {
        $perbaikan = Perbaikan::findOrFail($id);
        return view('admin.perbaikan.edit', compact('perbaikan'));
    }

    // Simpan perubahan status (admin)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        $perbaikan = Perbaikan::findOrFail($id);
        $perbaikan->update(['status' => $request->status]);

        return redirect()->route('admin.perbaikan.index')
                         ->with('success', 'Status perbaikan berhasil diupdate!');
    }

    // Hapus laporan (admin)
    public function destroy($id)
    {
        $perbaikan = Perbaikan::findOrFail($id);
        $perbaikan->delete();

        return redirect()->route('admin.perbaikan.index')
                         ->with('success', 'Laporan perbaikan berhasil dihapus!');
    }

    // ===== SISI PENGHUNI =====

    // Daftar laporan milik penghuni yang login
    public function indexPenghuni()
    {
        $penghuni = Penghuni::where('id_user', auth()->id())->first();

        $perbaikans = $penghuni
            ? Perbaikan::where('id_penghuni', $penghuni->id_penghuni)->latest()->get()
            : collect();

        return view('penghuni.perbaikan.index', compact('perbaikans'));
    }

    // Form lapor kerusakan (penghuni)
    public function create()
    {
        return view('penghuni.perbaikan.create');
    }

    // Simpan laporan baru (penghuni)
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $penghuni = Penghuni::where('id_user', auth()->id())->first();

        if (!$penghuni) {
            return back()->with('error', 'Data penghuni kamu belum terdaftar. Hubungi admin.');
        }

        Perbaikan::create([
            'id_penghuni'   => $penghuni->id_penghuni,
            'judul'         => $request->judul,
            'kategori'      => $request->kategori,
            'deskripsi'     => $request->deskripsi,
            'status'        => 'Menunggu',
            'tanggal_lapor' => now(),
        ]);

        return redirect()->route('penghuni.perbaikan.index')
                         ->with('success', 'Laporan kerusakan berhasil dikirim!');
    }
}