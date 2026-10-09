<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Lahan & Greenhouse - SmartFarm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --sidebar-width: 240px;
            --primary-green: #1b4332;
            --light-green: #2d6a4f;
            --bg-light: #f8f9fa;
        }
        body { background-color: var(--bg-light); font-size: 0.875rem; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Sidebar Styling */
        .sidebar { width: var(--sidebar-width); position: fixed; top: 0; left: 0; height: 100vh; background: #fff; border-right: 1px solid #dee2e6; z-index: 1000; padding: 1.25rem 1rem; }
        .sidebar .nav-link { color: #6c757d; font-weight: 500; border-radius: 8px; margin-bottom: 4px; padding: 8px 12px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: var(--primary-green); color: #fff; }
        .sidebar .nav-link i { width: 20px; }

        /* Main Content */
        .main-content { margin-left: var(--sidebar-width); padding: 1.5rem 2rem; }
        
        /* Card & Badge Styling */
        .card-custom { border: none; border-radius: 16px; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.02); }
        .badge-soft-success { background-color: #d8f3dc; color: #2d6a4f; font-weight: 600; }
        .badge-soft-danger { background-color: #ffe5ec; color: #d90429; font-weight: 600; }
        .badge-soft-warning { background-color: #fff3bf; color: #f59f00; font-weight: 600; }
        .icon-box { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <!-- MAIN CONTENT -->
    <main class="main-content">
        
        <!-- NOTIFIKASI ALERT SESSION -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-info me-2"></i> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- TOP NAVBAR & PENCARIAN -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <form id="lahanFilterForm" action="{{ route('lahan.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                <div class="input-group" style="width: min(100%, 320px);">
                    <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input id="lahanSearch" type="search" name="search" value="{{ $search ?? '' }}" class="form-control border-start-0 bg-white" placeholder="Cari lahan atau komoditas...">
                </div>
                @if($search || $kategori || $status)
                    <a href="{{ route('lahan.index') }}" class="btn btn-link text-secondary text-decoration-none">Reset</a>
                @endif
            </form>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-success btn-sm rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#modalCatatData">
                    <i class="fa-solid fa-plus me-1"></i> Catat Data
                </button>
                @include('layouts.notification-dropdown')
                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-success fw-bold text-uppercase">Pemetaan Spasial & Aset Agronomi</small>
                <h3 class="fw-bold text-dark mb-0">Manajemen Lahan & Greenhouse</h3>
                <p class="text-muted small mb-0">Pantau luas, sektor aktif, jenis tanah, irigasi, dan status komoditas lahan pertanian terintegrasi sensor IoT.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('lahan.export') }}" class="btn btn-white btn-sm border rounded-3 bg-white text-dark text-decoration-none d-flex align-items-center">
                    <i class="fa-solid fa-file-csv me-1"></i> Ekspor Data CSV
                </a>
                <button class="btn btn-success btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahLahan">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Lahan Baru
                </button>
            </div>
        </div>

        <!-- METRIC CARDS TOP -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">TOTAL WILAYAH LAHAN</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-layer-group"></i></div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ number_format($totalLuas, 2, ',', '.') }} <span class="fs-6 text-muted">Ha</span></h2>
                    <small class="text-muted">Total luas dari {{ count($allLahan) }} lahan terdaftar</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">SEKTOR PRODUKTIF</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-house-chimney-window"></i></div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ count($allLahan) }} <span class="fs-6 text-muted">lahan</span></h2>
                    <small class="text-muted">Sektor & Greenhouse Terdaftar</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">METODE IRIGASI</small>
                        <div class="icon-box bg-primary-subtle text-primary"><i class="fa-solid fa-droplet"></i></div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $irigasiCount }}</h2>
                    <small class="text-muted">Jenis metode terdaftar</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">SENSOR ONLINE</small>
                        <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-wifi"></i></div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $lahanDenganNode }} <span class="fs-6 text-muted">lahan</span></h2>
                    <small class="badge badge-soft-success w-auto">Memiliki data node</small>
                </div>
            </div>
        </div>

        <!-- DAFTAR KARTU LAHAN / SEKTOR AKTIF (DYNAMIC FROM CONTROLLER) -->
        <div class="row g-3 mb-4">
            @forelse($lahanList as $lahan)
            <div class="col-md-6">
                <div class="card card-custom p-4 h-100 border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-success-subtle text-success mb-1">{{ $lahan['sektor'] ?? 'Sektor Umum' }}</span>
                            <h4 class="fw-bold mb-0 text-dark">{{ $lahan['nama'] ?? 'Tanpa Nama' }}</h4>
                            <small class="text-muted"><i class="fa-solid fa-seedling text-success me-1"></i> {{ $lahan['komoditas'] ?? '-' }}</small>
                        </div>
                        <span class="badge bg-{{ $lahan['badge'] ?? 'success' }} px-3 py-2 rounded-pill">{{ $lahan['status'] ?? 'Aktif' }}</span>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <div class="p-2 border rounded bg-light text-center">
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Luas Area</small>
                                <strong>{{ $lahan['luas'] ?? '0 Ha' }}</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded bg-light text-center">
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Suhu / pH</small>
                                <strong>{{ $lahan['suhu'] ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded bg-light text-center">
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Kelembaban / EC</small>
                                <strong>{{ $lahan['kelembaban'] ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>

                    @php($katup = $katupData[$lahan['id'] ?? 0] ?? null)
                    <div class="d-flex justify-content-between align-items-center small mb-2">
                        <span class="text-muted"><i class="fa-solid fa-droplet me-1"></i>{{ $lahan['irigasi'] ?? 'Irigasi belum diatur' }}</span>
                        <span class="badge {{ ($katup['status'] ?? '') === 'aktif' ? 'badge-soft-success' : 'bg-light text-secondary' }}">
                            Katup {{ ($katup['status'] ?? '') === 'aktif' ? 'Aktif' : (($katup['status'] ?? '') === 'nonaktif' ? 'Nonaktif' : 'Belum diatur') }}
                            @if(!empty($katup['jadwal'])) • {{ $katup['jadwal'] }} @endif
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                        <small class="text-muted"><i class="fa-solid fa-microchip me-1"></i> {{ $lahan['node'] ?? 'Node Standar' }}</small>
                        <div class="d-flex gap-1">
                            <a href="{{ route('lahan.sensor', $lahan['id'] ?? 1) }}" class="btn btn-outline-success btn-sm" title="Detail Sensor IoT"><i class="fa-solid fa-wifi"></i></a>
                            <a href="{{ route('lahan.log', $lahan['id'] ?? 1) }}" class="btn btn-outline-secondary btn-sm" title="Log Aktivitas"><i class="fa-solid fa-clock-rotate-left"></i></a>
                            <button type="button" class="btn btn-outline-primary btn-sm btn-edit-lahan" title="Edit lahan"
                                data-bs-toggle="modal" data-bs-target="#modalEditLahan"
                                data-url="{{ route('lahan.update', $lahan['id'] ?? 0) }}"
                                data-nama="{{ $lahan['nama'] ?? '' }}" data-sektor="{{ $lahan['sektor'] ?? '' }}"
                                data-komoditas="{{ $lahan['komoditas'] ?? '' }}" data-luas="{{ preg_replace('/[^0-9.]/', '', $lahan['luas'] ?? '0') }}"
                                data-latitude="{{ $lahan['latitude'] ?? '' }}" data-longitude="{{ $lahan['longitude'] ?? '' }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form action="{{ route('lahan.urus', $lahan['id'] ?? 0) }}" method="POST" onsubmit="return confirm('Aktifkan status perawatan darurat untuk lahan ini?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning btn-sm" title="Tandai perawatan darurat"><i class="fa-solid fa-triangle-exclamation"></i></button>
                            </form>
                            <form action="{{ route('lahan.destroy', $lahan['id'] ?? 0) }}" method="POST" onsubmit="return confirm('Hapus data lahan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus lahan"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card card-custom p-5 text-center">
                    <i class="fa-solid fa-seedling text-muted fs-1 mb-2"></i>
                    <h5 class="fw-bold">Tidak ada data lahan ditemukan</h5>
                    <p class="text-muted small">Coba sesuaikan kata kunci pencarian Anda atau tambahkan lahan baru.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- CATATAN LAPANGAN -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <small class="text-muted fw-bold">RIWAYAT PENGAMATAN</small>
                    <h5 class="fw-bold mb-0">Catatan Lapangan Terbaru</h5>
                </div>
                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCatatData">
                    <i class="fa-solid fa-plus me-1"></i> Catat Pengamatan
                </button>
            </div>
            @forelse($catatanList as $catatan)
                <div class="border-top py-2">
                    <div class="d-flex justify-content-between gap-3">
                        <strong>{{ $catatan['nama_lahan'] ?? 'Lahan' }}</strong>
                        <small class="text-muted text-nowrap">{{ $catatan['waktu'] ?? '' }}</small>
                    </div>
                    <p class="text-muted mb-0">{{ $catatan['catatan'] ?? '' }}</p>
                </div>
            @empty
                <p class="text-muted mb-0 border-top pt-3">Belum ada catatan lapangan.</p>
            @endforelse
        </div>

        <!-- DENAH GEOSPASIAL SEKTOR PERTANIAN (PETA LEAFLET INTERAKTIF) -->
        <div class="card card-custom p-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted fw-bold">TATA LETAK GEOSPASIAL SMARTFARM</small>
                    <h4 class="fw-bold mb-2">Denah Zonasi 4 Sektor Pertanian</h4>
                    <p class="text-muted small">Klik marker pada peta interaktif di samping untuk memantau zonasi terpisah serta metrik geospasial dan kontrol irigasi langsung.</p>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Elevasi Rata-rata</small>
                                <strong>650 mdpl (Dataran Tinggi)</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Sumber Air Utama</small>
                                <strong>Embung Cikadu & Sumur Artesis</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Cuaca Mikroklimat</small>
                                <strong>23°C • Cerah Berawan</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Pembaruan Peta</small>
                                <strong>Hari ini, 07:12 WIB</strong>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success btn-sm rounded-3 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalKatup">
                            <i class="fa-solid fa-droplet me-1"></i> Atur Katup Irigasi Terjadwal
                        </button>
                        <a href="{{ route('lahan.export') }}" class="btn btn-outline-secondary btn-sm rounded-3 text-decoration-none d-flex align-items-center">
                            <i class="fa-solid fa-download me-1"></i> Ekspor Data CSV
                        </a>
                    </div>
                </div>

                <!-- KONTROL PETA INTERAKTIF LEAFLET -->
                <div class="col-md-6">
                    <div class="border rounded-4 overflow-hidden position-relative p-2 bg-white shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-2 px-2 pt-1">
                            <span class="badge bg-danger text-white"><i class="fa-solid fa-location-dot me-1"></i> Titik Pusat: -6.8124, 107.6150</span>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem;">Live Map</small>
                        </div>
                        
                        <div id="smartfarm-map" style="height: 280px; width: 100%; border-radius: 8px;" class="mb-2"></div>

                        <div class="row g-1 text-center" style="font-size: 0.75rem;">
                            <div class="col-3"><span class="badge badge-soft-success w-100 py-1">Sektor A</span></div>
                            <div class="col-3"><span class="badge badge-soft-success w-100 py-1">Sektor B</span></div>
                            <div class="col-3"><span class="badge badge-soft-danger w-100 py-1">Sektor C</span></div>
                            <div class="col-3"><span class="badge badge-soft-warning w-100 py-1">Sektor D</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL TAMBAH LAHAN BARU -->
    <div class="modal fade" id="modalTambahLahan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('lahan.store') }}" method="POST" class="modal-content border-0 rounded-4 shadow">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold fs-6"><i class="fa-solid fa-map-location-dot me-2"></i>Tambah Lahan / Greenhouse Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Lahan / Greenhouse</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Greenhouse Melona" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Keterangan Sektor</label>
                        <input type="text" name="sektor" class="form-control" placeholder="Contoh: Sektor C • Greenhouse Utama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Komoditas Tanaman</label>
                        <input type="text" name="komoditas" class="form-control" placeholder="Contoh: Melon Madu (Cucumis melo)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Luas Area (Ha)</label>
                        <input type="number" step="0.1" name="luas" class="form-control" placeholder="Contoh: 3.5" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Latitude (opsional)</label>
                            <input type="number" step="any" name="latitude" class="form-control" placeholder="-6.8124">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Longitude (opsional)</label>
                            <input type="number" step="any" name="longitude" class="form-control" placeholder="107.6150">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm">Simpan Lahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT LAHAN -->
    <div class="modal fade" id="modalEditLahan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditLahan" action="#" method="POST" class="modal-content border-0 rounded-4 shadow">
                @csrf
                @method('PUT')
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold fs-6"><i class="fa-solid fa-pen me-2"></i>Edit Data Lahan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label fw-bold small">Nama Lahan</label><input type="text" name="nama" id="editNama" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-bold small">Keterangan Sektor</label><input type="text" name="sektor" id="editSektor" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-bold small">Komoditas</label><input type="text" name="komoditas" id="editKomoditas" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-bold small">Luas Area (Ha)</label><input type="number" min="0.01" step="0.01" name="luas" id="editLuas" class="form-control" required></div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label fw-bold small">Latitude</label><input type="number" step="any" name="latitude" id="editLatitude" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="form-label fw-bold small">Longitude</label><input type="number" step="any" name="longitude" id="editLongitude" class="form-control"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CATAT DATA HARIAN -->
    <div class="modal fade" id="modalCatatData" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('lahan.catat') }}" method="POST" class="modal-content border-0 rounded-4 shadow">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold fs-6"><i class="fa-solid fa-pen-to-square me-2"></i>Catat Data Harian Agronomi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pilih Sektor Lahan</label>
                        <select name="lahan_id" class="form-select" required>
                            @foreach($allLahan as $l)
                                <option value="{{ $l['id'] ?? 1 }}">{{ $l['nama'] ?? 'Lahan' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Catatan Lapangan / Pengamatan</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Tuliskan hasil pengecekan visual, pemupukan, atau kendala hama..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success btn-sm">Simpan Catatan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PENGATURAN KATUP -->
    <div class="modal fade" id="modalKatup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('lahan.katup') }}" method="POST" class="modal-content border-0 rounded-4 shadow">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold fs-6"><i class="fa-solid fa-droplet me-2"></i>Pengaturan Katup Irigasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Lahan</label>
                        <select name="lahan_id" class="form-select" required>
                            @foreach($allLahan as $l)
                                <option value="{{ $l['id'] }}">{{ $l['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Status Katup</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Waktu Jadwal (opsional)</label>
                        <input type="time" name="jadwal" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var filterForm = document.getElementById('lahanFilterForm');
            var searchInput = document.getElementById('lahanSearch');
            var searchTimeout;
            searchInput.addEventListener('input', function () {
                window.clearTimeout(searchTimeout);
                searchTimeout = window.setTimeout(function () {
                    filterForm.requestSubmit();
                }, 350);
            });
            document.querySelectorAll('.btn-edit-lahan').forEach(function (button) {
                button.addEventListener('click', function () {
                    var form = document.getElementById('formEditLahan');
                    form.action = button.dataset.url;
                    document.getElementById('editNama').value = button.dataset.nama || '';
                    document.getElementById('editSektor').value = button.dataset.sektor || '';
                    document.getElementById('editKomoditas').value = button.dataset.komoditas || '';
                    document.getElementById('editLuas').value = button.dataset.luas || '';
                    document.getElementById('editLatitude').value = button.dataset.latitude || '';
                    document.getElementById('editLongitude').value = button.dataset.longitude || '';
                });
            });

            // Inisialisasi peta berpusat di koordinat SmartFarm (-6.8124, 107.6150)
            var map = L.map('smartfarm-map').setView([-6.8124, 107.6150], 15);

            // Tambahkan Tile Layer OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Perbaiki ukuran peta setelah div termuat sepenuhnya
            setTimeout(function() {
                map.invalidateSize();
            }, 200);

            // Ambil data dinamis dari Controller yang di-pass ke Blade JSON
            var lahanDataJson = @json($lahanList);

            // Koordinat default pendukung untuk sampel demo
            var defaultCoords = [
                [-6.8115, 107.6135],
                [-6.8110, 107.6165],
                [-6.8135, 107.6140],
                [-6.8140, 107.6160]
            ];

            // Looping data lahan dari Controller untuk disematkan sebagai Marker Peta
            var markerBounds = [];
            lahanDataJson.forEach(function(item, index) {
                var hasCoordinates = item.latitude !== null && item.latitude !== '' && item.longitude !== null && item.longitude !== '';
                var coords = hasCoordinates
                    ? [Number(item.latitude), Number(item.longitude)]
                    : defaultCoords[index % defaultCoords.length];
                var marker = L.marker(coords).addTo(map);
                var popup = document.createElement('div');
                var title = document.createElement('strong');
                title.textContent = item.nama || 'Lahan';
                popup.appendChild(title);
                [
                    'Sektor: ' + (item.sektor || '-'),
                    'Komoditas: ' + (item.komoditas || '-'),
                    'Luas: ' + (item.luas || '-') + ' | Status: ' + (item.status || '-'),
                    'Koordinat: ' + coords[0] + ', ' + coords[1]
                ].forEach(function (text) {
                    var line = document.createElement('div');
                    line.textContent = text;
                    popup.appendChild(line);
                });
                marker.bindPopup(popup);
                markerBounds.push(coords);
            });

            if (markerBounds.length > 0) {
                map.fitBounds(markerBounds, { padding: [20, 20], maxZoom: 15 });
            }
        });
    </script>
</body>
</html>