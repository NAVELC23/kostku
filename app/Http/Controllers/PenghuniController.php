<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Kamar;
use App\Models\User;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    // List semua penghuni (admin)
     public function index(Request $request)
    {
        // Ambil kata kunci pencarian (kalau ada)
        $cari = $request->input('cari');

        $penghunis = Penghuni::with(['user', 'kamar'])
            ->when($cari, function ($query) use ($cari) {
                // Cari berdasarkan nama user yang terkait
                $query->whereHas('user', function ($q) use ($cari) {
                    $q->where('name', 'like', '%' . $cari . '%');
                });
            })
            ->get();

        return view('admin.penghuni.index', compact('penghunis', 'cari'));
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
            'lama_sewa'       => 'required|integer|min:1|max:36',
        ], [
            'lama_sewa.required' => 'Lama sewa wajib diisi.',
            'lama_sewa.min'      => 'Lama sewa minimal 1 bulan.',
        ]);

        // Hitung tanggal keluar otomatis: tanggal masuk + lama sewa (bulan)
        $tanggalKeluar = \Carbon\Carbon::parse($request->tanggal_masuk)
                            ->addMonths((int) $request->lama_sewa)
                            ->format('Y-m-d');

        Penghuni::create([
            'id_user'         => $request->id_user,
            'id_kamar'        => $request->id_kamar,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'tanggal_keluar'  => $tanggalKeluar,
            'status_penghuni' => $request->status_penghuni,
        ]);

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
            'lama_sewa'       => 'required|integer|min:1|max:36',
        ], [
            'lama_sewa.required' => 'Lama sewa wajib diisi.',
            'lama_sewa.min'      => 'Lama sewa minimal 1 bulan.',
        ]);

        $tanggalKeluar = \Carbon\Carbon::parse($request->tanggal_masuk)
                            ->addMonths((int) $request->lama_sewa)
                            ->format('Y-m-d');

        $penghuni = Penghuni::findOrFail($id);
        $penghuni->update([
            'id_user'         => $request->id_user,
            'id_kamar'        => $request->id_kamar,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'tanggal_keluar'  => $tanggalKeluar,
            'status_penghuni' => $request->status_penghuni,
        ]);

        return redirect()->route('admin.penghuni.index')
                         ->with('success', 'Penghuni berhasil diupdate!');
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