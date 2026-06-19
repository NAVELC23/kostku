<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KostKu — Sistem Manajemen Kos</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-white">

    <!-- NAVBAR -->
    <nav class="bg-emerald-800 px-6 py-4 flex justify-between items-center">
        <span class="text-emerald-50 text-xl font-bold">KostKu.</span>
        <div class="space-x-2">
            <a href="{{ route('login') }}" class="text-emerald-50 text-sm hover:text-white">Masuk</a>
            <a href="{{ route('register') }}" class="bg-emerald-50 text-emerald-800 text-sm px-4 py-2 rounded-md hover:bg-white font-semibold">Daftar</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="bg-emerald-50 px-6 py-20 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-emerald-950 mb-4">Cari & kelola kos dengan mudah</h1>
        <p class="text-emerald-800 text-lg mb-8 max-w-xl mx-auto">Semua kebutuhan kos dalam satu aplikasi: info kamar, tagihan, dan laporan perbaikan.</p>
        <div class="space-x-3">
            <a href="{{ route('login') }}" class="bg-emerald-800 text-emerald-50 px-6 py-3 rounded-md hover:bg-emerald-900 font-semibold inline-block">Masuk</a>
            <a href="{{ route('register') }}" class="border border-emerald-800 text-emerald-800 px-6 py-3 rounded-md hover:bg-emerald-100 font-semibold inline-block">Daftar</a>
        </div>
    </section>

    <!-- FITUR -->
    <section class="px-6 py-16 max-w-5xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

            <!-- Info Kamar (bisa diklik, ke halaman kamar publik) -->
            <a href="{{ route('kamar.publik') }}" class="block hover:opacity-80 transition">
                <div class="text-emerald-600 text-5xl mb-3">🛏️</div>
                <h3 class="font-semibold text-lg mb-1">Info Kamar</h3>
                <p class="text-gray-600 text-sm">Lihat detail kamar, fasilitas, dan harga sewa dengan jelas.</p>
            </a>

            <div>
                <div class="text-emerald-600 text-5xl mb-3">🧾</div>
                <h3 class="font-semibold text-lg mb-1">Tagihan</h3>
                <p class="text-gray-600 text-sm">Pantau tagihan bulanan dan status pembayaran kapan saja.</p>
            </div>

            <div>
                <div class="text-emerald-600 text-5xl mb-3">🔧</div>
                <h3 class="font-semibold text-lg mb-1">Perbaikan</h3>
                <p class="text-gray-600 text-sm">Laporkan kerusakan kamar dan pantau proses perbaikannya.</p>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-emerald-800 px-6 py-8 text-center">
        <p class="text-emerald-200 text-sm">© 2026 KostKu</p>
         <p class="text-emerald-200 text-sm">Sistem Manajemen Kos</p>
    </footer>

</body>
</html>