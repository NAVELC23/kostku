@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4 max-w-xl">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-700 mb-6">Ubah Status Perbaikan</h3>

        <div class="mb-6 space-y-2 text-sm text-gray-600 border-b pb-4">
            <p><span class="font-semibold">Penghuni:</span> {{ $perbaikan->penghuni->user->name ?? '-' }}</p>
            <p><span class="font-semibold">Judul:</span> {{ $perbaikan->judul }}</p>
            <p><span class="font-semibold">Kategori:</span> {{ $perbaikan->kategori }}</p>
            <p><span class="font-semibold">Deskripsi:</span> {{ $perbaikan->deskripsi }}</p>
        </div>

        <form action="{{ route('admin.perbaikan.update', $perbaikan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Penanganan</label>
                <select name="status" id="status" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring" required>
                    <option value="Menunggu" {{ $perbaikan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ $perbaikan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ $perbaikan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.perbaikan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow text-xs uppercase">Batal</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow text-xs uppercase">Update Status</button>
            </div>
        </form>
    </div>
</div>
@endsection