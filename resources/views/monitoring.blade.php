<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Pertumbuhan - SmartFarm</title>
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
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* Timeline Items */
        .timeline-container {
            position: relative;
            padding-left: 20px;
            border-left: 2px dashed #dee2e6;
        }

        .timeline-dot {
            position: absolute;
            left: -29px;
            top: 0;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid var(--primary-green);
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

        <!-- NOTIFIKASI FLASH MESSAGE -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- TOP NAVBAR -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" class="form-control border-start-0 bg-white rounded-end-3" placeholder="Cari lahan, tanaman, sensor...">
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('lahan.index') }}" class="btn btn-success btn-sm rounded-3 px-3 text-decoration-none"><i class="fa-solid fa-plus me-1"></i> Catat Data</a>
                @include('layouts.notification-dropdown')
                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-success fw-bold text-uppercase"><i class="fa-solid fa-chart-line me-1"></i> AGRONOMI & TUMBUH KEMBANG</small>
                <h3 class="fw-bold text-dark mb-1">Monitoring & Timeline Agronomi</h3>
                <p class="text-muted small mb-0">Pemantauan berkala tinggi tanaman, indeks daun, fase vegetatif, dan catatan inspeksi lapangan terpadu secara real-time.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('monitoring.export') }}" class="btn btn-outline-secondary btn-sm rounded-3"><i class="fa-solid fa-file-export me-1"></i> Ekspor Log Monitoring</a>
                <button class="btn btn-success btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#inputInspeksiModal"><i class="fa-solid fa-plus me-1"></i> Input Catatan Baru</button>
            </div>
        </div>

        <!-- FILTER CARD -->
        <div class="card card-custom p-3 mb-4">
            <small class="text-muted fw-bold mb-2 d-block" style="font-size: 0.7rem;">LOKASI & VARIETAS TERPILIH</small>
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <select class="form-select border-0 bg-light fw-bold text-dark">
                        <option selected>Sektor A1 - Tomat Cherry Sweet Gold (Greenhouse 02)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block" style="font-size: 0.65rem;">RENTANG WAKTU</small>
                    <select class="form-select form-select-sm border-0 bg-light">
                        <option selected>28 Hari Terakhir</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block" style="font-size: 0.65rem;">FOKUS METRIK UTAMA</small>
                    <select class="form-select form-select-sm border-0 bg-light">
                        <option selected>Tinggi & Vigor (Tingkat)</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <span class="badge bg-success-subtle text-success border border-success-subtle p-2">
                        <i class="fa-solid fa-wifi me-1"></i> Terhubung Sensor Lapangan
                    </span>
                </div>
            </div>
        </div>

        <!-- STATS METRICS ROW -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.7rem;">LAJU PERTUMBUHAN</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-arrow-trend-up"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">+18%</h3>
                    <small class="text-success"><i class="fa-solid fa-caret-up me-1"></i>+16.2% vs standar rata-rata</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.7rem;">TINGGI RATA-RATA LAHAN</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-ruler-vertical"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">48 <span class="fs-6 text-muted">cm / 35 HST</span></h3>
                    <div class="d-flex gap-1">
                        <span class="badge bg-success-subtle text-success">Sesuai Target</span>
                        <span class="badge bg-light text-dark">Estimasi 92cm</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.7rem;">INDEKS HIJAU DAUN (SPAD)</small>
                        <div class="icon-box bg-light text-secondary"><i class="fa-solid fa-leaf"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">45 <span class="fs-6 text-muted">SPAD</span></h3>
                    <small class="text-muted">Target Sehat min 40 SPAD • <span class="text-success">+2 poin klorofil</span></small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold" style="font-size: 0.7rem;">INSPEKSI LAPANGAN</small>
                        <div class="icon-box bg-light text-secondary"><i class="fa-solid fa-clipboard-check"></i></div>
                    </div>
                    <h3 class="fw-bold mb-1">2x <span class="fs-6 text-muted">/Minggu</span></h3>
                    <small class="text-muted">Kepatuhan Jadwal Inspeksi 100%</small>
                </div>
            </div>
        </div>

        <!-- GRAPH CHART CARD -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-0">Tren Tinggi Tanaman vs Standar Agronomi</h6>
                    <small class="text-muted">Perbandingan pertumbuhan riil tanaman terhadap kurva deviasi standar varietas Tomat Cherry Sweet Gold.</small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="small"><i class="fa-solid fa-circle text-success me-1"></i> Hasil Lapangan (Riil)</span>
                    <span class="small"><i class="fa-solid fa-circle text-muted me-1"></i> Target Standar Agronomi</span>
                </div>
            </div>
            <div style="height: 220px;">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <!-- MAIN CONTENT GRID (FORM INPUT + TIMELINE) -->
        <div class="row g-4">
            <!-- LEFT: INPUT INSPEKSI FORM -->
            <div class="col-md-4">
                <div class="card card-custom p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        @include('layouts.user-profile-dropdown')
                                <label class="form-label text-muted" style="font-size: 0.7rem;">Komoditas</label>
                                <select name="komoditas" class="form-select form-select-sm">
                                    <option value="Tomat Cherry Gold">Tomat Cherry Gold</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted" style="font-size: 0.7rem;">Minggu ke / Petak</label>
                                <input type="text" name="minggu_petak" class="form-control form-control-sm" value="M5 / P-A2024-01" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label text-muted" style="font-size: 0.7rem;">Tinggi Tanaman (cm)</label>
                                <input type="text" name="tinggi_tanaman" class="form-control form-control-sm" placeholder="Contoh: 45 cm" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted" style="font-size: 0.7rem;">Warna Daun (SPAD Visual)</label>
                                <select name="warna_daun" class="form-select form-select-sm">
                                    <option value="Hijau Pekat (SPAD 48)">HIJAU PEKAT</option>
                                    <option value="Hijau Sedang (SPAD 42)">HIJAU SEDANG</option>
                                    <option value="Kekuningan (SPAD 35)">KEKUNINGAN</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted" style="font-size: 0.7rem;">Ketebalan Batang</label>
                                <select name="ketebalan_batang" class="form-select form-select-sm">
                                    <option value="Kokoh / Diameter 1.2cm">KOKOH (VERY)</option>
                                    <option value="Sedang">SEDANG</option>
                                    <option value="Kecil">KECIL</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted" style="font-size: 0.7rem;">Proporsi Bunga & Buah</label>
                                <select name="proporsi_bunga" class="form-select form-select-sm">
                                    <option value="6 Tandan Mekar">6 Tandan Mekar</option>
                                    <option value="Bunga Standar">Bunga Standar</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 0.7rem;">Foto Pengamatan Lapangan</label>
                            <input type="file" name="foto_pengamatan" class="form-control form-control-sm mb-1" accept="image/*">
                            <div class="border border-dashed rounded-3 p-2 text-center bg-light">
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Format JPG, PNG (Maks 10MB)</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 0.7rem;">Catatan Lapangan</label>
                            <textarea name="catatan_lapangan" class="form-control form-control-sm" rows="2" placeholder="Masukkan catatan pengamatan..."></textarea>
                        </div>

                        <div class="p-2 bg-light rounded-3 mb-3 border">
                            <small class="text-muted d-block mb-1" style="font-size: 0.65rem;">Rekomendasi Agronomis AI Automated:</small>
                            <small class="text-dark d-block" style="font-size: 0.7rem;">Struktur batang mekar sempurna, tunas air sebaiknya dipruning agar nutrisi fokus ke pembentukan buah.</small>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Hasil Monitoring</button>
                    </form>
                </div>
            </div>

            <!-- RIGHT: RIWAYAT MONITORING TIMELINE (DINAMIS DARI SESSION) -->
            <div class="col-md-8">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="fw-bold mb-0">Riwayat Monitoring Lapangan</h6>
                            <small class="text-muted">28 hari rekaman pemantauan visual agronomi & parameter sensor.</small>
                        </div>
                        <i class="fa-solid fa-sliders text-muted cursor-pointer"></i>
                    </div>

                    <div class="timeline-container ms-2">
                        @forelse($logs as $index => $log)
                        <div class="position-relative mb-4">
                            <div class="timeline-dot" {{ $index > 0 ? 'style=border-color:#6c757d;' : '' }}></div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ $index == 0 ? 'bg-success-subtle text-success' : 'bg-light text-dark' }} fw-bold">{{ $log['tanggal'] }}</span>
                                    <small class="text-muted">• {{ $log['petugas'] }}</small>
                                </div>
                                <span class="badge {{ $index == 0 ? 'bg-success text-white' : 'bg-light text-dark' }}">{{ $log['fase'] }}</span>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-md-4">
                                    <div class="p-2 border rounded-3 bg-light text-center">
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">Tinggi Tanaman</small>
                                        <span class="fw-bold fs-5 text-dark">{{ $log['tinggi'] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-2 border rounded-3 bg-light text-center">
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">Kondisi / Daun</small>
                                        <span class="fw-bold fs-6 text-dark">{{ $log['kondisi'] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-2 border rounded-3 bg-light text-center">
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">Status Bunga / Atribut</small>
                                        <span class="fw-bold fs-6 text-dark">{{ $log['status_bunga'] }}</span>
                                    </div>
                                </div>
                            </div>

                            @if(!empty($log['foto']))
                            <div class="mb-2">
                                <img src="{{ $log['foto'] }}" class="img-fluid rounded-3" style="max-height: 180px; width: 100%; object-fit: cover;" alt="Foto Monitoring">
                            </div>
                            @endif

                            <div class="p-2 bg-light border rounded-3">
                                <small class="text-dark d-block"><strong>Catatan Lapangan:</strong> {{ $log['catatan'] }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            Belum ada riwayat log monitoring yang tercatat.
                        </div>
                        @endforelse
                    </div>

                    <div class="text-center mt-3">
                        <button class="btn btn-light btn-sm border text-muted"><i class="fa-solid fa-arrow-down me-1"></i> Muat Lebih Banyak Log (10+ Log)</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- SCRIPT GRAFIK TREN -->
    <script>
        const ctx = document.getElementById('growthChart').getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(82, 183, 136, 0.4)');
        gradient.addColorStop(1, 'rgba(82, 183, 136, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['HST 10 (Semai)', 'HST 15', 'HST 20 (Vegetatif)', 'HST 25 (Transisi)', 'HST 30 (Pembungaan)', 'HST 35 (Tanaman Saat Ini)'],
                datasets: [
                    {
                        label: 'Hasil Lapangan (Riil)',
                        data: [10, 18, 28, 36, 42, 48],
                        borderColor: '#1b4332',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#1b4332'
                    },
                    {
                        label: 'Target Standar Agronomi',
                        data: [8, 15, 24, 32, 40, 45],
                        borderColor: '#adb5bd',
                        borderDash: [5, 5],
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        grid: { color: '#f1f3f5' },
                        ticks: { font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>