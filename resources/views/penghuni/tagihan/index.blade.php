@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        
        <h3 class="text-lg font-bold text-gray-700 mb-6">Riwayat Tagihan Kos Anda</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Periode Bulan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Total Tagihan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tagihans as $tagihan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $tagihan->bulan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}
                            </td>
                           <td class="px-6 py-4 whitespace-nowrap">
                            @if($tagihan->status_bayar == 'Lunas')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Sudah Lunas
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Harap Segera Bayar
                                </span>
                            @endif
                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Hore! Anda tidak memiliki tagihan aktif saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection