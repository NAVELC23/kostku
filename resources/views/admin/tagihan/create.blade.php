@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4 max-w-xl">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-700 mb-6">Tambah Tagihan Baru</h3>

        <form action="{{ route('admin.tagihan.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="id_penghuni" class="block text-sm font-medium text-gray-700 mb-1">Pilih Penghuni Kos</label>
                <select name="id_penghuni" id="id_penghuni" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" required>
                    <option value="">-- Pilih Penghuni --</option>
                    @foreach($penghunis as $penghuni)
                        <option value="{{ $penghuni->id_penghuni }}">{{ $penghuni->user->name ?? 'Tanpa Nama' }} ({{ $penghuni->user->email ?? '-' }})</option>
                    @endforeach
                </select>
                @error('id_penghuni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Periode Bulan Tagihan</label>
                <input type="text" name="bulan" id="bulan" placeholder="Contoh: Juni 2026" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" required>
                @error('bulan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="nominal_tagihan" class="block text-sm font-medium text-gray-700 mb-1">Nominal Tagihan (Rp)</label>
                <input type="number" name="nominal_tagihan" id="nominal_tagihan" placeholder="Contoh: 1500000" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" required>
                @error('nominal_tagihan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="status_bayar" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran Awal</label>
                <select name="status_bayar" id="status_bayar" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" required>
                    <option value="Belum Lunas">Belum Lunas</option>
                    <option value="Lunas">Lunas</option>
                </select>
                @error('status_bayar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.tagihan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow text-xs uppercase">Batal</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow text-xs uppercase">Simpan Tagihan</button>
            </div>
        </form>
    </div>
</div>
@endsection