@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Tambah Penghuni</h1>
        <a href="{{ route('admin.penghuni.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded shadow p-6 max-w-xl">
        <form action="{{ route('admin.penghuni.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">User</label>
                <select name="id_user" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('id_user') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Kamar</label>
                <select name="id_kamar" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Kamar --</option>
                    @foreach($kamars as $kamar)
                        <option value="{{ $kamar->id_kamar }}" {{ old('id_kamar') == $kamar->id_kamar ? 'selected' : '' }}>
                            {{ $kamar->nomor_kamar }} - {{ $kamar->tipe }} (Rp {{ number_format($kamar->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                @error('id_kamar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                       class="w-full border rounded px-3 py-2">
                @error('tanggal_masuk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Status Penghuni</label>
                <select name="status_penghuni" class="w-full border rounded px-3 py-2">
                    <option value="aktif" {{ old('status_penghuni') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status_penghuni') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status_penghuni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Tanggal Keluar (opsional)</label>
                <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar') }}"
                       class="w-full border rounded px-3 py-2">
                @error('tanggal_keluar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                Simpan
            </button>
        </form>
    </div>
</div>
@endsection