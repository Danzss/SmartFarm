<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hama & Penyakit - SmartFarm</title>
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

        .card-pest {
            border: 1px solid #e9ecef;
            border-radius: 16px;
            background: #fff;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-pest:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
        }

        .card-pest-img {
            height: 140px;
            object-fit: cover;
            width: 100%;
        }

        .badge-category {
            font-size: 0.65rem;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
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
                    <a href="{{ route('hama.index') }}" class="nav-link {{ request()->routeIs('hama.*') || request()->routeIs('hama-penyakit.*') ? 'active' : '' }}">
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

        <!-- TOP NAVBAR -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" class="form-control border-start-0 bg-white rounded-end-3" placeholder="Cari hama, penyakit, atau patogen...">
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('tanaman.create') }}" class="btn btn-success btn-sm rounded-3 px-3 text-decoration-none"><i class="fa-solid fa-plus me-1"></i> Catat Tanaman</a>
                @include('layouts.notification-dropdown')
                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-success fw-bold text-uppercase"><i class="fa-solid fa-book-bookmark me-1"></i> SISTEM DIAGNOSTIK & PERLINDUNGAN TANAMAN</small>
                <h3 class="fw-bold text-dark mb-1">Katalog Hama & Penyakit Tanaman</h3>
                <p class="text-muted small mb-0">Ensiklopedi dan panduan diagnostik gejala, penyebab, tindakan preventif serta kuratif bagi komoditas hortikultura terpadu.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm rounded-3"><i class="fa-solid fa-sliders me-1"></i> Konsultasi Ahli Pertanian</button>
                <button type="button" class="btn btn-success btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#laporkanGejalaModal"><i class="fa-solid fa-plus me-1"></i> Laporkan Gejala Baru</button>
            </div>
        </div>

        <!-- STATS / SUMMARY METRICS -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3 d-flex flex-row align-items-center gap-3">
                    <div class="icon-box bg-success-subtle text-success fs-5"><i class="fa-solid fa-virus"></i></div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.65rem;">PANDUAN KATALOG</small>
                        <h5 class="fw-bold mb-0">6 entri</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 d-flex flex-row align-items-center gap-3">
                    <div class="icon-box bg-danger-subtle text-danger fs-5"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.65rem;">LAPORAN PRIORITAS TINGGI</small>
                        <h5 class="fw-bold mb-0">{{ $laporanPrioritas }} laporan</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 d-flex flex-row align-items-center gap-3">
                    <div class="icon-box bg-info-subtle text-info fs-5"><i class="fa-solid fa-shield-halved"></i></div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.65rem;">LAPORAN GEJALA</small>
                        <h5 class="fw-bold mb-0">{{ count($hamaReports) }} laporan</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 d-flex flex-row align-items-center gap-3">
                    <div class="icon-box bg-warning-subtle text-warning fs-5"><i class="fa-solid fa-calendar-day"></i></div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.65rem;">JADWAL PENGOBATAN AKTIF</small>
                        <h5 class="fw-bold mb-0">{{ $jadwalSemprotAktif }} tugas</h5>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <section class="card card-custom p-3 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <small class="text-muted fw-bold">LAPORAN LAPANGAN</small>
                    <h5 class="fw-bold mb-0">Gejala Tercatat</h5>
                </div>
                <span class="badge bg-light text-dark border">{{ count($hamaReports) }} laporan</span>
            </div>
            @forelse ($hamaReports as $report)
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 border-top py-3">
                    <div>
                        <strong>{{ $report['tanaman'] }} · {{ $report['gejala'] }}</strong>
                        <div class="small text-muted">{{ $report['lokasi'] }} · {{ $report['tanggal'] }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge {{ $report['tingkat'] === 'tinggi' ? 'bg-danger' : ($report['tingkat'] === 'sedang' ? 'bg-warning text-dark' : 'bg-secondary') }}">{{ ucfirst($report['tingkat']) }}</span>
                        <span class="small text-muted">{{ $report['status'] }}</span>
                    </div>
                </div>
            @empty
                <div class="text-muted small border-top pt-3">Belum ada laporan gejala. Gunakan tombol “Laporkan Gejala Baru” untuk mencatat temuan.</div>
            @endforelse
        </section>

        <!-- SEARCH & FILTER BAR -->
        <div class="card card-custom p-3 mb-4">
            <div class="row g-2 align-items-center mb-2">
                <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 bg-light" placeholder="Cari nama penyakit, hama, atau patogen...">
                    </div>
                </div>
                <div class="col-md-7 d-flex align-items-center gap-2 justify-content-end">
                    <small class="text-muted fw-bold me-1" style="font-size: 0.7rem;">KOMODITAS:</small>
                    <button class="btn btn-success btn-sm rounded-pill px-3 py-1 text-white fw-bold" style="font-size: 0.7rem;">Semua</button>
                    <button class="btn btn-light btn-sm rounded-pill px-3 py-1 border" style="font-size: 0.7rem;">Tomat</button>
                    <button class="btn btn-light btn-sm rounded-pill px-3 py-1 border" style="font-size: 0.7rem;">Cabai</button>
                    <button class="btn btn-light btn-sm rounded-pill px-3 py-1 border" style="font-size: 0.7rem;">Selada</button>
                    <button class="btn btn-light btn-sm rounded-pill px-3 py-1 border" style="font-size: 0.7rem;">Paprika</button>
                    <button class="btn btn-light btn-sm rounded-pill px-3 py-1 border" style="font-size: 0.7rem;">Melon</button>
                </div>
            </div>
            <hr class="my-2 text-muted opacity-25">
            <div class="d-flex align-items-center gap-2">
                <small class="text-muted fw-bold me-2" style="font-size: 0.7rem;">KATEGORI PATOGEN:</small>
                <button class="btn btn-success btn-sm rounded-2 px-3 py-1 text-white fw-bold" style="font-size: 0.7rem;">Semua Patogen</button>
                <button class="btn btn-light btn-sm rounded-2 px-3 py-1 border" style="font-size: 0.7rem;">Jamur (Fungi)</button>
                <button class="btn btn-light btn-sm rounded-2 px-3 py-1 border" style="font-size: 0.7rem;">Bakteri</button>
                <button class="btn btn-light btn-sm rounded-2 px-3 py-1 border" style="font-size: 0.7rem;">Virus</button>
                <button class="btn btn-light btn-sm rounded-2 px-3 py-1 border" style="font-size: 0.7rem;">Serangga / Hama</button>
                <button class="btn btn-light btn-sm rounded-2 px-3 py-1 border" style="font-size: 0.7rem;">Defisiensi Nutrisi</button>
            </div>
        </div>

        <!-- GRID CATALOG CARDS -->
        <div class="row g-4">

            <!-- CARD 1 -->
            <div class="col-md-4">
                <div class="card card-pest h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1592417817098-8f3d6ef23a28?auto=format&fit=crop&w=600&q=80" class="card-pest-img" alt="Hawar Daun Dini">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white badge-category">Jamur / Fungi</span>
                        <span class="position-absolute top-0 end-0 m-2 badge bg-success text-white badge-category"><i class="fa-solid fa-shield-check me-1"></i> Sedang (Ancaman Regional)</span>
                        <div class="position-absolute bottom-0 start-0 p-2 text-white w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <small class="text-warning fw-bold d-block" style="font-size: 0.65rem;">CENDAWAN PATOGEN</small>
                            <h6 class="fw-bold mb-0">Hawar Daun Dini</h6>
                            <small class="fst-italic text-light" style="font-size: 0.65rem;">Alternaria solani</small>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-muted border" style="font-size: 0.65rem;"><i class="fa-solid fa-seedling me-1"></i>Tanaman Rentang:</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Tomat</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Terung</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Kentang</span>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-circle-dot text-success me-1"></i>Karakteristik Gejala:</small>
                                <p class="text-muted mb-0" style="font-size: 0.7rem;">Bercak konsentris cokelat tua dengan lingkaran kekuningan (klorosis) khas pada daun bawah, meluas ke tangkai dan buah tua.</p>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-hand-holding-medical text-success me-1"></i>Tindakan Kuratif & Pengendalian:</small>
                                <ul class="text-muted ps-3 mb-0" style="font-size: 0.7rem;">
                                    <li>Aplikasi Fungisida Berbahan Tembaga/Mankozeb.</li>
                                    <li>Pemangkasan berkala ranting daun 30cm.</li >
                                    <li>Monitoring mikroklimat tingkat kelembaban < 80%.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-2 border-top">
                            <button class="btn btn-success w-100 btn-sm fw-bold mb-1"><i class="fa-solid fa-calendar-plus me-1"></i> Integrasikan ke Jadwal Semprot</button>
                            <a href="#" class="text-center d-block text-success fw-bold text-decoration-none" style="font-size: 0.7rem;">Detail Diagnosis Lengkap →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-md-4">
                <div class="card card-pest h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=600&q=80" class="card-pest-img" alt="Kutu Kebul">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white badge-category">Hama (Serangga)</span>
                        <span class="position-absolute top-0 end-0 m-2 badge bg-danger text-white badge-category"><i class="fa-solid fa-triangle-exclamation me-1"></i> Ancaman Tinggi</span>
                        <div class="position-absolute bottom-0 start-0 p-2 text-white w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <small class="text-warning fw-bold d-block" style="font-size: 0.65rem;">SERANGGA VEKTOR VIRUS</small>
                            <h6 class="fw-bold mb-0">Kutu Kebul</h6>
                            <small class="fst-italic text-light" style="font-size: 0.65rem;">Bemisia tabaci</small>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-muted border" style="font-size: 0.65rem;"><i class="fa-solid fa-seedling me-1"></i>Tanaman Rentang:</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Cabai</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Tomat</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Kacang</span>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-circle-dot text-success me-1"></i>Karakteristik Gejala:</small>
                                <p class="text-muted mb-0" style="font-size: 0.7rem;">Daun keriting, melengkung ke atas, klorosis menguning tajam. Terdapat embun jelut hitam akibat ekskresi madu serangga.</p>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-hand-holding-medical text-success me-1"></i>Tindakan Kuratif & Pengendalian:</small>
                                <ul class="text-muted ps-3 mb-0" style="font-size: 0.7rem;">
                                    <li>Pemasangan Yellow Sticky Trap (20 sdt/hektar).</li>
                                    <li>Semprotan insektisida Imidakloprid/Abamektin.</li>
                                    <li>Aplikasi minyak nimba nabati penolak kawan serangga.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-2 border-top">
                            <button class="btn btn-success w-100 btn-sm fw-bold mb-1"><i class="fa-solid fa-calendar-plus me-1"></i> Integrasikan ke Jadwal Semprot</button>
                            <a href="#" class="text-center d-block text-success fw-bold text-decoration-none" style="font-size: 0.7rem;">Detail Diagnosis Lengkap →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-md-4">
                <div class="card card-pest h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1592417817098-8f3d6ef23a28?auto=format&fit=crop&w=600&q=80" class="card-pest-img" alt="Busuk Lunak Bakteri">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white badge-category">Bakteri</span>
                        <span class="position-absolute top-0 end-0 m-2 badge bg-danger text-white badge-category"><i class="fa-solid fa-radiation me-1"></i> Kritis (Isolasi Bagian)</span>
                        <div class="position-absolute bottom-0 start-0 p-2 text-white w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <small class="text-warning fw-bold d-block" style="font-size: 0.65rem;">PATOGEN VASKULAR</small>
                            <h6 class="fw-bold mb-0">Busuk Lunak Bakteri</h6>
                            <small class="fst-italic text-light" style="font-size: 0.65rem;">Erwinia carotovora</small>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-muted border" style="font-size: 0.65rem;"><i class="fa-solid fa-seedling me-1"></i>Tanaman Rentang:</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Selada</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Sawi</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Kubis</span>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-circle-dot text-success me-1"></i>Karakteristik Gejala:</small>
                                <p class="text-muted mb-0" style="font-size: 0.7rem;">Jaringan batang dan pangkal daun basah berair, berbau busuk khas menyengat, layu masif secara cepat mendadak.</p>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-hand-holding-medical text-success me-1"></i>Tindakan Kuratif & Pengendalian:</small>
                                <ul class="text-muted ps-3 mb-0" style="font-size: 0.7rem;">
                                    <li>Musnahkan tanaman terinfeksi total/bakar.</li>
                                    <li>Sterilisasi alat tanam & air drainase pasca infeksi.</li>
                                    <li>Aplikasi bakterisida Streptomisin Sulfat pada area penyangga.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-2 border-top">
                            <button class="btn btn-success w-100 btn-sm fw-bold mb-1"><i class="fa-solid fa-calendar-plus me-1"></i> Integrasikan ke Jadwal Semprot</button>
                            <a href="#" class="text-center d-block text-success fw-bold text-decoration-none" style="font-size: 0.7rem;">Detail Diagnosis Lengkap →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-md-4">
                <div class="card card-pest h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=600&q=80" class="card-pest-img" alt="Antraknosa">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white badge-category">Jamur / Fungi</span>
                        <span class="position-absolute top-0 end-0 m-2 badge bg-danger text-white badge-category"><i class="fa-solid fa-triangle-exclamation me-1"></i> Ancaman Tinggi</span>
                        <div class="position-absolute bottom-0 start-0 p-2 text-white w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <small class="text-warning fw-bold d-block" style="font-size: 0.65rem;">PATOGEN BUAH</small>
                            <h6 class="fw-bold mb-0">Antraknosa (Patek)</h6>
                            <small class="fst-italic text-light" style="font-size: 0.65rem;">Colletotrichum capsici</small>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-muted border" style="font-size: 0.65rem;"><i class="fa-solid fa-seedling me-1"></i>Tanaman Rentang:</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Cabai Merah</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Tomat</span>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-circle-dot text-success me-1"></i>Karakteristik Gejala:</small>
                                <p class="text-muted mb-0" style="font-size: 0.7rem;">Bercak melekuk melingkar pada buah cabai, bintik hitam konsentris membentuk pola melingkar, merusak jaringan seluruh buah.</p>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-hand-holding-medical text-success me-1"></i>Tindakan Kuratif & Pengendalian:</small>
                                <ul class="text-muted ps-3 mb-0" style="font-size: 0.7rem;">
                                    <li>Kutip dan buang buah terinfeksi agar tidak menulari buah lainnya.</li>
                                    <li>Penyemprotan fungisida propineb/difenokonazol bergantian.</li>
                                    <li>Memperlebar jarak tanam agar aerasi baik.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-2 border-top">
                            <button class="btn btn-success w-100 btn-sm fw-bold mb-1"><i class="fa-solid fa-calendar-plus me-1"></i> Integrasikan ke Jadwal Semprot</button>
                            <a href="#" class="text-center d-block text-success fw-bold text-decoration-none" style="font-size: 0.7rem;">Detail Diagnosis Lengkap →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 5 -->
            <div class="col-md-4">
                <div class="card card-pest h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1592417817098-8f3d6ef23a28?auto=format&fit=crop&w=600&q=80" class="card-pest-img" alt="Virus Kuning Gemini">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white badge-category">Virus</span>
                        <span class="position-absolute top-0 end-0 m-2 badge bg-danger text-white badge-category"><i class="fa-solid fa-triangle-exclamation me-1"></i> Ancaman Tinggi</span>
                        <div class="position-absolute bottom-0 start-0 p-2 text-white w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <small class="text-warning fw-bold d-block" style="font-size: 0.65rem;">VIRAL INFECTION</small>
                            <h6 class="fw-bold mb-0">Virus Kuning Gemini</h6>
                            <small class="fst-italic text-light" style="font-size: 0.65rem;">Pepper Yellow Leaf Curl (PepYLCV)</small>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-muted border" style="font-size: 0.65rem;"><i class="fa-solid fa-seedling me-1"></i>Tanaman Rentang:</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Cabai Rawit</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Tomat</span>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-circle-dot text-success me-1"></i>Karakteristik Gejala:</small>
                                <p class="text-muted mb-0" style="font-size: 0.7rem;">Pertumbuhan terhambat (kerdil), warna daun kuning cerah, helai daun melengkung (mangkuk) dan mengecil keras kaku.</p>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-hand-holding-medical text-success me-1"></i>Tindakan Kuratif & Pengendalian:</small>
                                <ul class="text-muted ps-3 mb-0" style="font-size: 0.7rem;">
                                    <li>Eradikasi tanaman sakit parah agar tidak menular ke tanaman lain.</li>
                                    <li>Pengendalian vektor serangga (Kutu Kebul) secara ketat.</li>
                                    <li>Aplikasi pupuk imun hara & asam amino untuk ketahanan.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-2 border-top">
                            <button class="btn btn-success w-100 btn-sm fw-bold mb-1"><i class="fa-solid fa-calendar-plus me-1"></i> Integrasikan ke Jadwal Semprot</button>
                            <a href="#" class="text-center d-block text-success fw-bold text-decoration-none" style="font-size: 0.7rem;">Detail Diagnosis Lengkap →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 6 -->
            <div class="col-md-4">
                <div class="card card-pest h-100">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=600&q=80" class="card-pest-img" alt="Busuk Pantat Buah">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white badge-category">Defisiensi Nutrisi</span>
                        <span class="position-absolute top-0 end-0 m-2 badge bg-success text-white badge-category"><i class="fa-solid fa-check me-1"></i> Terkendali</span>
                        <div class="position-absolute bottom-0 start-0 p-2 text-white w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <small class="text-warning fw-bold d-block" style="font-size: 0.65rem;">ABIOTIK DISORDER</small>
                            <h6 class="fw-bold mb-0">Busuk Pantat Buah (BER)</h6>
                            <small class="fst-italic text-light" style="font-size: 0.65rem;">Blossom End Rot (Ca)</small>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-muted border" style="font-size: 0.65rem;"><i class="fa-solid fa-seedling me-1"></i>Tanaman Rentang:</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Tomat</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Paprika</span>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">Melon</span>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-circle-dot text-success me-1"></i>Karakteristik Gejala:</small>
                                <p class="text-muted mb-0" style="font-size: 0.7rem;">Ujung buah (pantat) melekuk membusuk hitam/cokelat, akibat kegagalan translokasi Kalsium.</p>
                            </div>

                            <div class="mb-3">
                                <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-hand-holding-medical text-success me-1"></i>Tindakan Kuratif & Pengendalian:</small>
                                <ul class="text-muted ps-3 mb-0" style="font-size: 0.7rem;">
                                    <li>Semprotan kalsium foliar (CaNO3) berkala.</li>
                                    <li>Menjaga pH tanah/larutan transparan di rentang 6.0 - 6.5.</li>
                                    <li>Stabilkan kelembaban media dan frekuensi irigasi.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-2 border-top">
                            <button class="btn btn-success w-100 btn-sm fw-bold mb-1"><i class="fa-solid fa-calendar-plus me-1"></i> Integrasikan ke Jadwal Semprot</button>
                            <a href="#" class="text-center d-block text-success fw-bold text-decoration-none" style="font-size: 0.7rem;">Detail Diagnosis Lengkap →</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <div class="modal fade" id="laporkanGejalaModal" tabindex="-1" aria-labelledby="laporkanGejalaTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('hama.report') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="modal-title h5 fw-bold" id="laporkanGejalaTitle">Laporkan gejala tanaman</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reportTanaman" class="form-label">Tanaman</label>
                            <input id="reportTanaman" name="tanaman" class="form-control" value="{{ old('tanaman') }}" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="reportLokasi" class="form-label">Lahan / sektor</label>
                            <input id="reportLokasi" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required maxlength="120">
                        </div>
                        <div class="mb-3">
                            <label for="reportGejala" class="form-label">Gejala yang terlihat</label>
                            <textarea id="reportGejala" name="gejala" class="form-control" rows="3" required maxlength="500">{{ old('gejala') }}</textarea>
                        </div>
                        <div>
                            <label for="reportTingkat" class="form-label">Tingkat penanganan</label>
                            <select id="reportTingkat" name="tingkat" class="form-select" required>
                                <option value="rendah">Rendah</option>
                                <option value="sedang" selected>Sedang</option>
                                <option value="tinggi">Tinggi</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="jadwalSemprotModal" tabindex="-1" aria-labelledby="jadwalSemprotTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('hama.jadwal') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="modal-title h5 fw-bold" id="jadwalSemprotTitle">Jadwalkan penanganan</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="sprayJudul" class="form-label">Tindakan</label>
                            <input id="sprayJudul" name="judul" class="form-control" required maxlength="160">
                        </div>
                        <div class="mb-3">
                            <label for="spraySektor" class="form-label">Lahan / sektor</label>
                            <input id="spraySektor" name="sektor" class="form-control" required maxlength="120">
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="sprayTanggal" class="form-label">Tanggal</label>
                                <input id="sprayTanggal" name="tanggal" type="date" class="form-control" value="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="sprayWaktu" class="form-label">Waktu</label>
                                <input id="sprayWaktu" name="waktu" class="form-control" value="08:00 - 09:00" required maxlength="60">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="sprayPetugas" class="form-label">Petugas</label>
                            <input id="sprayPetugas" name="petugas" class="form-control" value="{{ Auth::user()->name }}" required maxlength="120">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan ke jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.card-pest .pt-2.border-top button').forEach((button) => {
            button.type = 'button';
            button.dataset.bsToggle = 'modal';
            button.dataset.bsTarget = '#jadwalSemprotModal';
            button.addEventListener('click', () => {
                const diagnosis = button.closest('.card-pest')?.querySelector('.position-relative h6')?.textContent.trim() || 'Penanganan hama';
                document.getElementById('sprayJudul').value = `Penanganan ${diagnosis}`;
                document.getElementById('spraySektor').value = '';
            });
        });
    </script>
</body>

</html>