<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Total Kamar</p>
                    <p class="text-3xl font-bold text-emerald-700">
                        {{ $totalKamar }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Kamar Tersedia</p>
                    <p class="text-3xl font-bold text-green-600">
                        {{ $kamarTersedia }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Kamar Terisi</p>
                    <p class="text-3xl font-bold text-blue-600">
                        {{ $kamarTerisi }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Total Penghuni</p>
                    <p class="text-3xl font-bold text-indigo-600">
                        {{ $totalPenghuni }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Pendapatan</p>
                    <p class="text-xl font-bold text-emerald-700">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold mb-4">
                        Pendapatan per Bulan
                    </h3>

                    @if(count($labelBulan) > 0)
                        <canvas id="grafikPendapatan"></canvas>
                    @else
                        <p class="text-gray-400">
                            Belum ada data pendapatan.
                        </p>
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold mb-4">
                        Status Kamar
                    </h3>

                    @if($totalKamar > 0)
                        <canvas id="grafikKamar"></canvas>
                    @else
                        <p class="text-gray-400">
                            Belum ada data kamar.
                        </p>
                    @endif
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        @if(count($labelBulan) > 0)
        new Chart(document.getElementById('grafikPendapatan'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelBulan) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($dataPendapatan) !!},
                    backgroundColor: '#10B981'
                }]
            }
        });
        @endif

        @if($totalKamar > 0)
        new Chart(document.getElementById('grafikKamar'), {
            type: 'doughnut',
            data: {
                labels: ['Terisi', 'Tersedia'],
                datasets: [{
                    data: [
                        {{ $kamarTerisi }},
                        {{ $kamarTersedia }}
                    ]
                }]
            }
        });
        @endif
    </script>

</x-app-layout>