@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-700">Laporan Perbaikan Saya</h3>
            <a href="{{ route('penghuni.perbaikan.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                + Lapor Kerusakan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($perbaikans as $perbaikan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($perbaikan->tanggal_lapor)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $perbaikan->judul }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $perbaikan->kategori }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($perbaikan->status == 'Selesai')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                @elseif($perbaikan->status == 'Diproses')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Diproses</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <form action="{{ route('penghuni.perbaikan.destroy', $perbaikan->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Belum ada laporan kerusakan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection