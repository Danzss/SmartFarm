<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Agrikultur Terpadu - SmartFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --sidebar-width: 240px;
            --primary-green: #1b4332;
            --light-green: #2d6a4f;
            --accent-green: #52b788;
            --bg-light: #f8f9fa;
        }

        body {
            background-color: var(--bg-light);
            font-size: 0.875rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: #fff;
            border-right: 1px solid #dee2e6;
            z-index: 1000;
            padding: 1.25rem 1rem;
        }

        .sidebar .nav-link {
            color: #6c757d;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 4px;
            padding: 8px 12px;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--primary-green);
            color: #fff;
        }

        .sidebar .nav-link i {
            width: 20px;
        }

        /* Main Content Layout */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem 2rem;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .icon-box {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="d-flex align-items-center mb-4 px-2">
                <i class="fa-solid fa-tractor text-success fs-3 me-2"></i>
                <div>
                    <h5 class="fw-bold mb-0 text-success">SmartFarm</h5>
                    <small class="text-muted" style="font-size: 0.7rem;">Agri System</small>
                </div>
            </div>

            <small class="text-muted fw-bold text-uppercase px-2" style="font-size: 0.65rem;">MANAJEMEN PERTANIAN</small>
            <ul class="nav nav-pills flex-column mt-2">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tanaman.index') }}" class="nav-link {{ request()->routeIs('tanaman.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-seedling me-2"></i>Tanaman
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('lahan.index') }}" class="nav-link {{ request()->routeIs('lahan.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-map-location-dot me-2"></i>Lahan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jadwal.index') }}" class="nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-check me-2"></i>Jadwal
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('monitoring.index') }}" class="nav-link {{ request()->routeIs('monitoring.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-desktop me-2"></i>Monitoring
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('deteksi-ai.index') }}" class="nav-link {{ request()->routeIs('deteksi-ai.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-microscope me-2"></i>Deteksi Penyakit AI
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hama.index') }}" class="nav-link {{ request()->routeIs('hama.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bug me-2"></i>Hama & Penyakit
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('riwayat.index') }}" class="nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('panen.index') }}" class="nav-link {{ request()->routeIs('panen.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-wheat-awn me-2"></i>Panen
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') || request()->routeIs('analitik.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-lines me-2"></i>Laporan
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <ul class="nav nav-pills flex-column mb-3">
                <li class="nav-item">
                    <a href="{{ route('pengaturan.index') }}" class="nav-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear me-2"></i>Profil dan Pengaturan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tentang.index') }}" class="nav-link {{ request()->routeIs('tentang.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle-info me-2"></i>Tentang Aplikasi
                    </a>
                </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 text-start border-0 px-3">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOP NAVBAR -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" class="form-control border-start-0 bg-white rounded-end-3" placeholder="Cari data laporan, parameter, sektor...">
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-success btn-sm rounded-3 px-3"><i class="fa-solid fa-plus me-1"></i> Catat Data</button>
                @include('layouts.notification-dropdown')
                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <!-- PAGE HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <small class="text-success fw-bold text-uppercase"><i class="fa-solid fa-chart-line me-1"></i> PUSAT LAPORAN & ANALISIS DATA</small>
                <h3 class="fw-bold text-dark mb-1">Laporan Agrikultur Terpadu</h3>
                <p class="text-muted small mb-0">Analisis performa produksi, pemanfaatan sumber daya air & pupuk, insiden hama, serta tinjauan evaluasi hasil panen periode berkala seluruh sektor.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('laporan.export-csv') }}" class="btn btn-outline-secondary btn-sm rounded-3 text-decoration-none"><i class="fa-solid fa-file-csv me-1"></i> Ekspor CSV untuk Excel</a>
                <!-- TOMBOL EKSPOR PDF YANG SUDAH DIHUBUNGKAN KE ROUTE -->
                <a href="{{ route('laporan.export-pdf') }}" class="btn btn-success btn-sm rounded-3 text-decoration-none">
                    <i class="fa-solid fa-file-pdf me-1"></i> Ekspor PDF Resmi
                </a>
            </div>
        </div>

        <div class="card card-custom p-3 mb-4 d-flex flex-row justify-content-between align-items-center flex-wrap gap-2">
            <span class="text-muted small">Ringkasan dihimpun dari data lahan, tanaman, jadwal, panen, hama, dan monitoring yang tercatat.</span>
            <span class="badge bg-light text-dark border">Diperbarui {{ now()->format('d M Y H:i') }}</span>
        </div>

        <!-- KPI METRICS ROW -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.65rem;">POPULASI TANAMAN</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-wheat-awn"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($totalTanaman, 0, ',', '.') }}</h3>
                    <small class="text-muted d-block mb-2" style="font-size: 0.7rem;">Total populasi pada {{ count($tanamanList) }} entri</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.65rem;">LUAS LAHAN AKTIF</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-bottle-droplet"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($totalLahan, 2, ',', '.') }} Ha</h3>
                    <small class="text-muted d-block mb-2" style="font-size: 0.7rem;">{{ $jumlahLahanAktif }} lahan di {{ $jumlahSektorAktif }} sektor</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.65rem;">TUGAS TERBUKA</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-heart-pulse"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $tugasTerbuka }}</h3>
                    <small class="text-muted d-block mb-2" style="font-size: 0.7rem;">{{ $totalTugas }} tugas terjadwal</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.65rem;">PANEN TERCATAT</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-award"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($panenTercatatTon, 2, ',', '.') }} Ton</h3>
                    <small class="text-muted d-block mb-2" style="font-size: 0.7rem;">{{ $jumlahCatatanPanen }} catatan</small>
                </div>
            </div>
        </div>

        <!-- CHARTS SECTION -->
        <div class="row g-3 mb-4">
            <!-- BAR CHART: HASIL PANEN VS PENGGUNAAN AIR & NUTRISI -->
            <div class="col-md-8">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Pertumbuhan Aktual vs Target</h6>
                            <small class="text-muted" style="font-size: 0.7rem;">Data dari log pertumbuhan yang tersimpan.</small>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-success" style="font-size: 0.6rem;">Aktual</span>
                            <span class="badge bg-success-subtle text-success border" style="font-size: 0.6rem;">Target</span>
                        </div>
                    </div>

                    <div class="chart-container">
                        @if (count($growthLogs))
                            <canvas id="cropChart"></canvas>
                        @else
                            <div class="text-center text-muted py-5">Belum ada log pertumbuhan tersimpan.</div>
                        @endif
                    </div>

                    <div class="bg-light rounded-3 p-2 mt-3 d-flex align-items-center justify-content-between" style="font-size: 0.7rem;">
                        <span class="text-muted"><i class="fa-solid fa-circle-info text-success me-1"></i> Grafik mengikuti semua catatan aktual yang tersimpan.</span>
                        <span class="text-secondary fw-bold">{{ count($growthLogs) }} catatan</span>
                    </div>
                </div>
            </div>

            <!-- DONUT CHART: INCIDEN & MITIGASI HAMA -->
            <div class="col-md-4">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold text-dark mb-0">Laporan Hama & Penyakit</h6>
                        <span class="badge bg-light text-dark border">{{ $jumlahLaporanHama }} laporan</span>
                    </div>
                    <small class="text-muted d-block mb-3" style="font-size: 0.7rem;">Catatan yang dikirim melalui modul Hama & Penyakit.</small>
                    @forelse ($hamaReports as $report)
                        <div class="border-bottom py-2">
                            <strong class="d-block">{{ $report['tanaman'] ?? 'Tanaman' }} · {{ $report['gejala'] ?? 'Gejala' }}</strong>
                            <small class="text-muted">{{ $report['lokasi'] ?? 'Lokasi belum dicatat' }} · {{ $report['tanggal'] ?? '' }}</small>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">Belum ada laporan hama yang dicatat.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- TABLE: TABEL EVALUASI SEKTOR PRODUKSI -->
        <div class="card card-custom p-3 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold text-dark mb-0">Tabel Evaluasi Sektor Produksi</h6>
                    <small class="text-muted" style="font-size: 0.7rem;">Matriks efisiensi operasional, tonase hasil panen akhir, dan catatan keahlian agronomis.</small>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm rounded-3" style="font-size: 0.7rem;"><i class="fa-solid fa-filter me-1"></i> Filter Kolom</button>
                    <a href="{{ route('laporan.export-csv') }}" class="btn btn-outline-secondary btn-sm rounded-3 text-decoration-none" style="font-size: 0.7rem;"><i class="fa-solid fa-download me-1"></i> Unduh CSV</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>NAMA LAHAN</th>
                            <th>SEKTOR</th>
                            <th>KOMODITAS</th>
                            <th>LUAS</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lahanList as $lahan)
                            <tr>
                                <td class="fw-bold">{{ $lahan['nama'] ?? '-' }}</td>
                                <td>{{ $lahan['sektor'] ?? '-' }}</td>
                                <td>{{ $lahan['komoditas'] ?? '-' }}</td>
                                <td>{{ $lahan['luas'] ?? '-' }}</td>
                                <td>{{ $lahan['status'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data lahan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-custom p-3 mb-4">
            <h6 class="fw-bold mb-3">Tanaman Terdaftar</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                    <thead class="table-light text-muted"><tr><th>Tanaman</th><th>Lokasi</th><th>Populasi</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($tanamanList as $tanaman)
                            <tr>
                                <td class="fw-bold">{{ $tanaman['nama'] ?? '-' }}</td>
                                <td>{{ $tanaman['lokasi'] ?? '-' }}</td>
                                <td>{{ number_format((int) ($tanaman['populasi'] ?? 0), 0, ',', '.') }}</td>
                                <td>{{ $tanaman['status'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data tanaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-custom p-3 mb-4">
            <h6 class="fw-bold mb-3">Catatan Panen</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                    <thead class="table-light text-muted"><tr><th>Tanggal</th><th>Komoditas</th><th>Sektor</th><th>Kuantitas (kg)</th><th>Grade</th></tr></thead>
                    <tbody>
                        @forelse ($panenData as $panen)
                            <tr>
                                <td>{{ $panen['tanggal'] ?? '-' }}</td>
                                <td class="fw-bold">{{ $panen['komoditas'] ?? '-' }}</td>
                                <td>{{ $panen['sektor'] ?? '-' }}</td>
                                <td>{{ number_format((float) ($panen['kuantitas'] ?? 0), 2, ',', '.') }}</td>
                                <td>{{ $panen['grade'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada catatan panen.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-8">
                <div class="card card-custom p-3 h-100">
                    <h6 class="fw-bold mb-3">Ringkasan Data Terhubung</h6>
                    <p class="text-muted small">Laporan menggabungkan data yang saat ini tersimpan pada setiap modul.</p>
                    <div class="row g-3">
                        <div class="col-sm-6"><span class="text-muted d-block small">Lahan terdaftar</span><strong>{{ count($lahanList) }}</strong></div>
                        <div class="col-sm-6"><span class="text-muted d-block small">Entri tanaman</span><strong>{{ count($tanamanList) }}</strong></div>
                        <div class="col-sm-6"><span class="text-muted d-block small">Catatan panen</span><strong>{{ $jumlahCatatanPanen }}</strong></div>
                        <div class="col-sm-6"><span class="text-muted d-block small">Catatan monitoring</span><strong>{{ $jumlahMonitoring }}</strong></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-3 h-100">
                    <h6 class="fw-bold mb-3">Data Perlu Tindak Lanjut</h6>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Tugas terbuka</span><strong>{{ $tugasTerbuka }}</strong></div>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Tanaman bermasalah</span><strong>{{ $tanamanPerluPerhatian }}</strong></div>
                    <div class="d-flex justify-content-between py-2"><span class="text-muted">Lahan darurat</span><strong>{{ $lahanPerluPerhatian }}</strong></div>
                </div>
            </div>
        </div>

    </main>

    <!-- CHART FROM STORED GROWTH LOGS -->
    <script>
        const reportGrowthRows = @json($growthLogs);
        const reportGrowthCanvas = document.getElementById('cropChart');
        if (reportGrowthCanvas && reportGrowthRows.length > 0) {
            new Chart(reportGrowthCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: reportGrowthRows.map(row => row.day),
                    datasets: [{
                        label: 'Aktual',
                        data: reportGrowthRows.map(row => row.actual),
                        backgroundColor: '#1b4332',
                        borderRadius: 4
                    }, {
                        label: 'Target',
                        data: reportGrowthRows.map(row => row.target),
                        backgroundColor: '#74c69d',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true }, x: { grid: { display: false } } }
                }
            });
        }
    </script>

</body>

</html>