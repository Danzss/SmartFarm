<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utama - SmartFarm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --sidebar-width: 240px;
            --primary-green: #1b4332;
            --light-green: #2d6a4f;
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

        /* Card Styling */
        .card-custom {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .badge-soft-success {
            background-color: #d8f3dc;
            color: #2d6a4f;
            font-weight: 600;
        }

        .badge-soft-danger {
            background-color: #ffe5ec;
            color: #d90429;
            font-weight: 600;
        }

        .badge-soft-warning {
            background-color: #fff3bf;
            color: #f59f00;
            font-weight: 600;
        }

        /* Icon Box */
        .icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar d-flex flex-column justify-content-between">
        <div>
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="text-decoration-none d-flex align-items-center mb-4 px-2">
                <i class="fa-solid fa-tractor text-success fs-3 me-2"></i>
                <div>
                    <h5 class="fw-bold mb-0 text-success">SmartFarm</h5>
                    <small class="text-muted" style="font-size: 0.7rem;">Agri System</small>
                </div>
            </a>

            <!-- Navigation Links -->
            <small class="text-muted fw-bold text-uppercase px-2" style="font-size: 0.65rem;">Manajemen Pertanian</small>
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
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
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
            <!-- Form Pencarian Fungsional -->
            <form action="{{ route('dashboard') }}" method="GET" class="input-group" style="max-width: 400px;">
                <input type="hidden" name="periode" value="{{ $periode }}">
                <button type="submit" class="input-group-text bg-white border-end-0 rounded-start-3 text-muted border-0 bg-transparent" style="cursor: pointer;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}" class="form-control border-start-0 bg-white rounded-end-3 shadow-none" placeholder="Cari tugas, notifikasi, atau sistem...">
            </form>

            <div class="d-flex align-items-center gap-3">
                @include('layouts.notification-dropdown')

                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-success fw-bold text-uppercase">Operasional Pertanian • Realtime Telemetri</small>
                <h3 class="fw-bold text-dark mb-0">Dashboard Utama</h3>
                <p class="text-muted small mb-0">Ringkasan operasional dan kesehatan pertanian SmartFarm hari ini.</p>
            </div>
            <div class="d-flex gap-2">
                <!-- Dropdown Periode Interaktif -->
                <div class="dropdown">
                    <button class="btn btn-white btn-sm border rounded-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-calendar me-1"></i> {{ $periodeLabel }}
                    </button>
                    <ul class="dropdown-menu shadow border-0 rounded-3" style="font-size: 0.8rem;">
                        @foreach ($periodeOptions as $key => $label)
                            <li>
                                <a class="dropdown-item {{ $periode === $key ? 'active' : '' }}" href="{{ route('dashboard', array_filter(['periode' => $key, 'search' => $search])) }}">{{ $label }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tombol Unduh Laporan PDF -->
                <a href="{{ route('laporan.export-pdf') }}" class="btn btn-white btn-sm border rounded-3">
                    <i class="fa-solid fa-file-pdf me-1"></i> Unduh Laporan PDF
                </a>
            </div>
        </div>

        <!-- METRIC CARDS (TOP 4 - DENGAN DATA DINAMIS) -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">TOTAL TANAMAN</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-plant-wilt"></i></div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ number_format($totalTanaman, 0, ',', '.') }}</h2>
                    <small class="text-muted">{{ count($tanamanList) }} entri komoditas terdaftar</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">TOTAL LUAS LAHAN AKTIF</small>
                        <div class="icon-box bg-secondary-subtle text-secondary"><i class="fa-solid fa-vector-square"></i></div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h2 class="fw-bold mb-1">{{ number_format($totalLahan, 2, ',', '.') }}</h2>
                        <span class="text-muted fw-bold">Ha</span>
                    </div>
                    <div class="d-flex gap-2 mt-1">
                        <small class="text-muted">{{ $jumlahLahanAktif }} lahan • {{ $jumlahSektorAktif }} sektor aktif</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">BUTUH TINDAKAN</small>
                        <div class="icon-box bg-danger-subtle text-danger"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                    <h2 class="fw-bold text-danger mb-1">{{ $butuhTindakan }}</h2>
                    <div class="d-flex gap-2 mt-1">
                        <small class="text-muted">{{ $tugasTerbuka }} tugas • {{ $tanamanPerluPerhatian }} tanaman • {{ $lahanPerluPerhatian }} lahan</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">PANEN TERCATAT</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-tractor"></i></div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h2 class="fw-bold mb-1">{{ number_format($panenTercatatTon, 2, ',', '.') }}</h2>
                        <span class="text-muted fw-bold">Ton</span>
                    </div>
                    <small class="text-muted">{{ $jumlahCatatanPanen }} catatan hasil panen</small>
                </div>
            </div>
        </div>

        <!-- MAIN BODY -->
        <div class="row g-3">
            <!-- LEFT COLUMN -->
            <div class="col-lg-8">
                <!-- CHART CARD -->
                <div class="card card-custom p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted fw-bold">METRIK AGRIKULTUR</small>
                            <h6 class="fw-bold mb-0">Perkembangan Pertumbuhan Tanaman</h6>
                        </div>
                        <span class="badge bg-light text-dark border">Data aktual</span>
                    </div>
                    <div style="height: 220px;">
                        @if (count($chartMinggu))
                            <canvas id="growthChart"></canvas>
                        @else
                            <div class="h-100 d-flex align-items-center justify-content-center text-muted text-center">
                                Belum ada catatan pertumbuhan tersimpan.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- KOMODITAS TERDAFTAR -->
                <div class="card card-custom p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted fw-bold">KOMODITAS & LAHAN</small>
                            <h6 class="fw-bold mb-0">Populasi Tanaman Terdaftar</h6>
                        </div>
                        <span class="badge bg-light text-dark border">{{ number_format($totalTanaman, 0, ',', '.') }} tanaman</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-7">
                            @forelse ($tanamanSummary as $tanaman)
                                <div class="p-2 border rounded-3 mb-2 bg-light">
                                    <div class="d-flex justify-content-between gap-2">
                                        <span class="fw-bold">{{ $tanaman['nama'] }}</span>
                                        <span class="fw-bold text-success text-nowrap">{{ number_format($tanaman['populasi'], 0, ',', '.') }}</span>
                                    </div>
                                    <small class="text-muted">{{ $tanaman['lokasi'] ?: 'Lokasi belum dicatat' }}</small>
                                </div>
                            @empty
                                <div class="h-100 d-flex align-items-center justify-content-center text-muted text-center p-3">
                                    Belum ada data tanaman. Data akan tampil setelah tanaman dicatat.
                                </div>
                            @endforelse
                        </div>

                        <div class="col-md-5">
                            <div class="border rounded-3 bg-light p-3 h-100">
                                <h6 class="fw-bold">Perlu Perhatian</h6>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Tanaman</span>
                                    <strong>{{ $tanamanPerluPerhatian }}</strong>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="text-muted">Lahan</span>
                                    <strong>{{ $lahanPerluPerhatian }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TELEMETRI LINGKUNGAN -->
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted fw-bold">JARINGAN SENSOR NIRKABEL</small>
                            <h6 class="fw-bold mb-0">Telemetri Lingkungan & Sensor IoT</h6>
                        </div>
                        <span class="text-muted fw-bold" style="font-size: 0.75rem;">
                            {{ $sensorTerakhir ? 'Data terakhir ' . $sensorTerakhir : 'Belum ada data sensor' }}
                        </span>
                    </div>

                    <div class="row g-2">
                        <div class="col-3">
                            <div class="p-2 border rounded-3 bg-light text-center">
                                <small class="text-muted d-block text-start">Kelembaban Tanah</small>
                                <h4 class="fw-bold text-start mb-0">{{ $sensorTanah !== null ? number_format((float) $sensorTanah, 1, ',', '.') : '—' }}<small class="fs-6">%</small></h4>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 border rounded-3 bg-light text-center">
                                <small class="text-muted d-block text-start">Suhu Udara</small>
                                <h4 class="fw-bold text-start mb-0">{{ $sensorSuhu !== null ? number_format((float) $sensorSuhu, 1, ',', '.') : '—' }}<small class="fs-6">°C</small></h4>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 border rounded-3 bg-light text-center">
                                <small class="text-muted d-block text-start">Intensitas Cahaya</small>
                                <h4 class="fw-bold text-start mb-0">{{ $sensorCahaya !== null ? number_format((float) $sensorCahaya, 0, ',', '.') : '—' }}<small class="fs-6">lux</small></h4>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 border rounded-3 bg-light text-center">
                                <small class="text-muted d-block text-start">Tingkat Keasaman</small>
                                <h4 class="fw-bold text-start mb-0">{{ $sensorPh !== null ? number_format((float) $sensorPh, 1, ',', '.') : '—' }}<small class="fs-6">pH</small></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-lg-4">
                <!-- TUGAS HARI INI -->
                <div class="card card-custom p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0"><i class="fa-solid fa-list-check me-1 text-success"></i> Tugas Hari Ini</h6>
                        <span class="badge bg-light text-dark border">Terjadwal</span>
                    </div>

                    @isset($tugasHariIni)
                        @forelse($tugasHariIni as $tugas)
                        <div class="p-2 border rounded-3 mb-2 bg-light d-flex justify-content-between align-items-center task-item">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold" style="font-size: 0.8rem;">{{ $tugas['judul'] ?? 'Tugas' }}</span>
                                    @php
                                        $tugasStatus = $tugas['status'] ?? 'Status';
                                        $tugasStatusClass = ($tugas['selesai'] ?? false) || $tugasStatus === 'Selesai'
                                            ? 'badge-soft-success'
                                            : (in_array($tugasStatus, ['Menunggu', 'Belum Mulai'], true) ? 'badge-soft-warning' : 'badge-soft-success');
                                    @endphp
                                    <span class="badge {{ $tugasStatusClass }}" style="font-size: 0.6rem;">{{ $tugasStatus }}</span>
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem;"><i class="fa-regular fa-clock me-1"></i> {{ $tugas['waktu'] ?? '-' }}</small>
                            </div>
                            <input type="checkbox" class="form-check-input task-checkbox" data-id="{{ $tugas['id'] ?? '' }}" {{ isset($tugas['selesai']) && $tugas['selesai'] ? 'checked' : '' }}>
                        </div>
                        @empty
                        <div class="text-center text-muted py-3" style="font-size: 0.8rem;">
                            Tidak ada tugas yang cocok dengan pencarian.
                        </div>
                        @endforelse
                    @endisset
                </div>

                <!-- AKTIVITAS TERBARU -->
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0"><i class="fa-solid fa-bolt me-1 text-warning"></i> Aktivitas Terbaru</h6>
                    </div>

                    @isset($activityFeed)
                        @forelse($activityFeed as $notif)
                        <div class="d-flex gap-2 mb-3">
                            <div class="icon-box bg-{{ $notif['tipe'] ?? 'secondary' }}-subtle text-{{ $notif['tipe'] ?? 'secondary' }} flex-shrink-0" style="width:28px; height:28px; font-size:0.8rem;">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <strong style="font-size: 0.75rem;">{{ $notif['judul'] ?? 'Aktivitas' }}</strong>
                                    <small class="text-muted" style="font-size: 0.65rem;">{{ $notif['waktu'] ?? '' }}</small>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 0.7rem;">{{ $notif['pesan'] ?? '' }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-3" style="font-size: 0.8rem;">
                            Tidak ada aktivitas ditemukan.
                        </div>
                        @endforelse
                    @endisset
                </div>
            </div>
        </div>
    </main>

    <!-- BOOTSTRAP JS & INTERACTIVE SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const growthRows = @json($chartMinggu);
        const growthCanvas = document.getElementById('growthChart');

        if (growthCanvas && growthRows.length > 0) {
            new Chart(growthCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: growthRows.map(item => item.day),
                    datasets: [{
                        label: 'Aktual',
                        data: growthRows.map(item => item.actual),
                        borderColor: '#1b4332',
                        backgroundColor: 'rgba(27, 67, 50, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    }, {
                        label: 'Target',
                        data: growthRows.map(item => item.target),
                        borderColor: '#a3b18a',
                        borderDash: [5, 5],
                        fill: false,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: true } },
                    scales: { y: { grid: { borderDash: [2, 4] } }, x: { grid: { display: false } } }
                }
            });
        }

        const taskCheckboxes = document.querySelectorAll('.task-checkbox');
        taskCheckboxes.forEach(chk => {
            const taskItem = chk.closest('.task-item');
            const titleSpan = taskItem.querySelector('span.fw-bold');

            const updateTaskStyle = (isChecked) => {
                if (isChecked) {
                    titleSpan.style.textDecoration = 'line-through';
                    titleSpan.style.opacity = '0.6';
                } else {
                    titleSpan.style.textDecoration = 'none';
                    titleSpan.style.opacity = '1';
                }
            };

            updateTaskStyle(chk.checked);

            chk.addEventListener('change', function() {
                updateTaskStyle(this.checked);

                const taskId = this.getAttribute('data-id');
                if (!taskId) return;

                const status = this.checked ? 'selesai' : 'pending';

                fetch(`/dashboard/tugas/${taskId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                })
                .catch(error => {
                    console.error('Terjadi kesalahan saat memperbarui tugas:', error);
                });
            });
        });

        document.getElementById('searchInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    </script>
</body>

</html>