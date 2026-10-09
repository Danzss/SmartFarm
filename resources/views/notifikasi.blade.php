<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Notifikasi - SmartFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">
    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
            <div class="d-flex align-items-center gap-3">
                <i class="fa-solid fa-bell text-warning fs-2"></i>
                <h1 class="h3 fw-bold mb-0 text-dark">Semua Notifikasi Sistem</h1>
            </div>
            <div class="d-flex align-items-center gap-3">
                @include('layouts.notification-dropdown')
                @include('layouts.user-profile-dropdown')
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        <section class="card border-0 shadow-sm overflow-hidden bg-white" aria-label="Daftar notifikasi">
            <div class="card-body p-0">
                @forelse ($notifikasiList as $notif)
                    <article class="p-4 border-bottom d-flex align-items-start gap-3">
                        <div class="bg-{{ $notif['tipe'] }}-subtle text-{{ $notif['tipe'] }} rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 45px; height: 45px;">
                            <i class="fa-solid {{ $notif['tipe'] === 'warning' ? 'fa-triangle-exclamation' : ($notif['selesai'] ? 'fa-check' : 'fa-droplet') }} fs-5"></i>
                        </div>
                        <div class="min-width-0">
                            <h2 class="h6 fw-bold text-dark mb-1">{{ $notif['judul'] }}</h2>
                            <p class="text-muted mb-1">{{ $notif['pesan'] }}</p>
                            <small class="text-secondary">{{ $notif['waktu'] }}</small>
                        </div>
                    </article>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="fa-regular fa-bell-slash fs-3 mb-2"></i>
                        <p class="mb-0">Tidak ada notifikasi sistem saat ini.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>