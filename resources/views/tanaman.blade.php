<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tanaman & Varietas - SmartFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

        .icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .plant-card-img {
            position: relative;
            height: 140px;
            border-radius: 12px 12px 0 0;
            overflow: hidden;
        }

        .plant-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .plant-id-tag {
            position: absolute;
            bottom: 8px;
            left: 8px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.65rem;
            font-family: monospace;
        }

        .plant-status-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 0.65rem;
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
        <!-- NOTIFIKASI FLASH MESSAGE -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 py-2 mb-3" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- TOP NAVBAR -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <form action="{{ route('tanaman.index') }}" method="GET" class="input-group" style="max-width: 400px;">
                <button type="submit" class="input-group-text bg-white border-end-0 rounded-start-3 text-muted border-0 bg-transparent">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control border-start-0 bg-white rounded-end-3 shadow-none" placeholder="Cari lahan, tanaman, sensor...">
            </form>

            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-success btn-sm rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#modalCatatData">
                    <i class="fa-solid fa-plus me-1"></i> Catat Data
                </button>

                @include('layouts.notification-dropdown')

                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-success fw-bold text-uppercase"><i class="fa-solid fa-shield-halved me-1"></i> INVENTARIS AGRONOMI</small>
                <h3 class="fw-bold text-dark mb-0">Daftar Tanaman & Varietas</h3>
                <p class="text-muted small mb-0">Kelola dan pantau seluruh siklus hidup komoditas tanaman di setiap lahan, riwayat HST, dan indikator agronomis presisi.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tanaman.export') }}" class="btn btn-white btn-sm border rounded-3"><i class="fa-solid fa-file-csv me-1"></i> Ekspor Data CSV</a>
                <button type="button" class="btn btn-success btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahTanaman">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Tanaman
                </button>
            </div>
        </div>

        <!-- TOP METRICS -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">TOTAL POPULASI</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-plant-wilt"></i></div>
                    </div>
                    <h2 class="fw-bold mb-1">10,800</h2>
                    <span class="badge badge-soft-success w-auto"><i class="fa-solid fa-arrow-trend-up"></i> +8% siklus ini</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">VARIETAS SEHAT</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-shield-heart"></i></div>
                    </div>
                    <h2 class="fw-bold mb-1">84.2%</h2>
                    <small class="text-muted">8 dari 12 zona optimal</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">PERHATIAN KHUSUS</small>
                        <div class="icon-box bg-danger-subtle text-danger"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                    <h2 class="fw-bold text-danger mb-1">2 <span class="fs-5 fw-normal text-dark">Varietas</span></h2>
                    <small class="text-danger fw-semibold">Hama & Defisit air</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">ESTIMASI PANEN</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-tractor"></i></div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h2 class="fw-bold mb-1">4.6</h2>
                        <span class="text-muted fw-bold">Ton</span>
                    </div>
                    <small class="text-muted">Periode Nov - Des 2026</small>
                </div>
            </div>
        </div>

        <!-- FILTER TOOLBAR -->
        <div class="card card-custom p-2 mb-4">
            <form action="{{ route('tanaman.index') }}" method="GET" class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <input type="hidden" name="page" value="{{ $page ?? 1 }}">
                <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 600px;">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control border-start-0" placeholder="Cari nama varietas, sektor...">
                    </div>
                    <select name="lahan" class="form-select form-select-sm" style="width: 180px;" onchange="this.form.submit()">
                        <option value="">Semua Lahan & Sektor</option>
                        <option value="Sektor A-1" {{ ($filterLahan ?? '') == 'Sektor A-1' ? 'selected' : '' }}>Sektor A-1</option>
                        <option value="Greenhouse B" {{ ($filterLahan ?? '') == 'Greenhouse B' ? 'selected' : '' }}>Greenhouse B</option>
                        <option value="Sektor C-3" {{ ($filterLahan ?? '') == 'Sektor C-3' ? 'selected' : '' }}>Sektor C-3</option>
                    </select>
                    <select name="status" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
                        <option value="">Status: Semua</option>
                        <option value="Sehat" {{ ($filterStatus ?? '') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="Hama" {{ ($filterStatus ?? '') == 'Hama' ? 'selected' : '' }}>Hama</option>
                        <option value="Butuh Air" {{ ($filterStatus ?? '') == 'Butuh Air' ? 'selected' : '' }}>Butuh Air</option>
                    </select>
                </div>

                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" id="btnGridView" class="btn btn-outline-secondary active" onclick="switchView('grid')"><i class="fa-solid fa-border-all me-1"></i> Grid</button>
                    <button type="button" id="btnTableView" class="btn btn-outline-secondary" onclick="switchView('table')"><i class="fa-solid fa-list me-1"></i> Tabel</button>
                </div>
            </form>
        </div>

        <!-- CONTAINER GRID VIEW -->
        <div id="containerGrid" class="row g-3 mb-4">
            @isset($tanamanList)
                @forelse($tanamanList as $item)
                    <div class="col-md-3">
                        <div class="card card-custom overflow-hidden h-100">
                            <div class="plant-card-img">
                                <img src="{{ $item['image'] }}" alt="{{ $item['nama'] }}">
                                <span class="badge {{ $item['status_badge'] ?? 'badge-soft-success' }} plant-status-badge">
                                    <i class="fa-solid fa-circle" style="font-size: 6px;"></i> {{ $item['status'] }}
                                </span>
                                <div class="plant-id-tag">ID: {{ $item['id_tanaman'] }}</div>
                            </div>
                            <div class="p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $item['nama'] }}</h6>
                                    <small class="text-muted fst-italic d-block mb-3" style="font-size: 0.75rem;">{{ $item['latin'] }}</small>

                                    <div class="row g-2 text-center mb-2" style="font-size: 0.75rem;">
                                        <div class="col-6">
                                            <div class="bg-light p-2 rounded-2"><span class="text-muted d-block" style="font-size: 0.65rem;">Umur HST</span><strong>{{ $item['umur'] }} Hari</strong></div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-light p-2 rounded-2"><span class="text-muted d-block" style="font-size: 0.65rem;">Populasi</span><strong>{{ number_format($item['populasi']) }}</strong></div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-light p-2 rounded-2"><span class="text-muted d-block" style="font-size: 0.65rem;">Lokasi</span><strong>{{ $item['lokasi'] }}</strong></div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-light p-2 rounded-2"><span class="text-muted d-block" style="font-size: 0.65rem;">Est. Panen</span><strong>{{ $item['est_panen'] }}</strong></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TOMBOL AKSI: DETAIL, EDIT, HAPUS -->
                                <div class="d-flex gap-1 mt-3">
                                    <button class="btn btn-success btn-sm w-100 rounded-2" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $loop->index }}">Detail</button>
                                    <button class="btn btn-light btn-sm rounded-2 text-muted" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $loop->index }}"><i class="fa-solid fa-pen"></i></button>
                                    <form action="{{ route('tanaman.destroy', $item['id_tanaman']) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data tanaman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm rounded-2 text-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL: DETAIL TANAMAN -->
                    <div class="modal fade" id="modalDetail{{ $loop->index }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header bg-success text-white rounded-top-4">
                                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-seedling me-2"></i>Detail - {{ $item['nama'] }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 text-start">
                                    <div class="text-center mb-3">
                                        <img src="{{ $item['image'] }}" class="rounded-4 img-fluid" style="height: 160px; width: 100%; object-fit: cover;">
                                    </div>
                                    <p class="mb-1"><strong>ID Tanaman:</strong> <code>{{ $item['id_tanaman'] }}</code></p>
                                    <p class="mb-1"><strong>Nama Latin:</strong> <span class="fst-italic">{{ $item['latin'] }}</span></p>
                                    <p class="mb-1"><strong>Lokasi Sektor:</strong> {{ $item['lokasi'] }}</p>
                                    <p class="mb-1"><strong>Umur Tanaman:</strong> {{ $item['umur'] }} Hari (HST)</p>
                                    <p class="mb-1"><strong>Total Populasi:</strong> {{ number_format($item['populasi']) }} batang</p>
                                    <p class="mb-1"><strong>Estimasi Panen:</strong> {{ $item['est_panen'] }}</p>
                                    <p class="mb-0"><strong>Status Kesehatan:</strong> <span class="badge {{ $item['status_badge'] }}">{{ $item['status'] }}</span></p>
                                </div>
                                <div class="modal-footer bg-light rounded-bottom-4">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL: EDIT TANAMAN -->
                    <div class="modal fade" id="modalEdit{{ $loop->index }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header bg-warning text-dark rounded-top-4">
                                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Tanaman: {{ $item['nama'] }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('tanaman.update', $item['id_tanaman']) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-4 text-start">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Nama Varietas</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $item['nama'] }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Nama Latin</label>
                                            <input type="text" name="latin" class="form-control" value="{{ $item['latin'] }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small">Ganti Foto (Opsional)</label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-bold small">Populasi</label>
                                                <input type="number" name="populasi" class="form-control" value="{{ $item['populasi'] }}" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-bold small">Lokasi Sektor</label>
                                                <select name="lokasi" class="form-select">
                                                    <option value="Sektor A-1" {{ $item['lokasi'] == 'Sektor A-1' ? 'selected' : '' }}>Sektor A-1</option>
                                                    <option value="Greenhouse B" {{ $item['lokasi'] == 'Greenhouse B' ? 'selected' : '' }}>Greenhouse B</option>
                                                    <option value="Sektor C-3" {{ $item['lokasi'] == 'Sektor C-3' ? 'selected' : '' }}>Sektor C-3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light rounded-bottom-4">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning btn-sm">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Tidak ada data tanaman ditemukan.</p>
                    </div>
                @endforelse
            @endisset
        </div>

        <!-- CONTAINER TABLE VIEW -->
        <div id="containerTable" class="card card-custom mb-4 p-3 d-none">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Varietas</th>
                            <th>Nama Latin</th>
                            <th>Umur</th>
                            <th>Populasi</th>
                            <th>Lokasi</th>
                            <th>Est. Panen</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($tanamanList)
                            @foreach($tanamanList as $item)
                                <tr>
                                    <td><code>{{ $item['id_tanaman'] }}</code></td>
                                    <td class="fw-bold">{{ $item['nama'] }}</td>
                                    <td class="fst-italic text-muted small">{{ $item['latin'] }}</td>
                                    <td>{{ $item['umur'] }} Hari</td>
                                    <td>{{ number_format($item['populasi']) }}</td>
                                    <td>{{ $item['lokasi'] }}</td>
                                    <td>{{ $item['est_panen'] }}</td>
                                    <td><span class="badge {{ $item['status_badge'] }}">{{ $item['status'] }}</span></td>
                                    <td>
                                        <form action="{{ route('tanaman.destroy', $item['id_tanaman']) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data {{ $item['nama'] }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BOTTOM BANNER -->
        <div class="card card-custom p-4 mb-4 bg-light border">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.5rem;">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Tambahkan Varietas atau Bibit Baru</h5>
                        <p class="text-muted small mb-0">Konfigurasi batch benih, jadwal irigasi otomatis, dan parameter nutrisi untuk lahan aktif.</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <form action="{{ route('tanaman.import') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm rounded-3"><i class="fa-solid fa-file-import me-1"></i> Impor Template Benih</button>
                    </form>
                    <button type="button" class="btn btn-success btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahTanaman">
                        <i class="fa-solid fa-plus me-1"></i> Daftarkan Tanaman
                    </button>
                </div>
            </div>
        </div>

        <!-- PAGINATION INTERAKTIF -->
        <div class="d-flex justify-content-between align-items-center pb-4">
            <small class="text-muted">Menampilkan halaman {{ $page ?? 1 }} dari data tanaman aktif</small>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item {{ ($page ?? 1) == 1 ? 'active' : '' }}">
                        <a class="page-link {{ ($page ?? 1) == 1 ? 'bg-success border-success text-white' : 'text-dark' }}" href="{{ route('tanaman.index', ['page' => 1]) }}">1</a>
                    </li>
                    <li class="page-item {{ ($page ?? 1) == 2 ? 'active' : '' }}">
                        <a class="page-link {{ ($page ?? 1) == 2 ? 'bg-success border-success text-white' : 'text-dark' }}" href="{{ route('tanaman.index', ['page' => 2]) }}">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link text-dark" href="{{ route('tanaman.index', ['page' => 2]) }}"><i class="fa-solid fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </main>

    <!-- MODAL: TAMBAH / DAFTARKAN TANAMAN -->
    <div class="modal fade" id="modalTambahTanaman" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-success text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-seedling me-2"></i>Daftarkan Tanaman Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tanaman.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Varietas</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: Cabai Keriting" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Latin / Spesies</label>
                            <input type="text" name="latin" class="form-control" placeholder="Contoh: Capsicum annuum">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Pilih Foto Tanaman</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold small">Jumlah Populasi</label>
                                <input type="number" name="populasi" class="form-control" placeholder="2500" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small">Sektor Lahan</label>
                                <select name="lokasi" class="form-select">
                                    <option value="Sektor A-1">Sektor A-1</option>
                                    <option value="Greenhouse B">Greenhouse B</option>
                                    <option value="Sektor C-3">Sektor C-3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-sm">Simpan Tanaman</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: CATAT DATA -->
    <div class="modal fade" id="modalCatatData" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-success text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-clipboard-list me-2"></i>Catat Data Harian Agronomi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tanaman.catatan') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Pilih Lahan / Sektor</label>
                            <select name="lahan" class="form-select" required>
                                <option value="Sektor A-1">Sektor A-1</option>
                                <option value="Greenhouse B">Greenhouse B</option>
                                <option value="Sektor C-3">Sektor C-3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Catatan Pengamatan Kondisi</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Tuliskan perkembangan harian, kondisi daun, dll..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success btn-sm">Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT JS TOGGLE VIEW -->
    <script>
        function switchView(viewType) {
            const gridContainer = document.getElementById('containerGrid');
            const tableContainer = document.getElementById('containerTable');
            const btnGrid = document.getElementById('btnGridView');
            const btnTable = document.getElementById('btnTableView');

            if (viewType === 'grid') {
                gridContainer.classList.remove('d-none');
                tableContainer.classList.add('d-none');
                btnGrid.classList.add('active');
                btnTable.classList.remove('active');
            } else {
                gridContainer.classList.add('d-none');
                tableContainer.classList.remove('d-none');
                btnTable.classList.add('active');
                btnGrid.classList.remove('active');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>