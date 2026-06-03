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
                    <th class="px-4 py-3 text-left">Kamar</th>
                    <th class="px-4 py-3 text-left">Tanggal Masuk</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penghunis as $penghuni)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $penghuni->user->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $penghuni->kamar->nomor_kamar ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $penghuni->tanggal_masuk }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs
                            {{ $penghuni->status_penghuni === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($penghuni->status_penghuni) }}
                        </span>
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
                    <td colspan="5" class="px-4 py-4 text-center text-gray-400">Belum ada data penghuni.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection