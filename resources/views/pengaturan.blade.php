<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartFarm')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
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

        .card-custom {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .profile-avatar {
            width: 144px;
            height: 144px;
            border: 4px solid #d8f3dc;
            background: #1b4332;
            color: #fff;
            font-size: 3rem;
        }

        .profile-info-icon {
            width: 48px;
            height: 48px;
            background: #e8f5e9;
            color: #2d6a4f;
        }

        .profile-info-row + .profile-info-row {
            border-top: 1px solid #e9ecef;
        }

        @media (max-width: 767.98px) {
            .profile-avatar {
                width: 120px;
                height: 120px;
                font-size: 2.5rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- MEMANGGIL SIDEBAR TERPISAH -->
    @include('layouts.sidebar')

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- TOP NAVBAR -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-white border-end-0 rounded-start-3">
                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0 bg-white rounded-end-3" placeholder="Cari lahan, tanaman, sensor...">
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('tanaman.create') }}" class="btn btn-success btn-sm rounded-3 px-3">
                    <i class="fa-solid fa-plus me-1"></i> Catat Data
                </a>

                @include('layouts.notification-dropdown')
                
                @include('layouts.user-profile-dropdown')
            </div>
        </div>

        <section class="container-fluid px-0">
            <div class="mb-4">
                <small class="text-success fw-bold text-uppercase">Akun</small>
                <h1 class="h3 fw-bold mb-1">Pengaturan / Profil</h1>
                <p class="text-muted mb-0">Lihat dan perbarui informasi akun SmartFarm Anda.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            <div class="text-center py-4 py-md-5">
                <div class="profile-avatar rounded-circle d-inline-flex align-items-center justify-content-center fw-bold shadow-sm mb-3"
                    aria-label="Avatar {{ $user->name }}">
                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 1)) }}
                </div>
                <h2 class="h3 fw-bold text-success mb-2">{{ $user->name }}</h2>
                <span class="badge rounded-pill px-3 py-2 bg-success-subtle text-success fs-6 fw-semibold">
                    Pengelola SmartFarm
                </span>
            </div>

            <div class="card card-custom p-3 p-md-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3 mb-md-4">
                    <h2 class="h5 fw-bold text-success mb-0">Informasi Akun</h2>
                    <button class="btn btn-link text-success fw-semibold text-decoration-none"
                        type="button" data-bs-toggle="collapse" data-bs-target="#editProfileForm"
                        aria-expanded="{{ $errors->any() ? 'true' : 'false' }}" aria-controls="editProfileForm">
                        <i class="fa-solid fa-pen me-1"></i>Edit
                    </button>
                </div>

                <div class="profile-info-row d-flex align-items-center gap-3 py-3">
                    <span class="profile-info-icon rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <div class="min-w-0">
                        <div class="text-muted mb-1">Nama Pengguna</div>
                        <div class="fw-semibold fs-5 text-break">{{ $user->name }}</div>
                    </div>
                </div>
                <div class="profile-info-row d-flex align-items-center gap-3 py-3">
                    <span class="profile-info-icon rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <div class="min-w-0">
                        <div class="text-muted mb-1">Email</div>
                        <div class="fw-semibold fs-5 text-break">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="profile-info-row d-flex align-items-center gap-3 py-3">
                    <span class="profile-info-icon rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0">
                        <i class="fa-solid fa-shield-halved"></i>
                    </span>
                    <div>
                        <div class="text-muted mb-1">Status Email</div>
                        <div class="fw-semibold fs-5">{{ $user->email_verified_at ? 'Terverifikasi' : 'Belum diverifikasi' }}</div>
                    </div>
                </div>
                <div class="profile-info-row d-flex align-items-center gap-3 py-3">
                    <span class="profile-info-icon rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <div class="min-w-0">
                        <div class="text-muted mb-1">Nomor Telepon</div>
                        <div class="fw-semibold fs-5 text-break">{{ $user->no_hp ?: 'Belum diisi' }}</div>
                    </div>
                </div>
                <div class="profile-info-row d-flex align-items-center gap-3 py-3">
                    <span class="profile-info-icon rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0">
                        <i class="fa-solid fa-fingerprint"></i>
                    </span>
                    <div>
                        <div class="text-muted mb-1">User ID</div>
                        <div class="fw-semibold fs-5">{{ $user->id }}</div>
                    </div>
                </div>

                <div class="collapse {{ $errors->any() ? 'show' : '' }}" id="editProfileForm">
                    <div class="border-top pt-4 mt-2">
                        <h3 class="h6 fw-bold mb-3">Ubah Informasi Akun</h3>
                        <form action="{{ route('pengaturan.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama</label>
                                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required maxlength="255">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required maxlength="255">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="no_hp" class="form-label fw-semibold">Nomor telepon</label>
                                <input id="no_hp" name="no_hp" type="tel" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp ?? '') }}" maxlength="30">
                                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- KONTEN DINAMIS HALAMAN -->
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>