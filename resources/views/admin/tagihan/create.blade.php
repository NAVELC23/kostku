@extends('layouts.app')
@section('content')
<div class="container mx-auto py-6 px-4 max-w-xl">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-700 mb-6">Tambah Tagihan Baru</h3>
        <form action="{{ route('admin.tagihan.store') }}" method="POST">
            @csrf

            {{-- Penghuni --}}
            <div class="mb-4">
                <label for="id_penghuni" class="block text-sm font-medium text-gray-700 mb-1">Pilih Penghuni Kos</label>
                <select name="id_penghuni" id="id_penghuni" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring" required>
                    <option value="">-- Pilih Penghuni --</option>
                    @foreach($penghunis as $penghuni)
                        <option value="{{ $penghuni->id_penghuni }}">
                            {{ $penghuni->user->name ?? 'Tanpa Nama' }} ({{ $penghuni->user->email ?? '-' }})
                        </option>
                    @endforeach
                </select>
                @error('id_penghuni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Bulan --}}
            <div class="mb-4">
                <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Periode Bulan Tagihan</label>
                <select name="bulan" id="bulan" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring" required>
                    <option value="">-- Pilih penghuni dulu --</option>
                </select>
                @error('bulan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Nominal --}}
            <div class="mb-4">
                <label for="nominal_tagihan" class="block text-sm font-medium text-gray-700 mb-1">Nominal Tagihan (Rp)</label>
                <input type="number" name="nominal_tagihan" id="nominal_tagihan"
                    class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring"
                    min="1" step="1" required>
                <p class="text-xs text-gray-400 mt-1">Otomatis diisi dari harga kamar, bisa diubah manual.</p>
                @error('nominal_tagihan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Status --}}
            <div class="mb-6">
                <label for="status_bayar" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran Awal</label>
                <select name="status_bayar" id="status_bayar" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring" required>
                    <option value="Belum Lunas">Belum Lunas</option>
                    <option value="Lunas">Lunas</option>
                </select>
                @error('status_bayar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.tagihan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow text-xs uppercase">Batal</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow text-xs uppercase">Simpan Tagihan</button>
            </div>
        </form>
    </div>
</div>

<script>
const hargaKamar = @json($hargaKamar);

document.getElementById('id_penghuni').addEventListener('change', function () {
    const id = this.value;
    const bulanSelect = document.getElementById('bulan');
    const nominalInput = document.getElementById('nominal_tagihan');

    bulanSelect.innerHTML = '<option value="">-- Pilih Bulan --</option>';
    nominalInput.value = '';

    if (!id || !hargaKamar[id]) return;

    nominalInput.value = hargaKamar[id].harga;

    const tanggalMasuk = new Date(hargaKamar[id].tanggal_masuk);
    
    // Gunakan tanggal_keluar kalau ada, kalau tidak pakai sekarang
    const batas = hargaKamar[id].tanggal_keluar 
        ? new Date(hargaKamar[id].tanggal_keluar) 
        : new Date();

    let current = new Date(tanggalMasuk.getFullYear(), tanggalMasuk.getMonth(), 1);
    const batasBulan = new Date(batas.getFullYear(), batas.getMonth(), 1);

    while (current <= batasBulan) {
        const year = current.getFullYear();
        const month = String(current.getMonth() + 1).padStart(2, '0');
        const value = `${year}-${month}`;
        const label = current.toLocaleString('id-ID', { month: 'long', year: 'numeric' });

        const option = document.createElement('option');
        option.value = value;
        option.textContent = label;
        bulanSelect.appendChild(option);

        current.setMonth(current.getMonth() + 1);
    }
});
</script>
@endsection