<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Kamar — KostKu</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">

    <!-- NAVBAR -->
    <nav class="bg-emerald-800 px-6 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-emerald-50 text-xl font-bold">KostKu.</a>
        <div class="space-x-2">
            <a href="{{ route('login') }}" class="text-emerald-50 text-sm hover:text-white">Masuk</a>
            <a href="{{ route('register') }}" class="bg-emerald-50 text-emerald-800 text-sm px-4 py-2 rounded-md hover:bg-white font-semibold">Daftar</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold text-emerald-950 mb-2">Daftar Kamar</h1>
        <p class="text-gray-600 mb-8">Pilih kamar yang tersedia, lalu daftar untuk menyewa.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($kamars as $kamar)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    @if ($kamar->foto)
                        <img src="{{ asset('storage/' . $kamar->foto) }}" alt="Kamar {{ $kamar->nomor_kamar }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-emerald-100 flex items-center justify-center text-emerald-400 text-5xl">🛏️</div>
                    @endif

                    <div class="p-5">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-lg">Kamar {{ $kamar->nomor_kamar }}</h3>
                            <span class="text-xs px-2 py-1 rounded
                                {{ $kamar->status === 'Tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $kamar->status }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Tipe: {{ $kamar->tipe }}</p>
                        <p class="text-sm text-gray-500 mb-3">Fasilitas: {{ $kamar->fasilitas ?? '-' }}</p>
                        <p class="text-emerald-700 font-bold text-lg">Rp {{ number_format($kamar->harga, 0, ',', '.') }}<span class="text-sm font-normal text-gray-500">/bulan</span></p>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500 py-12">
                    Belum ada kamar yang tersedia saat ini.
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>