@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto px-6 space-y-8">

        <div>
            <h2 class="font-semibold text-xl text-gray-800">Dashboard Penghuni</h2>
            <p class="text-gray-600 mt-1">Selamat datang, {{ Auth::user()->name }}. Berikut informasi kamar dan akun kamu.</p>
        </div>

        @if($penghuni && $penghuni->kamar)
            {{-- Info Kamar yang disewa --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Nomor Kamar</p>
                    <p class="text-3xl font-bold text-emerald-700 mt-1">{{ $penghuni->kamar->nomor_kamar }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Tipe Kamar</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $penghuni->kamar->tipe }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Harga per Bulan</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">Rp {{ number_format($penghuni->kamar->harga, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Detail Sewa --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Detail Sewa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-500">Status</span>
                        <span class="font-semibold text-gray-800">{{ $penghuni->status_penghuni ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-500">Tanggal Masuk</span>
                        <span class="font-semibold text-gray-800">{{ $penghuni->tanggal_masuk ?? '-' }}</span>
                    </div>
                </div>
            </div>
        @else
            {{-- Kalau penghuni belum punya kamar --}}
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-6">
                <p class="text-amber-800">Kamu belum terdaftar di kamar mana pun. Silakan hubungi admin kos.</p>
            </div>
        @endif

        {{-- Menu cepat --}}
        <div>
            <h3 class="font-semibold text-lg text-gray-800 mb-4">Menu</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('penghuni.tagihan.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition block">
                    <div class="text-amber-600 text-3xl mb-2">🧾</div>
                    <p class="font-semibold">Tagihan Saya</p>
                    <p class="text-sm text-gray-500">Lihat tagihan bulanan dan status pembayaran.</p>
                </a>
                <a href="{{ route('penghuni.perbaikan.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition block">
                    <div class="text-emerald-600 text-3xl mb-2">🔧</div>
                    <p class="font-semibold">Perbaikan</p>
                    <p class="text-sm text-gray-500">Laporkan kerusakan dan pantau prosesnya.</p>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection