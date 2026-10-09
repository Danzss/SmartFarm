<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tanaman & Varietas - SmartFarm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        .plant-card img {
            height: 150px;
            object-fit: cover;
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
            <form action="{{ route('tanaman.index') }}" method="GET" class="input-group" style="max-width: 400px;">
                <button type="submit" class="input-group-text bg-white border-end-0 rounded-start-3 text-muted border-0 bg-transparent" style="cursor: pointer;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 bg-white rounded-end-3 shadow-none" placeholder="Cari lahan, tanaman, sensor...">
            </form>

            <div class="d-flex align-items-center gap-3">
                @include('layouts.notification-dropdown')

                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-success fw-bold text-uppercase"><i class="fa-solid fa-seedling me-1"></i> Inventaris Agronomi</small>
                <h3 class="fw-bold text-dark mb-0">Daftar Tanaman & Varietas</h3>
                <p class="text-muted small mb-0">Kelola dan pantau seluruh siklus hidup komoditas tanaman di setiap lahan, riwayat HST, dan indikator agronomis presisi.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tanaman.export') }}" class="btn btn-white btn-sm border rounded-3 bg-white">
                    <i class="fa-solid fa-download me-1"></i> Ekspor Data CSV
                </a>
                <a href="{{ route('tanaman.create') }}" class="btn btn-success btn-sm rounded-3">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Tanaman
                </a>
            </div>
        </div>

        <!-- METRIC CARDS (TOP 4) -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">TOTAL POPULASI</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-plant-wilt"></i></div>
                    </div>
                    <h2 class="fw-bold mb-1">10,800</h2>
                    <span class="badge badge-soft-success w-auto"><i class="fa-solid fa-arrow-trend-up"></i> +8% siklus ini</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">VARIETAS SEHAT</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-shield-halved"></i></div>
                    </div>
                    <h2 class="fw-bold mb-1 text-success">84.2%</h2>
                    <small class="text-muted">8 dari 12 zona optimal</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">PERHATIAN KHUSUS</small>
                        <div class="icon-box bg-danger-subtle text-danger"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    </div>
                    <h2 class="fw-bold text-danger mb-1">2 <span class="fs-6 text-dark fw-normal">Varietas</span></h2>
                    <small class="text-muted">Hama & Defisit air</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">ESTIMASI PANEN</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-tractor"></i></div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1">
                        <h2 class="fw-bold mb-1">4.6</h2>
                        <span class="text-muted fw-bold">Ton</span>
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">Periode Nov - Des 2023</small>
                </div>
            </div>
        </div>

        <!-- FILTER & VIEW CONTROLS (Fungsional Form Filter & Switcher Grid/Tabel) -->
        <form action="{{ route('tanaman.index') }}" method="GET" id="filterForm" class="card card-custom p-3 mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0" placeholder="Cari nama varietas, sektor, ID tanaman, ...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="lahan" class="form-select form-select-sm bg-light text-muted" onchange="this.form.submit()">
                        <option value="">Semua Lahan & Sektor</option>
                        <option value="Sektor A-1" {{ request('lahan') == 'Sektor A-1' ? 'selected' : '' }}>Sektor A-1</option>
                        <option value="Greenhouse B" {{ request('lahan') == 'Greenhouse B' ? 'selected' : '' }}>Greenhouse B</option>
                        <option value="Sektor C-3" {{ request('lahan') == 'Sektor C-3' ? 'selected' : '' }}>Sektor C-3</option>
                        <option value="Selatan Blok 3" {{ request('lahan') == 'Selatan Blok 3' ? 'selected' : '' }}>Selatan Blok 3</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm bg-light text-muted" onchange="this.form.submit()">
                        <option value="">Status: Semua</option>
                        <option value="Sehat" {{ request('status') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="Hama" {{ request('status') == 'Hama' ? 'selected' : '' }}>Hama</option>
                        <option value="Butuh Air" {{ request('status') == 'Butuh Air' ? 'selected' : '' }}>Butuh Air</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-success active" id="btnGridView"><i class="fa-solid fa-table-cells me-1"></i> Grid</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnTableView"><i class="fa-solid fa-list me-1"></i> Tabel</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- VIEW CONTAINER: GRID VIEW -->
        <div id="gridViewContainer">
            <div class="row g-3 mb-4">
                <!-- Data Looping dari Backend -->
                @forelse($tanamanList ?? [] as $item)
                <div class="col-md-3">
                    <div class="card card-custom plant-card h-100 overflow-hidden position-relative">
                        <div class="position-relative">
                            <img src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?auto=format&fit=crop&w=500&q=80' }}" class="w-100" alt="Tanaman">
                            <span class="badge {{ $item['status_badge'] ?? 'bg-success' }} position-absolute top-0 end-0 m-2">
                                <i class="fa-solid fa-circle text-white me-1" style="font-size: 6px;"></i> {{ $item['status'] ?? 'Sehat' }}
                            </span>
                            <span class="badge bg-dark bg-opacity-75 position-absolute bottom-0 start-0 m-2 text-white" style="font-size: 0.65rem;">ID: {{ $item['id_tanaman'] ?? '-' }}</span>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <h5 class="fw-bold mb-0">{{ $item['nama'] ?? 'Tanaman' }}</h5>
                                <small class="text-muted fst-italic">{{ $item['latin'] ?? '-' }}</small>
                                
                                <div class="row g-1 mt-2 text-center bg-light rounded-3 p-2">
                                    <div class="col-6 border-end">
                                        <small class="text-muted" style="font-size: 0.65rem;">Umur HST</small>
                                        <strong class="d-block" style="font-size: 0.85rem;">{{ $item['umur'] ?? 0 }} Hari</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted" style="font-size: 0.65rem;">Populasi</small>
                                        <strong class="d-block" style="font-size: 0.85rem;">{{ $item['populasi'] ?? 0 }} Batang</strong>
                                    </div>
                                    <div class="col-6 border-end pt-1 mt-1 border-top">
                                        <small class="text-muted" style="font-size: 0.65rem;">Lokasi</small>
                                        <strong class="d-block" style="font-size: 0.8rem;">{{ $item['lokasi'] ?? '-' }}</strong>
                                    </div>
                                    <div class="col-6 pt-1 mt-1 border-top">
                                        <small class="text-muted" style="font-size: 0.65rem;">Est. Panen</small>
                                        <strong class="d-block text-success" style="font-size: 0.75rem;">{{ $item['est_panen'] ?? '-' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top">
                                <a href="{{ route('tanaman.show', $item['id'] ?? 1) }}" class="btn btn-success btn-sm w-100 rounded-3 me-2 fw-bold" style="font-size: 0.75rem;">Lihat Detail</a>
                                <a href="{{ route('tanaman.edit', $item['id'] ?? 1) }}" class="btn btn-outline-secondary btn-sm border-0"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('tanaman.destroy', $item['id'] ?? 1) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Data Statis Cadangan Sesuai Gambar UI -->
                <div class="col-md-3">
                    <div class="card card-custom plant-card h-100 overflow-hidden position-relative">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?auto=format&fit=crop&w=500&q=80" class="w-100" alt="Tomat">
                            <span class="badge bg-success position-absolute top-0 end-0 m-2"><i class="fa-solid fa-circle text-white me-1" style="font-size: 6px;"></i> Sehat</span>
                            <span class="badge bg-dark bg-opacity-75 position-absolute bottom-0 start-0 m-2 text-white" style="font-size: 0.65rem;">ID: TMT-2023-A1</span>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <h5 class="fw-bold mb-0">Tomat Beefsteak</h5>
                                <small class="text-muted fst-italic">Solanum lycopersicum</small>
                                <div class="row g-1 mt-2 text-center bg-light rounded-3 p-2">
                                    <div class="col-6 border-end"><small class="text-muted" style="font-size: 0.65rem;">Umur HST</small><strong class="d-block" style="font-size: 0.85rem;">45 Hari</strong></div>
                                    <div class="col-6"><small class="text-muted" style="font-size: 0.65rem;">Populasi</small><strong class="d-block" style="font-size: 0.85rem;">3,200 Batang</strong></div>
                                    <div class="col-6 border-end pt-1 mt-1 border-top"><small class="text-muted" style="font-size: 0.65rem;">Lokasi</small><strong class="d-block" style="font-size: 0.8rem;">Sektor A-1</strong></div>
                                    <div class="col-6 pt-1 mt-1 border-top"><small class="text-muted" style="font-size: 0.65rem;">Est. Panen</small><strong class="d-block text-success" style="font-size: 0.75rem;">15 Nov 2023</strong></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top">
                                <a href="#" class="btn btn-success btn-sm w-100 rounded-3 me-2 fw-bold" style="font-size: 0.75rem;">Lihat Detail</a>
                                <button class="btn btn-outline-secondary btn-sm border-0"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-outline-danger btn-sm border-0"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-custom plant-card h-100 overflow-hidden position-relative">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1622383563227-04401ab4e5ea?auto=format&fit=crop&w=500&q=80" class="w-100" alt="Selada">
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2"><i class="fa-solid fa-circle text-white me-1" style="font-size: 6px;"></i> Hama</span>
                            <span class="badge bg-dark bg-opacity-75 position-absolute bottom-0 start-0 m-2 text-white" style="font-size: 0.65rem;">ID: SLD-2023-B2</span>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <h5 class="fw-bold mb-0">Selada Romaine</h5>
                                <small class="text-muted fst-italic">Lactuca sativa</small>
                                <div class="row g-1 mt-2 text-center bg-light rounded-3 p-2">
                                    <div class="col-6 border-end"><small class="text-muted" style="font-size: 0.65rem;">Umur HST</small><strong class="d-block" style="font-size: 0.85rem;">18 Hari</strong></div>
                                    <div class="col-6"><small class="text-muted" style="font-size: 0.65rem;">Instalasi</small><strong class="d-block" style="font-size: 0.85rem;">1,500 Rak</strong></div>
                                    <div class="col-6 border-end pt-1 mt-1 border-top"><small class="text-muted" style="font-size: 0.65rem;">Lokasi</small><strong class="d-block" style="font-size: 0.8rem;">Greenhouse B</strong></div>
                                    <div class="col-6 pt-1 mt-1 border-top"><small class="text-muted" style="font-size: 0.65rem;">Siklus Hidro</small><strong class="d-block text-danger" style="font-size: 0.75rem;">Fase Remaja</strong></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top">
                                <a href="#" class="btn btn-dark btn-sm w-100 rounded-3 me-2 fw-bold" style="font-size: 0.75rem; background-color: #212529;">Detail</a>
                                <button class="btn btn-outline-secondary btn-sm border-0"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-outline-danger btn-sm border-0"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-custom plant-card h-100 overflow-hidden position-relative">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1563565375-f3fdfdbefa83?auto=format&fit=crop&w=500&q=80" class="w-100" alt="Paprika">
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2"><i class="fa-solid fa-circle text-dark me-1" style="font-size: 6px;"></i> Butuh Air</span>
                            <span class="badge bg-dark bg-opacity-75 position-absolute bottom-0 start-0 m-2 text-white" style="font-size: 0.65rem;">ID: PPK-2023-C3</span>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <h5 class="fw-bold mb-0">Paprika Kuning</h5>
                                <small class="text-muted fst-italic">Capsicum annuum</small>
                                <div class="row g-1 mt-2 text-center bg-light rounded-3 p-2">
                                    <div class="col-6 border-end"><small class="text-muted" style="font-size: 0.65rem;">Umur HST</small><strong class="d-block" style="font-size: 0.85rem;">60 Hari</strong></div>
                                    <div class="col-6"><small class="text-muted" style="font-size: 0.65rem;">Populasi</small><strong class="d-block" style="font-size: 0.85rem;">2,100 Batang</strong></div>
                                    <div class="col-6 border-end pt-1 mt-1 border-top"><small class="text-muted" style="font-size: 0.65rem;">Lokasi</small><strong class="d-block" style="font-size: 0.8rem;">Sektor C-3</strong></div>
                                    <div class="col-6 pt-1 mt-1 border-top"><small class="text-muted" style="font-size: 0.65rem;">Sensor Tanah</small><strong class="d-block text-danger" style="font-size: 0.75rem;">45% (Rendah)</strong></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top">
                                <a href="#" class="btn btn-dark btn-sm w-100 rounded-3 me-2 fw-bold" style="font-size: 0.75rem; background-color: #212529;">Detail</a>
                                <button class="btn btn-outline-secondary btn-sm border-0"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-outline-danger btn-sm border-0"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-custom plant-card h-100 overflow-hidden position-relative">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1588854337236-6889d631faa8?auto=format&fit=crop&w=500&q=80" class="w-100" alt="Cabai">
                            <span class="badge bg-success position-absolute top-0 end-0 m-2"><i class="fa-solid fa-circle text-white me-1" style="font-size: 6px;"></i> Sehat</span>
                            <span class="badge bg-dark bg-opacity-75 position-absolute bottom-0 start-0 m-2 text-white" style="font-size: 0.65rem;">ID: CBR-2023-B3</span>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <h5 class="fw-bold mb-0">Cabai Rawit Merah</h5>
                                <small class="text-muted fst-italic">Capsicum frutescens</small>
                                <div class="row g-1 mt-2 text-center bg-light rounded-3 p-2">
                                    <div class="col-6 border-end"><small class="text-muted" style="font-size: 0.65rem;">Umur HST</small><strong class="d-block" style="font-size: 0.85rem;">75 Hari</strong></div>
                                    <div class="col-6"><small class="text-muted" style="font-size: 0.65rem;">Populasi</small><strong class="d-block" style="font-size: 0.85rem;">4,000 Batang</strong></div>
                                    <div class="col-6 border-end pt-1 mt-1 border-top"><small class="text-muted" style="font-size: 0.65rem;">Lokasi</small><strong class="d-block" style="font-size: 0.8rem;">Selatan Blok 3</strong></div>
                                    <div class="col-6 pt-1 mt-1 border-top"><small class="text-muted" style="font-size: 0.65rem;">Kondisi</small><strong class="d-block text-success" style="font-size: 0.75rem;">Siap Panen</strong></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top">
                                <a href="#" class="btn btn-success btn-sm w-100 rounded-3 me-2 fw-bold" style="font-size: 0.75rem;">Detail</a>
                                <button class="btn btn-outline-secondary btn-sm border-0"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-outline-danger btn-sm border-0"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- VIEW CONTAINER: TABLE VIEW (Hidden by default) -->
        <div id="tableViewContainer" style="display: none;" class="card card-custom p-3 mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="table-light">
                        <tr>
                            <th>ID Tanaman</th>
                            <th>Varietas</th>
                            <th>Lokasi</th>
                            <th>Umur HST</th>
                            <th>Populasi</th>
                            <th>Status</th>
                            <th>Est. Panen</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-dark">TMT-2023-A1</span></td>
                            <td class="fw-bold">Tomat Beefsteak <br><small class="text-muted fw-normal fst-italic">Solanum lycopersicum</small></td>
                            <td>Sektor A-1</td>
                            <td>45 Hari</td>
                            <td>3,200 Batang</td>
                            <td><span class="badge bg-success">Sehat</span></td>
                            <td>15 Nov 2023</td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-success py-0 px-2">Detail</a>
                                <button class="btn btn-sm btn-outline-secondary py-0 px-1"><i class="fa-solid fa-pen"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-dark">SLD-2023-B2</span></td>
                            <td class="fw-bold">Selada Romaine <br><small class="text-muted fw-normal fst-italic">Lactuca sativa</small></td>
                            <td>Greenhouse B</td>
                            <td>18 Hari</td>
                            <td>1,500 Rak</td>
                            <td><span class="badge bg-danger">Hama</span></td>
                            <td>-</td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-dark py-0 px-2">Detail</a>
                                <button class="btn btn-sm btn-outline-secondary py-0 px-1"><i class="fa-solid fa-pen"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BOTTOM BANNER -->
        <div class="card card-custom p-4 mb-4 bg-white">
            <div class="row align-items-center">
                <div class="col-md-7 d-flex align-items-center gap-3">
                    <div class="icon-box bg-success text-white" style="width: 52px; height: 52px; font-size: 1.5rem;">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Tambahkan Varietas atau Bibit Baru</h5>
                        <p class="text-muted small mb-0">Konfigurasi batch benih, jadwal irigasi otomatis, dan parameter nutrisi untuk lahan aktif.</p>
                    </div>
                </div>
                <div class="col-md-5 text-end d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3 rounded-3" data-bs-toggle="modal" data-bs-target="#importModal">Impor Template Benih</button>
                    <a href="{{ route('tanaman.create') }}" class="btn btn-success btn-sm px-3 rounded-3 fw-bold">+ Daftarkan Tanaman</a>
                </div>
            </div>
        </div>

        <!-- PAGINATION SECTION -->
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted small">Menampilkan 4 dari 12 varietas tanaman aktif</span>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link border-0 rounded-start-2" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link bg-success border-success text-white" href="#">1</a></li>
                <li class="page-item"><a class="page-link text-dark border-0" href="#">2</a></li>
                <li class="page-item"><a class="page-link text-dark border-0" href="#">3</a></li>
                <li class="page-item"><a class="page-link border-0 rounded-end-2 text-dark" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
            </ul>
        </div>
    </main>

    <!-- MODAL IMPORT TEMPLATE (Contoh Interaksi Fungsional) -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Impor Template Benih</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted small">Unggah file CSV atau Excel yang berisi data batch benih dan parameter nutrisi lahan.</p>
                        <div class="mb-3">
                            <input type="file" name="file_csv" class="form-control" accept=".csv, .xlsx" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-sm">Unggah & Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP JS & INTERACTIVE SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Antara Tampilan Grid dan Tabel
        const btnGridView = document.getElementById('btnGridView');
        const btnTableView = document.getElementById('btnTableView');
        const gridViewContainer = document.getElementById('gridViewContainer');
        const tableViewContainer = document.getElementById('tableViewContainer');

        btnGridView.addEventListener('click', function() {
            btnGridView.classList.add('btn-success', 'active');
            btnGridView.classList.remove('btn-outline-secondary');
            btnTableView.classList.remove('btn-success', 'active');
            btnTableView.classList.add('btn-outline-secondary');
            
            gridViewContainer.style.display = 'block';
            tableViewContainer.style.display = 'none';
        });

        btnTableView.addEventListener('click', function() {
            btnTableView.classList.add('btn-success', 'active');
            btnTableView.classList.remove('btn-outline-secondary');
            btnGridView.classList.remove('btn-success', 'active');
            btnGridView.classList.add('btn-outline-secondary');
            
            tableViewContainer.style.display = 'block';
            gridViewContainer.style.display = 'none';
        });
    </script>
</body>

</html>