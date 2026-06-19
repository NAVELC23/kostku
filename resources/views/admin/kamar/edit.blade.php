<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Data Kamar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-emerald-900 text-white flex flex-col shadow-xl">
            <div class="p-5 text-2xl font-bold tracking-wider border-b border-emerald-800 flex items-center gap-2">
                <span>🏢</span> KosKu
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-emerald-100 rounded-lg hover:bg-emerald-800 transition">
                    <span>📊</span> Dashboard
                </a>
                <a href="{{ route('admin.kamar.index') }}" class="flex items-center gap-3 px-4 py-3 bg-emerald-800 text-white font-semibold rounded-lg shadow">
                    <span>🔑</span> Kelola Kamar
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-emerald-100 rounded-lg hover:bg-emerald-800 transition">
                    <span>👥</span> Kelola Penghuni
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-emerald-100 rounded-lg hover:bg-emerald-800 transition">
                    <span>💵</span> Tagihan
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-emerald-100 rounded-lg hover:bg-emerald-800 transition">
                    <span>🛠️</span> Fasilitas
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-8 flex items-center justify-center">
            <div class="w-full max-w-2xl bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Data Kamar #{{ $kamar->nomor_kamar }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui informasi spesifikasi atau ubah status ketersediaan kamar.</p>
                </div>

                <form action="{{ route('admin.kamar.update', $kamar->id_kamar) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Nomor Kamar</label>
                        <input type="text" name="nomor_kamar" value="{{ $kamar->nomor_kamar }}" class="w-full mt-1 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Tipe Kamar</label>
                        <select name="tipe" class="w-full mt-1 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition" required>
                            <option value="Kamar Standar" {{ $kamar->tipe == 'Kamar Standar' ? 'selected' : '' }}>Kamar Standar</option>
                            <option value="Kamar Deluxe" {{ $kamar->tipe == 'Kamar Deluxe' ? 'selected' : '' }}>Kamar Deluxe</option>
                            <option value="Kamar VIP" {{ $kamar->tipe == 'Kamar VIP' ? 'selected' : '' }}>Kamar VIP</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Harga per Bulan (Rp)</label>
                        <input type="number" name="harga" value="{{ $kamar->harga }}" class="w-full mt-1 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Status Ketersediaan</label>
                        <select name="status" class="w-full mt-1 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition" required>
                            <option value="Tersedia" {{ $kamar->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Terisi" {{ $kamar->status == 'Terisi' ? 'selected' : '' }}>Terisi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Fasilitas Kamar</label>
                        <input type="text" name="fasilitas" value="{{ $kamar->fasilitas }}" placeholder="WiFi, AC, Kamar Mandi Dalam" class="w-full mt-1 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kamar Saat Ini</label>
                        @if($kamar->foto)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $kamar->foto) }}" class="w-32 h-24 object-cover rounded-xl border border-gray-200">
                            </div>
                        @endif
                        <label class="block text-xs text-gray-500 mb-1">Ganti Foto Baru (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="file" name="foto" class="w-full p-1.5 border border-gray-200 rounded-xl file:bg-emerald-50 file:text-emerald-700 file:border-none file:px-4 file:py-2 file:rounded-lg file:text-sm file:font-semibold cursor-pointer transition">
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.kamar.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl transition text-sm font-medium">
                            Batal
                        </a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl transition text-sm font-semibold shadow-md shadow-emerald-100">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
