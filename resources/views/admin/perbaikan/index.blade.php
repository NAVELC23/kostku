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
            <h3 class="text-lg font-bold text-gray-700">Daftar Laporan Perbaikan</h3>

            <!-- Filter Status -->
            <form method="GET" action="{{ route('admin.perbaikan.index') }}" class="flex gap-2">
                <select name="status" onchange="this.form.submit()"
                        class="border border-gray-300 rounded px-3 py-2 text-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    <option value="">-- Semua Status --</option>
                    <option value="Menunggu" {{ $status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ $status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ $status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @if(!empty($status))
                    <a href="{{ route('admin.perbaikan.index') }}" class="bg-gray-400 text-white px-3 py-2 rounded text-sm hover:bg-gray-500">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Penghuni</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($perbaikans as $perbaikan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($perbaikan->tanggal_lapor)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $perbaikan->penghuni->user->name ?? 'Tidak Ditemukan' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
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
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.perbaikan.edit', $perbaikan->id) }}" class="text-indigo-600 hover:text-indigo-900">Ubah Status</a>
                                    <form action="{{ route('admin.perbaikan.destroy', $perbaikan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Belum ada laporan perbaikan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection