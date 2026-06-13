<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard Admin</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 space-y-8">

            <p class="text-gray-600">Selamat datang di panel admin KostKu. Berikut ringkasan data kos kamu.</p>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Total Kamar</p>
                    <p class="text-3xl font-bold text-emerald-700 mt-1">{{ $totalKamar }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Kamar Tersedia</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $kamarTersedia }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Total Penghuni</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalPenghuni }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Total Tagihan</p>
                    <p class="text-3xl font-bold text-amber-600 mt-1">{{ $totalTagihan }}</p>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Menu Pengelolaan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('admin.kamar.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition block">
                        <div class="text-emerald-600 text-3xl mb-2">🛏️</div>
                        <p class="font-semibold">Kelola Kamar</p>
                        <p class="text-sm text-gray-500">Tambah, edit, dan hapus data kamar.</p>
                    </a>
                    <a href="{{ route('admin.penghuni.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition block">
                        <div class="text-blue-600 text-3xl mb-2">👤</div>
                        <p class="font-semibold">Kelola Penghuni</p>
                        <p class="text-sm text-gray-500">Data penghuni dan kontrak sewa.</p>
                    </a>
                    <a href="{{ route('admin.tagihan.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition block">
                        <div class="text-amber-600 text-3xl mb-2">🧾</div>
                        <p class="font-semibold">Kelola Tagihan</p>
                        <p class="text-sm text-gray-500">Buat dan pantau tagihan penghuni.</p>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>