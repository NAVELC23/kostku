@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Penghuni</h1>
        <a href="{{ route('admin.penghuni.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Tambah Penghuni
        </a>
    </div>

    <!-- Kotak Pencarian -->
    <form method="GET" action="{{ route('admin.penghuni.index') }}" class="mb-6 flex gap-2">
        <input type="text" name="cari" value="{{ $cari ?? '' }}"
               placeholder="Cari nama penghuni..."
               class="border border-gray-300 rounded px-4 py-2 w-full max-w-xs focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Cari
        </button>
        @if(!empty($cari))
            <a href="{{ route('admin.penghuni.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                Reset
            </a>
        @endif
    </form>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded shadow text-sm">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">No. Telepon</th>
                    <th class="px-4 py-3 text-left">Kamar</th>
                    <th class="px-4 py-3 text-left">Tanggal Masuk</th>
                    <th class="px-4 py-3 text-left">Tanggal Keluar</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penghunis as $penghuni)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $penghuni->user->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $penghuni->user->no_telp ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $penghuni->kamar->nomor_kamar ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $penghuni->tanggal_masuk }}</td>
                    <td class="px-4 py-3">{{ $penghuni->tanggal_keluar ?? '-' }}</td>
                    <td class="px-4 py-3">
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
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('admin.penghuni.edit', $penghuni->id_penghuni) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded text-xs hover:bg-yellow-500">
                            Edit
                        </a>
                        <form action="{{ route('admin.penghuni.destroy', $penghuni->id_penghuni) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus penghuni ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-gray-400">Belum ada data penghuni.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection