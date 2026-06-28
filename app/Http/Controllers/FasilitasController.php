<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    // Menampilkan daftar fasilitas dan form tambah
    public function index()
    {
        $fasilitas = Fasilitas::latest()->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    // Menyimpan fasilitas baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255|unique:fasilitas,nama_fasilitas',
        ], [
            'nama_fasilitas.unique' => 'Fasilitas ini sudah ada di dalam daftar.',
            'nama_fasilitas.required' => 'Nama fasilitas tidak boleh kosong.'
        ]);

        Fasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas
        ]);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $request->validate([
            'nama_fasilitas' => 'required|string|max:255|unique:fasilitas,nama_fasilitas,' . $fasilitas->id,
        ], [
            'nama_fasilitas.unique' => 'Fasilitas ini sudah ada di dalam daftar.',
            'nama_fasilitas.required' => 'Nama fasilitas tidak boleh kosong.'
        ]);

        $fasilitas->update([
            'nama_fasilitas' => $request->nama_fasilitas
        ]);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus!');
    }
}