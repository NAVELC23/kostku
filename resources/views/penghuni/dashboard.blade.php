@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Saya</h1>

    @if($penghuni)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Info Kamar --}}
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-4 text-green-700">Info Kamar Saya</h2>
            @if($penghuni->kamar)
            <table class="w-full text-sm">
                <tr class="border-b">
                    <td class="py-2 text-gray-500">Nomor Kamar</td>
                    <td class="py-2 font-medium">{{ $penghuni->kamar->nomor_kamar }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500">Tipe</td>
                    <td class="py-2 font-medium">{{ $penghuni->kamar->tipe }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500">Harga</td>
                    <td class="py-2 font-medium">Rp {{ number_format($penghuni->kamar->harga, 0, ',', '.') }}/bln</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500">Fasilitas</td>
                    <td class="py-2 font-medium">{{ $penghuni->kamar->fasilitas ?? '-' }}</td>
                </tr>
            </table>
            @else
                <p class="text-gray-400 text-sm">Belum ada kamar yang ditetapkan.</p>
            @endif
        </div>

        {{-- Info Penghuni --}}
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-4 text-green-700">Info Sewa Saya</h2>
            <table class="w-full text-sm">
                <tr class="border-b">
                    <td class="py-2 text-gray-500">Nama</td>
                    <td class="py-2 font-medium">{{ auth()->user()->name }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500">Tanggal Masuk</td>
                    <td class="py-2 font-medium">{{ $penghuni->tanggal_masuk }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500">Tanggal Keluar</td>
                    <td class="py-2 font-medium">{{ $penghuni->tanggal_keluar ?? 'Belum ditentukan' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-500">Status</td>
                    <td class="py-2">
                        @php
                            $habis = $penghuni->tanggal_keluar && \Carbon\Carbon::parse($penghuni->tanggal_keluar)->isPast();
                        @endphp
                        @if($habis)
                            <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">Masa Sewa Habis</span>
                        @elseif($penghuni->status_penghuni === 'aktif')
                            <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Aktif</span>
                        @else
                            <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">Nonaktif</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

    </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded">
            Data penghuni kamu belum terdaftar. Hubungi admin untuk informasi lebih lanjut.
        </div>
    @endif
</div>
@endsection