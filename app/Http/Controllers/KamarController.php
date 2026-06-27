<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Fasilitas; // JANGAN LUPA TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::all();
        return view('admin.kamar.index', compact('kamars'));
    }

    public function create()
    {
        // Ambil semua data fasilitas untuk ditampilkan di form
        $fasilitas = Fasilitas::all();
        return view('admin.kamar.create', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|string',
            'tipe'        => 'required|string',
            'harga'       => 'required|numeric',
            'status'      => 'required|string',
            'fasilitas'   => 'nullable|array', // Ubah validasi menjadi array
            'fasilitas.*' => 'exists:fasilitas,id', // Pastikan id fasilitas valid
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil semua input KECUALI fasilitas (karena fasilitas masuk ke tabel pivot)
        $data = $request->except('fasilitas');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_kamar', 'public');
        }

        // Simpan data kamar ke tabel kamars
        $kamar = Kamar::create($data);

        // Jika ada fasilitas yang dicentang, simpan ke tabel fasilitas_kamar
        if ($request->has('fasilitas')) {
            $kamar->fasilitas()->sync($request->fasilitas);
        }

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        $fasilitas = Fasilitas::all(); // Ambil semua pilihan fasilitas
        return view('admin.kamar.edit', compact('kamar', 'fasilitas'));
    }

    // Fungsi publik biarkan saja untuk saat ini
    public function publik()
    {
        $kamars = \App\Models\Kamar::all();
        return view('kamar-publik', compact('kamars'));
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);

        $request->validate([
            'nomor_kamar' => 'required|string',
            'tipe'        => 'required|string',
            'harga'       => 'required|numeric',
            'status'      => 'required|string',
            'fasilitas'   => 'nullable|array', // Ubah menjadi array
            'fasilitas.*' => 'exists:fasilitas,id', // Validasi id fasilitas
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil semua data KECUALI fasilitas
        $data = $request->except('fasilitas');

        if ($request->hasFile('foto')) {
            if ($kamar->foto) {
                Storage::disk('public')->delete($kamar->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto_kamar', 'public');
        }

        $kamar->update($data);

        // Sync (sinkronisasi) data fasilitas ke tabel pivot
        if ($request->has('fasilitas')) {
            $kamar->fasilitas()->sync($request->fasilitas);
        } else {
            // Jika semua centang dihilangkan, hapus relasinya
            $kamar->fasilitas()->sync([]);
        }

        return redirect()->route('admin.kamar.index')->with('success', 'Data kamar berhasil diperbarui!');
    }
}
