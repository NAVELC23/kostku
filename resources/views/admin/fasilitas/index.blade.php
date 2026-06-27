@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Master Fasilitas</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar fasilitas yang dapat dipilih saat menambahkan atau mengedit kamar kos.</p>
        </div>

        {{-- Alert Sukses --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3">
                <span>✅</span>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Alert Error Validasi --}}
        @if($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center gap-3">
                <span>❌</span>
                <ul class="text-sm font-medium list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- Bagian Kiri: Form Tambah Fasilitas --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-8">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-700">Tambah Fasilitas Baru</h3>
                    </div>
                    <div class="p-5">
                        <form action="{{ route('admin.fasilitas.store') }}" method="POST">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Nama Fasilitas</label>
                                <input type="text" name="nama_fasilitas" placeholder="Contoh: Kulkas Pribadi" class="w-full mt-2 p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-600 outline-none transition" required>
                            </div>
                            <button type="submit" class="mt-5 w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl text-sm font-semibold transition shadow-md shadow-emerald-100">
                                Simpan Fasilitas
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Tabel Daftar Fasilitas --}}
            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-700">Daftar Fasilitas Tersedia</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Nama Fasilitas</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($fasilitas as $index => $item)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ $item->nama_fasilitas }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('admin.fasilitas.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus fasilitas {{ $item->nama_fasilitas }}? Fasilitas ini juga akan otomatis terhapus dari data kamar yang menggunakannya.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-400 italic">
                                        Belum ada data fasilitas. Silakan tambahkan fasilitas baru melalui form di samping.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection