<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Tambah Kamar Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-6">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Kamar Baru</h2>
                    <p class="text-sm text-gray-500 mt-1">Masukkan spesifikasi kamar sesuai data kos fisik.</p>
                </div>

                <form action="{{ route('admin.kamar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Nomor Kamar</label>
                        <input type="text" name="nomor_kamar" placeholder="Contoh: 101" class="w-full mt-1 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Tipe Kamar</label>
                        <select name="tipe" class="w-full mt-1 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition" required>
                            <option value="Kamar Standar">Kamar Standar</option>
                            <option value="Kamar Deluxe">Kamar Deluxe</option>
                            <option value="Kamar VIP">Kamar VIP</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Harga per Bulan (Rp)</label>
                        <input type="number" name="harga" placeholder="Contoh: 800000" class="w-full mt-1 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Status Ketersediaan</label>
                        <select name="status" class="w-full mt-1 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Terisi">Terisi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fasilitas Kamar</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 border border-gray-200 rounded-xl bg-gray-50/50">
                            @foreach($fasilitas as $item)
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="fasilitas[]" value="{{ $item->id }}" class="w-4 h-4 text-emerald-600 bg-white border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                                    <span class="ml-2 text-sm text-gray-700">{{ $item->nama_fasilitas }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Kamar</label>
                        <input type="file" name="foto" class="w-full p-1.5 border border-gray-200 rounded-xl file:bg-emerald-50 file:text-emerald-700 file:border-none file:px-4 file:py-2 file:rounded-lg file:text-sm file:font-semibold cursor-pointer transition">
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.kamar.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl transition text-sm font-medium">
                            Batal
                        </a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl transition text-sm font-semibold shadow-md shadow-emerald-100">
                            Simpan Kamar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>