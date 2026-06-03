<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Manajemen Kamar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-emerald-900 text-white flex flex-col shadow-xl">
            <div class="p-5 text-2xl font-bold tracking-wider border-b border-emerald-800 flex items-center gap-2">
                <span class="text-xl">🏢</span> KosKu [cite: 146]
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-emerald-100 rounded-lg hover:bg-emerald-800 transition">
                    <span>📊</span> Dashboard [cite: 187]
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-emerald-800 text-white font-semibold rounded-lg shadow">
                    <span>🔑</span> Kelola Kamar [cite: 75]
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-emerald-100 rounded-lg hover:bg-emerald-800 transition">
                    <span>👥</span> Kelola Penghuni [cite: 76]
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-emerald-100 rounded-lg hover:bg-emerald-800 transition">
                    <span>💵</span> Tagihan [cite: 77]
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-emerald-100 rounded-lg hover:bg-emerald-800 transition">
                    <span>🛠️</span> Fasilitas [cite: 78]
                </a>
            </nav>
            <div class="p-4 border-t border-emerald-800">
                <a href="#" class="flex items-center gap-3 px-4 py-2 text-rose-300 hover:text-rose-100 rounded-lg hover:bg-rose-950 transition text-sm">
                    <span>🚪</span> Logout [cite: 98]
                </a>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <header class="flex justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Manajemen Data Kamar </h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola informasi, tipe, harga, dan fasilitas kamar kos.</p>
                </div>
                <a href="{{ route('admin.kamar.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md shadow-emerald-100 flex items-center gap-2">
                    <span>+</span> Tambah Kamar Baru [cite: 79]
                </a>
            </header>

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3">
                    <span class="text-emerald-500">✅</span>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-700">Daftar Kamar Terdaftar </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Foto </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">No. Kamar </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Tipe </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Harga </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Fasilitas </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Aksi [cite: 15]</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($kamars as $kamar)
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($kamar->foto)
                                        <img src="{{ asset('storage/' . $kamar->foto) }}" class="w-20 h-14 object-cover rounded-xl border border-gray-100">
                                    @else
                                        <div class="w-20 h-14 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-xs italic border border-dashed border-gray-200">
                                            No Image
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">#{{ $kamar->nomor_kamar }} </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium">{{ $kamar->tipe }}</span> 
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    Rp {{ number_format($kamar->harga, 0, ',', '.') }}/bln
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $kamar->status == 'Tersedia' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $kamar->status }} 
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $kamar->fasilitas ?? '-' }} </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                    <a href="{{ route('admin.kamar.edit', $kamar->id_kamar) }}" class="text-amber-600 hover:text-amber-700 font-semibold transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.kamar.destroy', $kamar->id_kamar) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar nomor {{ $kamar->nomor_kamar }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-400 italic">
                                    Belum ada data kamar. Klik "+ Tambah Kamar Baru" untuk mengisi[cite: 79].
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
