<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan & Hasil Panen - SmartFarm</title>
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

        /* Main Content */
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
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .progress-bar-custom {
            height: 6px;
            border-radius: 10px;
        }

        /* Chart Doughnut Center Text */
        .doughnut-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto;
        }

        .doughnut-center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
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
                    <a href="{{ route('panen.index') }}" class="nav-link {{ request()->routeIs('panen.*') || request()->routeIs('pencatatan-panen.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-wheat-awn me-2"></i>Panen
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-lines me-2"></i>Laporan
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <ul class="nav nav-pills flex-column mb-3">
                <li class="nav-item">
                    <a href="{{ route('pengaturan.index') }}" class="nav-link {{ request()->routeIs('pengaturan.*') || request()->routeIs('profile.*') ? 'active' : '' }}">
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
                <input type="text" class="form-control border-start-0 bg-white rounded-end-3" placeholder="Cari lahan, tanaman, sensor...">
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-success btn-sm rounded-3 px-3"><i class="fa-solid fa-plus me-1"></i> Catat Data</button>
                @include('layouts.notification-dropdown')
                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-success fw-bold text-uppercase"><i class="fa-solid fa-wheat-awn me-1"></i> MODUL HASIL USAHA TANI</small>
                <h3 class="fw-bold text-dark mb-1">Pencatatan & Hasil Panen</h3>
                <p class="text-muted small mb-0">Rekapitulasi kuantitas hasil panen, grading mutu, distribusi pasar, dan evaluasi hasil komoditas agrikultur secara presisi.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('panen.export') }}" class="btn btn-outline-secondary btn-sm rounded-3 text-decoration-none"><i class="fa-solid fa-download me-1"></i> Unduh Rekap Hasil CSV</a>
                <a href="#form-panen" class="btn btn-success btn-sm rounded-3"><i class="fa-solid fa-plus me-1"></i> Catat Panen Baru</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        <section id="form-panen" class="card card-custom p-4 mb-4" aria-labelledby="form-panen-title">
            <h5 id="form-panen-title" class="fw-bold mb-3">Catat hasil panen</h5>
            <form action="{{ route('panen.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label for="panen-tanggal" class="form-label">Tanggal panen</label>
                    <input id="panen-tanggal" name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', now()->toDateString()) }}" required>
                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="panen-komoditas" class="form-label">Komoditas</label>
                    <input id="panen-komoditas" name="komoditas" type="text" class="form-control @error('komoditas') is-invalid @enderror" value="{{ old('komoditas') }}" required maxlength="100">
                    @error('komoditas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="panen-sektor" class="form-label">Lahan / sektor</label>
                    <input id="panen-sektor" name="sektor" type="text" class="form-control @error('sektor') is-invalid @enderror" value="{{ old('sektor') }}" required maxlength="100">
                    @error('sektor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="panen-kuantitas" class="form-label">Kuantitas (kg)</label>
                    <input id="panen-kuantitas" name="kuantitas" type="number" min="0.01" step="0.01" class="form-control @error('kuantitas') is-invalid @enderror" value="{{ old('kuantitas') }}" required>
                    @error('kuantitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="panen-grade" class="form-label">Grade / mutu</label>
                    <select id="panen-grade" name="grade" class="form-select @error('grade') is-invalid @enderror" required>
                        <option value="">Pilih grade</option>
                        @foreach (['Grade A', 'Grade B', 'Grade C'] as $grade)
                            <option value="{{ $grade }}" @selected(old('grade') === $grade)>{{ $grade }}</option>
                        @endforeach
                    </select>
                    @error('grade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan panen</button>
                </div>
            </form>
        </section>

        <!-- SUMMARY CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.65rem;">TOTAL PANEN MUSIM INI</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-weight-hanging"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($totalPanenTon, 2, ',', '.') }} <span class="fs-6 fw-normal text-muted">Ton</span></h3>
                    <small class="text-muted">Dihitung dari {{ $jumlahPanen }} catatan panen.</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.65rem;">GRADE A / PREMIUM</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-award"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($gradeAPercent, 1, ',', '.') }} <span class="fs-6 fw-normal text-muted">%</span></h3>
                    <small class="text-muted d-block mb-2" style="font-size: 0.65rem;">Proporsi catatan ber-grade A</small>
                    <div class="progress progress-bar-custom bg-light">
                        <div class="progress-bar bg-success" style="width: {{ $gradeAPercent }}%;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.65rem;">TOTAL KUANTITAS</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-money-bill-wave"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($totalPanenKg, 2, ',', '.') }} <span class="fs-6 fw-normal text-muted">Kg</span></h3>
                    <small class="text-muted d-block mb-2" style="font-size: 0.65rem;">Total kuantitas dari semua catatan.</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.65rem;">KOMODITAS TERBANYAK</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-apple-whole"></i></div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $topCommodity ?: 'Belum ada data' }}</h5>
                    <small class="text-muted d-block" style="font-size: 0.65rem;">{{ $topCommodity ? number_format($topCommodityVolumeKg, 2, ',', '.') . ' Kg tercatat' : 'Catat panen untuk melihat komoditas teratas.' }}</small>
                </div>
            </div>
        </div>

        <!-- MIDDLE SECTION: CHART & DISTRIBUTION -->
        <div class="row g-3 mb-4">
            <!-- GRAFIK PANEN TERCATAT -->
            <div class="col-md-8">
                <div class="card card-custom p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Panen Tercatat per Bulan</h5>
                            <small class="text-muted" style="font-size: 0.7rem;">Akumulasi kuantitas dari semua catatan panen.</small>
                        </div>
                        <span class="badge bg-light text-dark border">{{ count($panenRecords) }} catatan</span>
                    </div>

                    <div style="height: 220px;" class="mt-2">
                        @if ($monthlyHarvest->isNotEmpty())
                            <canvas id="harvestBarChart"></canvas>
                        @else
                            <div class="h-100 d-flex justify-content-center align-items-center text-muted">Belum ada catatan panen.</div>
                        @endif
                    </div>

                    <div class="row g-2 mt-3">
                        @forelse ($harvestBySector as $sektor => $quantity)
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-2 bg-light rounded-3 text-center">
                                    <small class="text-muted d-block">{{ $sektor }}</small>
                                    <span class="fw-bold text-dark">{{ number_format($quantity, 2, ',', '.') }} Kg</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted small">Belum ada panen per sektor.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- DISTRIBUSI MUTU & HIGHLIGHT -->
            <div class="col-md-4">
                <div class="d-flex flex-column gap-3 h-100">

                    <!-- DONUT CHART DOUGHNUT -->
                    <div class="card card-custom p-3 flex-fill">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-dark mb-0">Distribusi Mutu</h6>
                            <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 0.65rem;">Klasifikasi Mutu</span>
                        </div>

                        @if ($gradeLabels->isNotEmpty())
                            <div class="doughnut-wrapper my-2">
                                <canvas id="qualityDoughnutChart"></canvas>
                                <div class="doughnut-center-text">
                                    <h4 class="fw-bold mb-0">{{ number_format($gradeAPercent, 1, ',', '.') }}%</h4>
                                    <small class="text-muted" style="font-size: 0.65rem;">Grade A</small>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted py-5">Belum ada data grade.</div>
                        @endif

                        <ul class="list-unstyled mb-0 mt-2" style="font-size: 0.7rem;">
                            @forelse ($gradeCounts as $grade => $count)
                                <li class="d-flex justify-content-between align-items-center mb-1">
                                    <span>{{ $grade }}</span><span class="fw-bold">{{ $count }} catatan</span>
                                </li>
                            @empty
                                <li class="text-center text-muted">Belum ada catatan mutu.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="card card-custom p-3">
                        <small class="text-muted fw-bold d-block mb-2">PANEN TERBARU</small>
                        @if (!empty($panenRecords))
                            @php($latestHarvest = $panenRecords[0])
                            <strong>{{ $latestHarvest['komoditas'] }}</strong>
                            <span class="text-muted small">{{ $latestHarvest['tanggal'] }} · {{ $latestHarvest['sektor'] }}</span>
                            <span class="fw-bold mt-2">{{ number_format((float) $latestHarvest['kuantitas'], 2, ',', '.') }} Kg · {{ $latestHarvest['grade'] }}</span>
                        @else
                            <span class="text-muted small">Belum ada panen yang dicatat.</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- TABLE SECTION: RIWAYAT & LOG PANEN -->
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0">Riwayat & Log Panen Terbaru</h5>
                    <small class="text-muted" style="font-size: 0.7rem;">Menampilkan jejak jejak timbang dan rantai distribusi komoditas</small>
                </div>

                <div class="d-flex gap-2">
                    <span class="small text-muted">Diurutkan terbaru · {{ count($panenRecords) }} catatan</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-3" style="font-size: 0.75rem;">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>ID Panen</th>
                            <th>Tanggal</th>
                            <th>Komoditas</th>
                            <th>Lahan / Sektor</th>
                            <th>Kuantitas</th>
                            <th>Grade / Mutu</th>
                            <th>Status Distribusi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($panenRecords as $record)
                            <tr>
                                <td class="fw-bold text-secondary">{{ $record['id'] ?? '-' }}</td>
                                <td>{{ $record['tanggal'] ?? '-' }}</td>
                                <td>{{ $record['komoditas'] ?? '-' }}</td>
                                <td>{{ $record['sektor'] ?? '-' }}</td>
                                <td class="fw-bold">{{ number_format((float) ($record['kuantitas'] ?? 0), 2, ',', '.') }} Kg</td>
                                <td><span class="badge bg-success-subtle text-success border">{{ $record['grade'] ?? 'Belum diklasifikasikan' }}</span></td>
                                <td><span class="badge bg-secondary-subtle text-secondary rounded-pill">{{ $record['distribusi'] ?? 'Belum didistribusikan' }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-5">Belum ada catatan panen.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- TABLE PAGINATION -->
            <div class="d-flex justify-content-between align-items-center pt-2">
                <small class="text-muted" style="font-size: 0.7rem;">Menampilkan {{ count($panenRecords) }} catatan panen</small>
            </div>
        </div>

    </main>

    <!-- CHARTS FROM RECORDED HARVESTS -->
    <script>
        const monthlyLabels = @json($monthlyHarvestLabels);
        const monthlyValues = @json($monthlyHarvestValues);
        const barCanvas = document.getElementById('harvestBarChart');
        if (barCanvas && monthlyLabels.length > 0) {
            new Chart(barCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Panen tercatat (Ton)',
                        data: monthlyValues,
                        backgroundColor: '#1b4332',
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

        const gradeLabels = @json($gradeLabels);
        const gradeValues = @json($gradeValues);
        const gradeCanvas = document.getElementById('qualityDoughnutChart');
        if (gradeCanvas && gradeLabels.length > 0) {
            new Chart(gradeCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: gradeLabels,
                    datasets: [{
                        data: gradeValues,
                        backgroundColor: ['#1b4332', '#74c69d', '#ffc107', '#0dcaf0'],
                        borderWidth: 0,
                        cutout: '75%'
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
        }
    </script>
</body>

</html>