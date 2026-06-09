@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4 max-w-xl">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-700 mb-6">Edit Data Tagihan</h3>
        
        <form action="{{ route('admin.tagihan.update', $tagihan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Penghuni Kos</label>
                <select name="user_id" id="user_id" class="w-full rounded-md shadow-sm border-gray-300 bg-gray-100 focus:border-green-500 focus:ring" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $tagihan->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Periode Bulan Tagihan</label>
                <input type="text" name="bulan" id="bulan" value="{{ $tagihan->bulan }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring" required>
            </div>

            <div class="mb-4">
                <label for="nominal_tagihan" class="block text-sm font-medium text-gray-700 mb-1">Nominal Tagihan (Rp)</label>
                <input type="number" name="nominal_tagihan" id="nominal_tagihan" value="{{ $tagihan->nominal_tagihan }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring" required>
            </div>

            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                <select name="status" id="status" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring" required>
                    <option value="Belum Lunas" {{ $tagihan->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="Lunas" {{ $tagihan->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.tagihan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow text-xs uppercase">Batal</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow text-xs uppercase">Update Tagihan</button>
            </div>
        </form>
    </div>
</div>
@endsection