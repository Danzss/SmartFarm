<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Penyakit AI - SmartFarm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
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
            overflow-x: hidden;
        }

        /* Sidebar Styling (Disamakan dengan Dashboard) */
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

        /* Main Content Margin */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem 2rem;
            min-height: 100vh;
        }

        /* Header & Search Bar */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: var(--primary-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Chat Card & Upload UI */
        .chat-card {
            background-color: #ffffff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            position: relative;
            min-height: 650px;
            padding-bottom: 100px !important;
        }

        .btn-upload-custom {
            background-color: var(--primary-green);
            color: white;
            border-radius: 8px;
            padding: 8px 24px;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-upload-custom:hover {
            background-color: var(--light-green);
            color: white;
        }

        #imagePreviewContainer img {
            max-height: 180px;
            border-radius: 12px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR (PERSIS SAMA DENGAN DASHBOARD) -->
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

        <!-- TOP HEADER -->
        <header class="top-header">
            <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-white border-end-0 rounded-start-3 text-muted border-0 bg-transparent">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" class="form-control border-start-0 bg-white rounded-end-3 shadow-none" placeholder="Cari lahan, tanaman, sensor...">
            </div>

            <div class="user-profile">
                <button class="btn btn-success btn-sm rounded-3 px-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Catat Data
                </button>
                <i class="fa-regular fa-bell text-muted fs-5 position-relative ms-2">
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </i>
                <div class="d-flex align-items-center gap-2 ms-2">
                    <div class="text-end d-none d-md-block" style="line-height: 1.2;">
                        <span class="fw-bold d-block small text-dark">{{ Auth::user()->name ?? 'Rizal Agung Nugraha' }}</span>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email ?? 'rizalagungnugraha155@gmail.com' }}</small>
                    </div>
                    <div class="avatar-circle">
                        {{ substr(Auth::user()->name ?? 'Rizal Agung Nugraha', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- SUB HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="badge bg-success bg-opacity-10 text-success fw-bold border border-success border-opacity-20 mb-1 px-2 py-1">
                    <i class="fa-solid fa-microchip me-1"></i> AI VISION DIAGNOSTIC SYSTEM
                </span>
                <h3 class="fw-bold text-dark mb-0">Deteksi Penyakit Tanaman Berbasis AI</h3>
                <small class="text-muted">Unggah foto daun atau bagian tanaman bermasalah untuk diagnosis instan dan rekomendasi mitigasi agronomis otomatis.</small>
            </div>
            <button class="btn btn-outline-secondary rounded-pill px-3 btn-sm bg-white">
                <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat Diagnosa
            </button>
        </div>

        <!-- MAIN CARD FORM -->
        <form action="{{ route('deteksi-ai.proses') }}" method="POST" enctype="multipart/form-data" id="mainDeteksiForm">
            @csrf

            <!-- INPUT FILE UTAMA (HIDDEN) -->
            <input type="file" name="foto_daun" id="input_foto_daun" class="d-none" accept="image/*" onchange="previewImage(this)">

            <div class="card chat-card p-4">
                
                <!-- 1. DRAG & DROP BOX -->
                <div class="card border-0 rounded-4 p-4 text-center mx-auto mb-4 shadow-sm" style="max-width: 500px; background-color: #f8f9fa;">
                    <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background-color: var(--primary-green) !important;">
                        <i class="fa-solid fa-cloud-arrow-up fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">Drag & Drop</h5>
                    <p class="text-muted small mb-3">atau klik untuk upload foto daun</p>

                    <label for="input_foto_daun" class="btn btn-upload-custom px-4">
                        Pilih File
                    </label>

                    <!-- CONTAINER PREVIEW FOTO KETIKA DIPILIH -->
                    <div id="imagePreviewContainer" class="mt-3 d-none">
                        <img id="imagePreview" src="#" alt="Preview Foto" class="img-fluid border mb-2">
                        <p id="fileName" class="small text-muted mb-0"></p>
                    </div>
                </div>

                <!-- 2. AREA CHAT BUBBLES -->
                <div class="d-flex flex-column gap-3 mx-auto w-100" style="max-width: 680px;">

                    @if(isset($dataDiagnosis) && isset($fileInfo))
                        <!-- BUBBLE FOTO USER -->
                        <div class="align-self-end text-white rounded-4 p-2 shadow-sm" style="max-width: 80%; background-color: var(--primary-green); border-bottom-right-radius: 4px !important;">
                            <img src="{{ $fileInfo['url'] }}" class="img-fluid rounded-3 mb-2" style="max-height: 280px; width: 100%; object-fit: cover;">
                            <div class="px-2 small">
                                {{ $instruksiUser ?? 'Tolong analisis kondisi tanaman pada foto ini.' }}
                            </div>
                            <div class="text-end text-white-50 px-2" style="font-size: 0.7rem;">
                                {{ date('H:i') }}
                            </div>
                        </div>

                        <!-- BUBBLE BALASAN AI -->
                        <div class="d-flex align-items-start gap-2" style="max-width: 85%;">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-leaf"></i>
                            </div>
                            <div class="bg-white rounded-4 p-3 shadow-sm text-dark border" style="border-bottom-left-radius: 4px !important; font-size: 0.9rem; line-height: 1.5;">
                                
                                @if(!empty($dataDiagnosis['bukan_tanaman']) && $dataDiagnosis['bukan_tanaman'] === true)
                                    <!-- Jika Objek Bukan Tanaman / API Error -->
                                    <p class="mb-1 fw-bold text-danger">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Informasi Sistem
                                    </p>
                                    <p class="mb-0">{{ $dataDiagnosis['pesan_bebas'] ?? 'Objek yang diunggah tidak dikenal sebagai tanaman.' }}</p>
                                @else
                                    <!-- Tampilan Hasil Diagnosis Tanaman -->
                                    <p class="mb-2">Halo! Saya pakar tanaman dari SmartFarm. Berikut hasil analisis foto sampel Anda:</p>

                                    <div class="mb-2">
                                        <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem;">Diagnosa:</span>
                                        <div class="fw-bold text-success fs-6">
                                            {{ $dataDiagnosis['nama_penyakit'] ?? 'Tanaman Sehat / Kondisi Normal' }}
                                            @if(!empty($dataDiagnosis['nama_latin']))
                                                <small class="text-muted fw-normal"><em>({{ $dataDiagnosis['nama_latin'] }})</em></small>
                                            @endif
                                        </div>
                                    </div>

                                    @if(!empty($dataDiagnosis['gejala']))
                                        <div class="mb-2">
                                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem;">Gejala Visual:</span>
                                            <p class="mb-0">{{ $dataDiagnosis['gejala'] }}</p>
                                        </div>
                                    @endif

                                    @if(!empty($dataDiagnosis['penyebab']))
                                        <div class="mb-2">
                                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem;">Penyebab Utama:</span>
                                            <p class="mb-0">{{ $dataDiagnosis['penyebab'] }}</p>
                                        </div>
                                    @endif

                                    @if(!empty($dataDiagnosis['rekomendasi']) && is_array($dataDiagnosis['rekomendasi']))
                                        <div class="mt-3 pt-2 border-top">
                                            <span class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Langkah Penanganan:</span>
                                            <ol class="ps-3 mb-0">
                                                @foreach($dataDiagnosis['rekomendasi'] as $rec)
                                                    <li class="mb-1">
                                                        <strong>{{ $rec['judul'] ?? 'Langkah' }}</strong>: {{ $rec['deskripsi'] ?? '' }}
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    @endif
                                @endif

                            </div>
                        </div>
                    @endif

                </div>

                <!-- 3. INPUT CHAT BAR FLOATING AT BOTTOM -->
                <div class="position-absolute bottom-0 start-50 translate-middle-x w-100 mb-3 px-4" style="max-width: 680px;">
                    <div class="bg-white rounded-pill p-2 shadow-sm border d-flex align-items-center gap-2">
                        <input type="text" name="pertanyaan" class="form-control border-0 bg-transparent shadow-none px-3" placeholder="Ketik pertanyaan atau instruksi...">
                        
                        <label for="input_foto_daun" class="btn btn-link text-secondary p-0 m-0 fs-5 me-1" style="cursor: pointer;" title="Lampirkan Gambar">
                            <i class="fa-regular fa-image"></i>
                        </label>

                        <button type="submit" class="btn btn-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background-color: var(--primary-green); border: none;">
                            <i class="fa-solid fa-paper-plane text-white fs-6"></i>
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </main>

    <!-- SCRIPT PREVIEW DAN HANDLER -->
    <script>
        function previewImage(input) {
            const container = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    fileName.textContent = 'Terpilih: ' + input.files[0].name;
                    container.classList.remove('d-none');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>