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
            <h3 class="text-lg font-bold text-gray-700">Daftar Tagihan Penghuni</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.tagihan.pdf') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 transition ease-in-out duration-150">
                    Cetak PDF
                </a>
                <a href="{{ route('admin.tagihan.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 transition ease-in-out duration-150">
                    + Tambah Tagihan
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Penghuni</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Bulan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nominal Tagihan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tagihans as $tagihan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $tagihan->user->name ?? 'User Tidak Ditemukan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $tagihan->bulan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($tagihan->status == 'Lunas')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Lunas
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Belum Lunas
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.tagihan.edit', $tagihan->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('admin.tagihan.destroy', $tagihan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tagihan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Belum ada data tagihan bulanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection