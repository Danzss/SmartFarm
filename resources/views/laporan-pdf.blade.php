<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Agrikultur Terpadu</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { color: #1b4332; margin-bottom: 5px; }
        .header { border-bottom: 2px solid #1b4332; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #1b4332; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Agrikultur Terpadu - SmartFarm</h2>
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <h3>Ringkasan Performa Sektor</h3>
    <table>
        <thead>
            <tr>
                <th>Metrik</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Populasi tanaman</td>
                <td>{{ number_format($totalTanaman, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Luas lahan aktif</td>
                <td>{{ number_format($totalLahan, 2, ',', '.') }} Ha ({{ $jumlahLahanAktif }} lahan)</td>
            </tr>
            <tr><td>Tugas terbuka</td><td>{{ $tugasTerbuka }}</td></tr>
            <tr><td>Panen tercatat</td><td>{{ number_format($panenTercatatTon, 2, ',', '.') }} Ton ({{ $jumlahCatatanPanen }} catatan)</td></tr>
            <tr><td>Catatan monitoring</td><td>{{ $jumlahMonitoring }}</td></tr>
            <tr><td>Laporan hama</td><td>{{ $jumlahLaporanHama }}</td></tr>
        </tbody>
    </table>

    <h3>Data Lahan</h3>
    <table>
        <thead><tr><th>Nama Lahan</th><th>Sektor</th><th>Komoditas</th><th>Luas</th><th>Status</th></tr></thead>
        <tbody>
            @forelse ($lahanList as $lahan)
                <tr>
                    <td>{{ $lahan['nama'] ?? '-' }}</td>
                    <td>{{ $lahan['sektor'] ?? '-' }}</td>
                    <td>{{ $lahan['komoditas'] ?? '-' }}</td>
                    <td>{{ $lahan['luas'] ?? '-' }}</td>
                    <td>{{ $lahan['status'] ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada data lahan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Data Tanaman</h3>
    <table>
        <thead><tr><th>Tanaman</th><th>Lokasi</th><th>Populasi</th><th>Status</th></tr></thead>
        <tbody>
            @forelse ($tanamanList as $tanaman)
                <tr>
                    <td>{{ $tanaman['nama'] ?? '-' }}</td>
                    <td>{{ $tanaman['lokasi'] ?? '-' }}</td>
                    <td>{{ number_format((int) ($tanaman['populasi'] ?? 0), 0, ',', '.') }}</td>
                    <td>{{ $tanaman['status'] ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada data tanaman.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Catatan Panen</h3>
    <table>
        <thead><tr><th>Tanggal</th><th>Komoditas</th><th>Sektor</th><th>Kuantitas (kg)</th><th>Grade</th></tr></thead>
        <tbody>
            @forelse ($panenData as $panen)
                <tr>
                    <td>{{ $panen['tanggal'] ?? '-' }}</td>
                    <td>{{ $panen['komoditas'] ?? '-' }}</td>
                    <td>{{ $panen['sektor'] ?? '-' }}</td>
                    <td>{{ number_format((float) ($panen['kuantitas'] ?? 0), 2, ',', '.') }}</td>
                    <td>{{ $panen['grade'] ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada catatan panen.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>