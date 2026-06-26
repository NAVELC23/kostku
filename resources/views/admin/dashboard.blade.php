@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-6 space-y-8">

        <div>
            <h2 class="font-semibold text-xl text-gray-800">Dashboard Admin</h2>
            <p class="text-gray-600 mt-1">Selamat datang di panel admin KostKu. Berikut ringkasan data kos kamu.</p>
        </div>

        {{-- Statistik --}}
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


        {{-- Charts --}}
        <div>
            <h3 class="font-semibold text-lg text-gray-800 mb-4">Grafik & Statistik</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                {{-- Chart 1: Donut Status Kamar --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="font-semibold text-gray-700 mb-4">Status Kamar</p>
                    <div class="flex justify-center" style="height: 250px;">
                        <canvas id="kamarStatusChart"></canvas>
                    </div>
                </div>

                {{-- Chart 2: Bar Pendapatan Bulanan --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="font-semibold text-gray-700 mb-4">Pendapatan Bulanan (6 Bulan Terakhir)</p>
                    <div style="height: 250px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

            </div>

            {{-- Chart 3: Line Tren Tagihan --}}
            <div class="bg-white rounded-lg shadow p-6">
                <p class="font-semibold text-gray-700 mb-4">Tren Tagihan (6 Bulan Terakhir)</p>
                <div style="height: 250px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const kamarStatusData = @json($kamarStatusData);
    const revenueData     = @json($revenueData);
    const trendData       = @json($trendData);

    // Chart 1: Donut — Status Kamar
    new Chart(document.getElementById('kamarStatusChart'), {
        type: 'doughnut',
        data: {
            labels: kamarStatusData.labels,
            datasets: [{
                data: kamarStatusData.data,
                backgroundColor: ['#10b981', '#3b82f6'],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Chart 2: Bar — Pendapatan Bulanan
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: revenueData.labels.length ? revenueData.labels : ['Belum ada data'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueData.data.length ? revenueData.data : [0],
                backgroundColor: '#10b981',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                    }
                }
            }
        }
    });

    // Chart 3: Line — Tren Tagihan
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: trendData.labels,
            datasets: [
                {
                    label: 'Lunas',
                    data: trendData.lunas,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Belum Lunas',
                    data: trendData.belum_lunas,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245,158,11,0.1)',
                    tension: 0.4,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>
@endsection