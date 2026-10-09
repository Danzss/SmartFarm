<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aktivitas & Log Kebun - SmartFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Timeline Items */
        .timeline-item {
            position: relative;
            padding-left: 20px;
            margin-bottom: 16px;
            border-left: 2px solid #e9ecef;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 4px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--primary-green);
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
                    <a href="{{ route('riwayat.index') }}" class="nav-link {{ request()->routeIs('riwayat.*') || request()->routeIs('log-kebun.*') ? 'active' : '' }}">
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
                <input type="text" class="form-control border-start-0 bg-white rounded-end-3" placeholder="Cari data log, kueri, sensor...">
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-success btn-sm rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#modalCatatanAktivitas"><i class="fa-solid fa-plus me-1"></i> Catat Data</button>
                @include('layouts.notification-dropdown')
                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-success fw-bold text-uppercase"><i class="fa-solid fa-clock-rotate-left me-1"></i> LOG OPERASIONAL & AUDIT KEGIATAN</small>
                <h3 class="fw-bold text-dark mb-1">Riwayat Aktivitas & Log Kebun</h3>
                <p class="text-muted small mb-0">Rekam jejak seluruh kegiatan agrikultur, irigasi otomatis, intervensi nutrisi, dan catatan personel lapangan secara terorganisir dan terperinci.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('riwayat.export') }}" class="btn btn-outline-secondary btn-sm rounded-3 text-decoration-none"><i class="fa-solid fa-download me-1"></i> Unduh Log CSV</a>
                <button type="button" class="btn btn-success btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalCatatanAktivitas"><i class="fa-solid fa-plus me-1"></i> Buat Catatan Manual</button>
            </div>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-list-check"></i></div>
                        <span class="badge bg-light text-dark border rounded-pill" style="font-size: 0.65rem;">Semua waktu</span>
                    </div>
                    <small class="text-muted fw-bold d-block" style="font-size: 0.65rem;">TOTAL AKTIVITAS BULAN INI</small>
                    <h3 class="fw-bold mb-1">{{ $totalActivities }} <span class="fs-6 fw-normal text-muted">Aktivitas</span></h3>
                    <small class="text-muted" style="font-size: 0.65rem;">Catatan dari modul operasional</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-droplet"></i></div>
                        <span class="badge bg-light text-dark border rounded-pill" style="font-size: 0.65rem;">Tercatat</span>
                    </div>
                    <small class="text-muted fw-bold d-block" style="font-size: 0.65rem;">KEGIATAN IRIGASI & IoT</small>
                    <h3 class="fw-bold mb-1">{{ $activityCounts->get('Irigasi', 0) }} <span class="fs-6 fw-normal text-muted">Aktivitas</span></h3>
                    <small class="text-muted" style="font-size: 0.65rem;">Catatan pengaturan katup irigasi</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-vial"></i></div>
                        <span class="badge bg-light text-dark border rounded-pill" style="font-size: 0.65rem;">Tercatat</span>
                    </div>
                    <small class="text-muted fw-bold d-block" style="font-size: 0.65rem;">INTERVENSI KIMIA & PUPUK</small>
                    <h3 class="fw-bold mb-1">{{ $activityCounts->get('Hama/Penyakit', 0) }} <span class="fs-6 fw-normal text-muted">Laporan</span></h3>
                    <small class="text-muted" style="font-size: 0.65rem;">Laporan gejala yang dicatat</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-box bg-warning-subtle text-warning"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <span class="badge bg-light text-dark border rounded-pill" style="font-size: 0.65rem;">Dari log</span>
                    </div>
                    <small class="text-muted fw-bold d-block" style="font-size: 0.65rem;">ANOMALI TERDETEKSI / INTERVENSI</small>
                    <h3 class="fw-bold mb-1">{{ $activityCounts->get('Perawatan', 0) + $activityCounts->get('Hama/Penyakit', 0) }} <span class="fs-6 fw-normal text-muted">Perlu ditinjau</span></h3>
                    <small class="text-muted" style="font-size: 0.65rem;">Perawatan dan laporan gejala</small>
                </div>
            </div>
        </div>

        <!-- SEARCH & FILTER BAR -->
        <form action="{{ route('riwayat.index') }}" method="GET" class="card card-custom p-3 mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-7">
                    <label for="activitySearch" class="visually-hidden">Cari aktivitas</label>
                    <input id="activitySearch" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Cari aktivitas, detail, lokasi, petugas...">
                </div>
                <div class="col-md-3">
                    <label for="activityCategory" class="visually-hidden">Kategori aktivitas</label>
                    <select id="activityCategory" name="kategori" class="form-select form-select-sm">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected($kategori === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-success btn-sm flex-grow-1"><i class="fa-solid fa-filter me-1"></i>Filter</button>
                    <a href="{{ route('riwayat.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
            </div>
        </form>

        <!-- MAIN LAYOUT: LOG TABLE & RIGHT SIDEBAR -->
        <div class="row g-3">
            <!-- LOG TABLE -->
            <div class="col-md-8">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="fw-bold text-success" style="font-size: 0.75rem;"><i class="fa-solid fa-clock-rotate-left me-1"></i> Aktivitas Tersimpan</small>
                        <div class="text-muted fs-6"><i class="fa-solid fa-expand"></i></div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-3" style="font-size: 0.75rem;">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Waktu & Tanggal</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Komoditas & Lahan</th>
                                    <th>Pelaksana / Sistem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity['tanggal'] }}</td>
                                        <td><span class="badge bg-success-subtle text-success border rounded-pill">{{ $activity['kategori'] }}</span></td>
                                        <td>
                                            <div class="fw-bold">{{ $activity['judul'] }}</div>
                                            <small class="text-muted">{{ $activity['pesan'] }}</small>
                                        </td>
                                        <td>{{ $activity['lokasi'] ?: '-' }} · {{ $activity['petugas'] }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-5">Belum ada aktivitas tercatat. Aktivitas akan muncul setelah data disimpan di modul.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pt-2">
                        <small class="text-muted">Menampilkan {{ count($activities) }} dari {{ $totalActivities }} aktivitas.</small>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDEBAR: INTEGRATION LOGS & BATCH INFO -->
            <div class="col-md-4">
                <div class="d-flex flex-column gap-3">

                    <div class="card card-custom p-3">
                        <small class="fw-bold text-success text-uppercase d-block mb-3" style="font-size: 0.65rem;"><i class="fa-solid fa-layer-group me-1"></i> AKTIVITAS PER MODUL</small>
                        @forelse ($activityCounts as $category => $count)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-dark small">{{ $category }}</span>
                                <span class="badge bg-light text-dark border">{{ $count }}</span>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Ringkasan akan tampil setelah aktivitas dicatat.</p>
                        @endforelse
                    </div>

                    <div class="card card-custom p-3">
                        <small class="fw-bold text-secondary text-uppercase d-block mb-2" style="font-size: 0.65rem;">AKTIVITAS TERBARU</small>
                        @forelse (array_slice($activities, 0, 4) as $activity)
                            <div class="border-bottom py-2">
                                <strong class="d-block small">{{ $activity['judul'] }}</strong>
                                <small class="text-muted">{{ $activity['tanggal'] }} · {{ $activity['petugas'] }}</small>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Belum ada aktivitas terbaru.</p>
                        @endforelse
                    </div>

                    <div class="card card-custom p-3 bg-light border">
                        <small class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 0.65rem;">PENYIMPANAN AKTIVITAS</small>
                        <strong class="text-dark">{{ $totalActivities }} event</strong>
                        <small class="text-muted d-block">Log dibagikan dengan aktivitas modul di sesi ini.</small>
                    </div>

                </div>
            </div>
        </div>

    </main>

    <div class="modal fade" id="modalCatatanAktivitas" tabindex="-1" aria-labelledby="catatanAktivitasTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('riwayat.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="modal-title h5 fw-bold" id="catatanAktivitasTitle">Catatan aktivitas manual</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="activityTitle" class="form-label">Judul aktivitas</label>
                            <input id="activityTitle" name="judul" class="form-control" required maxlength="160">
                        </div>
                        <div class="mb-3">
                            <label for="activityCategory" class="form-label">Kategori</label>
                            <input id="activityCategory" name="kategori" class="form-control" value="Operasional" required maxlength="80">
                        </div>
                        <div class="mb-3">
                            <label for="activityDetail" class="form-label">Detail</label>
                            <textarea id="activityDetail" name="pesan" class="form-control" rows="3" required maxlength="1000"></textarea>
                        </div>
                        <div>
                            <label for="activityLocation" class="form-label">Lahan / sektor</label>
                            <input id="activityLocation" name="lokasi" class="form-control" maxlength="120">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan catatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>