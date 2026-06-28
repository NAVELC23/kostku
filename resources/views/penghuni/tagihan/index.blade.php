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
                <tbody id="tagihan-body" class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-sm text-gray-400 text-center">
                            Memuat data tagihan...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
fetch('/api/tagihan/penghuni', {
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    }
})
.then(res => res.json())
.then(response => {
    const tbody = document.getElementById('tagihan-body');

    if (!response.success || response.data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="px-6 py-4 text-sm text-gray-500 text-center">
                    Hore! Anda tidak memiliki tagihan aktif saat ini.
                </td>
            </tr>`;
        return;
    }

    tbody.innerHTML = response.data.map(tagihan => {
        const harga = new Intl.NumberFormat('id-ID').format(tagihan.nominal_tagihan);
        const status = tagihan.status_bayar === 'Lunas'
            ? `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sudah Lunas</span>`
            : `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Harap Segera Bayar</span>`;

        return `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${tagihan.bulan}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">Rp ${harga}</td>
                <td class="px-6 py-4 whitespace-nowrap">${status}</td>
            </tr>`;
    }).join('');
})
.catch(() => {
    document.getElementById('tagihan-body').innerHTML = `
        <tr>
            <td colspan="3" class="px-6 py-4 text-sm text-red-500 text-center">
                Gagal memuat data tagihan.
            </td>
        </tr>`;
});
</script>
@endsection