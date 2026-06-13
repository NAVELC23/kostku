<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan KostKu</title>
    <style>
        body { font-family: sans-serif; }
        .title { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #16a34a; color: white; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="title">
        <h2>LAPORAN TAGIHAN BULANAN KOSTKU</h2>
        <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Penghuni</th>
                <th>Bulan</th>
                <th>Nominal Tagihan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tagihans as $tagihan)
            <tr>
                <td>{{ $tagihan->penghuni->user->name ?? 'N/A' }}</td>
                <td>{{ $tagihan->bulan }}</td>
                <td>Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</td>
                <td>{{ $tagihan->status_bayar }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>