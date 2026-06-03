<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Kamar;
use App\Models\User;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    // List semua penghuni (admin)
    public function index()
    {
        $penghunis = Penghuni::with(['user', 'kamar'])->get();
        return view('admin.penghuni.index', compact('penghunis'));
    }

    // Form tambah penghuni (admin)
    public function create()
    {
        $kamars = Kamar::where('status', 'Tersedia')->get();
        $users = User::where('role', 'penghuni')->get();
        return view('admin.penghuni.create', compact('kamars', 'users'));
    }

    // Simpan penghuni baru (admin)
    public function store(Request $request)
    {
        $request->validate([
            'id_user'         => 'required|exists:users,id',
            'id_kamar'        => 'nullable|exists:kamars,id_kamar',
            'tanggal_masuk'   => 'required|date',
            'status_penghuni' => 'required|in:aktif,nonaktif',
            'tanggal_keluar'  => 'nullable|date|after:tanggal_masuk',
        ]);

        Penghuni::create($request->all());

        return redirect()->route('admin.penghuni.index')
                         ->with('success', 'Penghuni berhasil ditambahkan!');
    }

    // Form edit penghuni (admin)
    public function edit($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $kamars = Kamar::all();
        $users = User::where('role', 'penghuni')->get();
        return view('admin.penghuni.edit', compact('penghuni', 'kamars', 'users'));
    }

    // Update penghuni (admin)
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user'         => 'required|exists:users,id',
            'id_kamar'        => 'nullable|exists:kamars,id_kamar',
            'tanggal_masuk'   => 'required|date',
            'status_penghuni' => 'required|in:aktif,nonaktif',
            'tanggal_keluar'  => 'nullable|date|after:tanggal_masuk',
        ]);

        $penghuni = Penghuni::findOrFail($id);
        $penghuni->update($request->all());

        return redirect()->route('admin.penghuni.index')
                         ->with('success', 'Data penghuni berhasil diupdate!');
    }

    // Hapus penghuni (admin)
    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $penghuni->delete();

        return redirect()->route('admin.penghuni.index')
                         ->with('success', 'Penghuni berhasil dihapus!');
    }

    // Dashboard penghuni (role:penghuni)
    public function dashboard()
    {
        $penghuni = Penghuni::with(['kamar'])
                    ->where('id_user', auth()->id())
                    ->first();
        return view('penghuni.dashboard', compact('penghuni'));
    }
}