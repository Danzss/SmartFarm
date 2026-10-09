<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal & Agenda Kebun - SmartFarm</title>
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

        /* Custom Cards & Components */
        .card-custom {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        /* Date Picker Bar */
        .day-card {
            border-radius: 12px;
            padding: 10px 14px;
            text-align: center;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            cursor: pointer;
            transition: all 0.2s;
        }

        .day-card.active {
            background: var(--primary-green);
            color: #fff;
            border-color: var(--primary-green);
        }

        /* Status Badges */
        .badge-running {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .badge-pending {
            background-color: #f1f3f5;
            color: #495057;
        }

        .badge-waiting {
            background-color: #fff9db;
            color: #f59f00;
        }

        .badge-completed {
            background-color: #d3f9d8;
            color: #2b8a3e;
        }

        /* Task Item Cards */
        .task-card {
            border: 1px solid #edf2f7;
            border-radius: 14px;
            background: #fff;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
        }

        .task-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        /* Circular Progress Bar Dynamic */
        .progress-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: conic-gradient(var(--primary-green) {{ $persentase ?? 0 }}%, #e9ecef 0);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .progress-circle-inner {
            width: 66px;
            height: 66px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
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

        <!-- TOP NAVBAR & SEARCH -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <form action="{{ route('jadwal.index') }}" method="GET" class="w-100" style="max-width: 400px;">
                @if(request('tanggal'))
                    <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                @endif
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                @if(request('sektor'))
                    <input type="hidden" name="sektor" value="{{ request('sektor') }}">
                @endif
                @if(request('view'))
                    <input type="hidden" name="view" value="{{ request('view') }}">
                @endif
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control border-start-0 bg-white rounded-end-3" placeholder="Cari jadwal, sektor, petugas...">
                </div>
            </form>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-success btn-sm rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal"><i class="fa-solid fa-plus me-1"></i> Catat Data</button>
                
                @include('layouts.notification-dropdown')

                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-success fw-bold text-uppercase"><i class="fa-solid fa-calendar-days me-1"></i> KALENDER & OPERASIONAL LAPANGAN</small>
                <h3 class="fw-bold text-dark mb-1">Jadwal & Agenda Kebun</h3>
                <p class="text-muted small mb-0">Atur rotasi penyiraman, pemupukan, perawatan daun, dan pengobatan di seluruh lahan pertanian secara otomatis maupun manual.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm rounded-3"><i class="fa-solid fa-rotate me-1"></i> Sinkronisasi IoT Timer</button>
                <button class="btn btn-success btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal"><i class="fa-solid fa-plus me-1"></i> Tambah Jadwal Baru</button>
            </div>
        </div>

        <!-- FILTER & TOGGLE BAR -->
        <div class="card card-custom p-3 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('jadwal.index', array_merge(request()->except('kategori'), ['kategori' => 'Semua'])) }}" class="btn {{ ($kategori ?? 'Semua') === 'Semua' ? 'btn-success' : 'btn-light border' }} btn-sm rounded-pill px-3">Semua</a>
                    <a href="{{ route('jadwal.index', array_merge(request()->except('kategori'), ['kategori' => 'Penyiraman'])) }}" class="btn {{ ($kategori ?? '') === 'Penyiraman' ? 'btn-success' : 'btn-light border' }} btn-sm rounded-pill px-3"><i class="fa-solid fa-droplet text-primary me-1"></i> Penyiraman</a>
                    <a href="{{ route('jadwal.index', array_merge(request()->except('kategori'), ['kategori' => 'Pemupukan'])) }}" class="btn {{ ($kategori ?? '') === 'Pemupukan' ? 'btn-success' : 'btn-light border' }} btn-sm rounded-pill px-3"><i class="fa-solid fa-vial text-success me-1"></i> Pemupukan</a>
                    <a href="{{ route('jadwal.index', array_merge(request()->except('kategori'), ['kategori' => 'Perawatan'])) }}" class="btn {{ ($kategori ?? '') === 'Perawatan' ? 'btn-success' : 'btn-light border' }} btn-sm rounded-pill px-3"><i class="fa-solid fa-scissors text-warning me-1"></i> Perawatan</a>
                    <a href="{{ route('jadwal.index', array_merge(request()->except('kategori'), ['kategori' => 'Pengobatan'])) }}" class="btn {{ ($kategori ?? '') === 'Pengobatan' ? 'btn-success' : 'btn-light border' }} btn-sm rounded-pill px-3"><i class="fa-solid fa-prescription-bottle-medical text-danger me-1"></i> Pengobatan</a>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('jadwal.index') }}" method="GET">
                        @if(request('tanggal'))
                            <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                        @endif
                        @if(request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('view'))
                            <input type="hidden" name="view" value="{{ request('view') }}">
                        @endif
                        <select name="sektor" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
                            <option value="Semua Sektor">Semua Sektor</option>
                            <option value="Sektor Utara" {{ request('sektor') == 'Sektor Utara' ? 'selected' : '' }}>Sektor Utara</option>
                            <option value="Sektor Selatan" {{ request('sektor') == 'Sektor Selatan' ? 'selected' : '' }}>Sektor Selatan</option>
                            <option value="Greenhouse C" {{ request('sektor') == 'Greenhouse C' ? 'selected' : '' }}>Greenhouse C</option>
                        </select>
                    </form>

                    <!-- TOMBOL DAFTAR AGENDA & BULAN -->
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('jadwal.index', array_merge(request()->all(), ['view' => 'agenda'])) }}" class="btn {{ (request('view', 'agenda') == 'agenda') ? 'btn-success text-white' : 'btn-outline-secondary' }}">
                            <i class="fa-solid fa-list me-1"></i> Daftar Agenda
                        </a>
                        <a href="{{ route('jadwal.index', array_merge(request()->all(), ['view' => 'bulan'])) }}" class="btn {{ (request('view') == 'bulan') ? 'btn-success text-white' : 'btn-outline-secondary' }}">
                            <i class="fa-solid fa-calendar-days me-1"></i> Kalender Bulanan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- KONDISI TAMPILAN: JIKA PILIH BULAN ATAU AGENDA -->
        @if(request('view') == 'bulan')
            <!-- TAMPILAN KALENDER BULANAN DENGAN SEMUA TANGGAL DAPAT DIKLIK -->
            <div class="card card-custom p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-calendar-days text-success me-2"></i> Kalender Operasional Bulan Oktober 2026</h5>
                    <span class="badge bg-success-subtle text-success">Mode Tampilan Bulanan</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center" style="font-size: 0.85rem;">
                        <thead class="table-light">
                            <tr>
                                <th class="text-danger">Min</th>
                                <th>Sen</th>
                                <th>Sel</th>
                                <th>Rab</th>
                                <th>Kam</th>
                                <th>Jum</th>
                                <th>Sab</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-muted bg-light"><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '27', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-muted">27</a></td>
                                <td class="text-muted bg-light"><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '28', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-muted">28</a></td>
                                <td class="text-muted bg-light"><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '29', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-muted">29</a></td>
                                <td class="text-muted bg-light"><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '30', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-muted">30</a></td>
                                <td>
                                    <a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '1', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark fw-bold">1</a><br>
                                    <small class="badge bg-success-subtle text-success">2 Agenda</small>
                                </td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '2', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">2</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '3', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">3</a></td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '4', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">4</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '5', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">5</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '6', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">6</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '7', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">7</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '8', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">8</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '9', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">9</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '10', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">10</a></td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '11', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">11</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '12', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">12</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '13', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">13</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '14', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">14</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '15', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">15</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '16', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">16</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '17', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">17</a></td>
                            </tr>
                            <tr>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '18', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">18</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '19', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">19</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '20', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">20</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '21', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">21</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '22', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">22</a></td>
                                <td>
                                    <a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '23', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark fw-bold">23</a><br>
                                    <small class="badge bg-success-subtle text-success">1 Agenda</small>
                                </td>
                                <td>
                                    <a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '24', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark fw-bold">24</a><br>
                                    <small class="badge bg-success-subtle text-success">1 Agenda</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">
                                    <a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '25', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark fw-bold">25</a><br>
                                    <small class="badge bg-success text-white">Hari Ini</small>
                                </td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '26', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">26</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '27', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">27</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '28', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">28</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '29', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">29</a></td>
                                <td><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '30', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-dark">30</a></td>
                                <td class="text-muted bg-light"><a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => '1', 'view' => 'agenda'])) }}#jadwal-section" class="text-decoration-none text-muted">1</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- TAMPILAN DAFTAR AGENDA (DEFAULT) -->
            <!-- WEEKLY CALENDAR STRIP -->
            <div class="card card-custom p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-regular fa-calendar-check fs-5 text-success"></i>
                        <h5 class="fw-bold mb-0">Oktober 2026</h5>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3">Pekan ke-4</span>
                    </div>
                </div>

                @php
                    $activeDate = $tanggal ?? '25';
                @endphp
                <div class="row g-2 text-center">
                    @foreach(['23' => 'SEN', '24' => 'SEL', '25' => 'RAB', '26' => 'KAM', '27' => 'JUM', '28' => 'SAB', '29' => 'MIN'] as $tgl => $hari)
                        <div class="col">
                            <a href="{{ route('jadwal.index', array_merge(request()->all(), ['tanggal' => $tgl])) }}" class="text-decoration-none">
                                <div class="day-card {{ $activeDate == $tgl ? 'active' : '' }}">
                                    <small class="{{ $activeDate == $tgl ? 'text-white' : ($tgl == '29' ? 'text-danger' : 'text-muted') }} d-block fw-semibold mb-1">{{ $hari }}</small>
                                    <h5 class="fw-bold mb-0 {{ $activeDate == $tgl ? 'text-white' : ($tgl == '29' ? 'text-danger' : 'text-dark') }}">{{ $tgl }}</h5>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- MAIN GRID CONTENT (TASKS + SIDE STATS) - DIBERIKAN ID JADWAL-SECTION -->
            <div class="row g-4" id="jadwal-section">
                <!-- LEFT COLUMN: TASK LIST -->
                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Jadwal Operasi Tanggal {{ $tanggal ?? '25' }} Oktober</h5>
                        <small class="text-muted">Total {{ count($jadwalList ?? []) }} Agenda Terdaftar</small>
                    </div>

                    @forelse($jadwalList as $item)
                        <div class="task-card {{ ($item['selesai'] ?? false) ? 'bg-light opacity-75' : '' }}">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box bg-success-subtle text-success">
                                    <i class="fa-solid {{ ($item['kategori'] ?? '') == 'Penyiraman' ? 'fa-droplet' : (($item['kategori'] ?? '') == 'Pemupukan' ? 'fa-vial' : 'fa-scissors') }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge {{ ($item['badge'] ?? 'pending') == 'success' ? 'badge-running' : (($item['badge'] ?? 'pending') == 'warning' ? 'badge-waiting' : 'badge-pending') }} rounded-pill">
                                            <i class="fa-solid fa-circle me-1" style="font-size: 6px;"></i> {{ $item['status'] ?? 'Belum Mulai' }}
                                        </span>
                                        <small class="text-muted">• Waktu: {{ $item['waktu'] ?? '-' }}</small>
                                    </div>
                                    <h6 class="fw-bold mb-1 {{ ($item['selesai'] ?? false) ? 'text-decoration-line-through' : '' }}">{{ $item['judul'] ?? 'Tanpa Judul' }}</h6>
                                    <p class="text-muted small mb-2">{{ $item['sektor'] ?? '-' }}</p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-muted"><i class="fa-solid fa-robot me-1"></i> Petugas: {{ $item['petugas'] ?? '-' }}</small>
                                        
                                        <!-- TOMBOL AKSI -->
                                        <div class="d-flex gap-2">
                                            @if(($item['status'] ?? '') === 'Sedang Berjalan')
                                                <form action="{{ route('jadwal.status', $item['id']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="aksi" value="pause">
                                                    <button type="submit" class="btn btn-light btn-sm border rounded-2"><i class="fa-solid fa-pause me-1"></i> Pause</button>
                                                </form>
                                            @elseif(!($item['selesai'] ?? false))
                                                <form action="{{ route('jadwal.status', $item['id']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="aksi" value="mulai">
                                                    <button type="submit" class="btn btn-success btn-sm rounded-2"><i class="fa-solid fa-play me-1"></i> Mulai</button>
                                                </form>
                                            @endif

                                            @if(!($item['selesai'] ?? false))
                                                <form action="{{ route('jadwal.status', $item['id']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="aksi" value="selesai">
                                                    <button type="submit" class="btn btn-success btn-sm rounded-2"><i class="fa-solid fa-check me-1"></i> Selesai</button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary rounded-2 px-3 py-2">Selesai</span>
                                            @endif

                                            <form action="{{ route('jadwal.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-2"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 card card-custom">
                            <p class="text-muted mb-0">Tidak ada jadwal ditemukan pada tanggal atau filter ini.</p>
                        </div>
                    @endforelse
                </div>

                <!-- RIGHT COLUMN: STATS & SUMMARY WIDGETS -->
                <div class="col-md-4">
                    <!-- WIDGET 1: TASK COMPLETION PROGRESS + TOMBOL EFISIENSI KE CHART -->
                    <div class="card card-custom p-3 mb-4 text-center">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Penyelesaian Tugas Hari Ini</h6>
                            <i class="fa-solid fa-rotate-right text-muted" onclick="window.location.reload();" style="cursor: pointer;"></i>
                        </div>

                        <div class="progress-circle my-2">
                            <div class="progress-circle-inner">
                                <h4 class="fw-bold mb-0">{{ $persentase ?? 0 }}%</h4>
                            </div>
                        </div>

                        <h5 class="fw-bold mt-2 mb-1">{{ $tugasSelesai ?? 0 }} dari {{ $totalTugas ?? 0 }}</h5>
                        <p class="text-muted small mb-3">Kegiatan terselesaikan sesuai timeline harian.</p>

                        <!-- TOMBOL EFISIENSI DIARAHKAN KE BAGIAN GRAFIK (CHART) -->
                        <a href="#efisiensiChartSection" class="btn btn-outline-success btn-sm rounded-pill py-2 text-decoration-none">
                            <i class="fa-solid fa-chart-line me-1"></i> Efisiensi Siklus: Optimal (+4%)
                        </a>
                    </div>

                    <!-- WIDGET 2: WATER ESTIMATION -->
                    <div class="card card-custom p-3 mb-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-1">Estimasi Kebutuhan Air</h6>
                                <h3 class="fw-bold text-dark mb-0">1,450 <span class="fs-6 fw-normal text-muted">Liter</span></h3>
                            </div>
                            <div class="icon-box bg-success-subtle text-success">
                                <i class="fa-solid fa-droplet"></i>
                            </div>
                        </div>
                        <small class="text-muted d-block mb-3">Penggunaan Air Terencana (Hari Ini)</small>

                        <div class="p-2 bg-success-subtle rounded-3 text-success small">
                            <i class="fa-solid fa-circle-info me-1"></i> Kelembaban tanah rata-rata 68%. IoT menghemat 210L.
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- BAGIAN GRAFIK (CHART) ANALISIS EFISIENSI PER BULAN -->
        <div id="efisiensiChartSection" class="card card-custom p-4 mt-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1"><i class="fa-solid fa-chart-line text-success me-2"></i> Grafik Analisis Efisiensi Bulanan</h5>
                    <small class="text-muted">Statistik tingkat penyelesaian agenda operasional per minggu sepanjang Bulan Oktober 2026.</small>
                </div>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">Status Bulanan: Optimal (+4%)</span>
            </div>
            <div style="height: 280px;">
                <canvas id="efisiensiChart"></canvas>
            </div>
        </div>

    </main>

    <!-- MODAL TAMBAH JADWAL -->
    <div class="modal fade" id="modalTambahJadwal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('jadwal.store') }}" method="POST" class="modal-content border-0 shadow">
                @csrf
                <input type="hidden" name="tanggal" value="{{ $tanggal ?? '25' }}">
                
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Tambah Agenda Kebun Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Agenda</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Pemupukan NPK Lahan A" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="Penyiraman">Penyiraman</option>
                            <option value="Pemupukan">Pemupukan</option>
                            <option value="Perawatan">Perawatan</option>
                            <option value="Pengobatan">Pengobatan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sektor / Lokasi</label>
                        <input type="text" name="sektor" class="form-control" placeholder="Contoh: Sektor Utara Blok 2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Waktu Operasional</label>
                        <input type="text" name="waktu" class="form-control" placeholder="Contoh: 08:00 - 10:00 WIB" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Petugas / PIC</label>
                        <input type="text" name="petugas" class="form-control" placeholder="Contoh: Tim Lapangan 1" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm px-3">Simpan Agenda</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT CHART.JS UNTUK GRAFIK EFISIENSI BULANAN -->
    <script>
        const ctxEfisiensi = document.getElementById('efisiensiChart').getContext('2d');
        new Chart(ctxEfisiensi, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels ?? ['Pekan 1 (Okt)', 'Pekan 2 (Okt)', 'Pekan 3 (Okt)', 'Pekan 4 (Okt)', 'Pekan 5 (Okt)']) !!},
                datasets: [{
                    label: 'Rata-rata Penyelesaian Bulanan (%)',
                    data: {!! json_encode($chartData ?? [88, 92, 85, 95, 90]) !!},
                    backgroundColor: '#1b4332',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: '#f1f3f5' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>