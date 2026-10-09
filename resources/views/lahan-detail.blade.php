<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $detailType === 'sensor' ? 'Detail Sensor' : 'Log Aktivitas' }} - {{ $lahan['nama'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; font-size: .9rem; }
        .detail-shell { max-width: 960px; margin: 0 auto; padding: 2rem 1rem; }
        .detail-card { border: 0; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, .05); }
    </style>
</head>
<body>
    <main class="detail-shell">
        <a href="{{ route('lahan.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Lahan
        </a>

        <section class="detail-card card p-4 mb-3">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <small class="text-success fw-bold text-uppercase">{{ $lahan['sektor'] ?? 'Sektor' }}</small>
                    <h1 class="h3 fw-bold mb-1">{{ $lahan['nama'] ?? 'Lahan' }}</h1>
                    <p class="text-muted mb-0">{{ $lahan['komoditas'] ?? '-' }}</p>
                </div>
                <span class="badge bg-{{ $lahan['badge'] ?? 'success' }}">{{ $lahan['status'] ?? 'Aktif' }}</span>
            </div>
        </section>

        @if($detailType === 'sensor')
            <section class="card detail-card p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fa-solid fa-wifi text-success"></i>
                    <h2 class="h5 fw-bold mb-0">Ringkasan Sensor Lahan</h2>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><small class="text-muted d-block">Suhu</small><strong>{{ $lahan['suhu'] ?? '-' }}</strong></div></div>
                    <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><small class="text-muted d-block">Kelembaban / EC</small><strong>{{ $lahan['kelembaban'] ?? '-' }}</strong></div></div>
                    <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><small class="text-muted d-block">Jenis Media</small><strong>{{ $lahan['tanah'] ?? '-' }}</strong></div></div>
                    <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><small class="text-muted d-block">Irigasi</small><strong>{{ $lahan['irigasi'] ?? '-' }}</strong></div></div>
                </div>
                <div class="border-top mt-4 pt-3 text-muted small">
                    <i class="fa-solid fa-circle-info me-1"></i>
                    Nilai yang tampil adalah data tersimpan pada profil lahan. Telemetri langsung per sensor belum terhubung.
                    <div class="mt-2"><strong>Node:</strong> {{ $lahan['node'] ?? 'Belum terdaftar' }}</div>
                    @if(isset($lahan['latitude'], $lahan['longitude']))
                        <div><strong>Koordinat:</strong> {{ $lahan['latitude'] }}, {{ $lahan['longitude'] }}</div>
                    @endif
                </div>
            </section>
        @else
            <section class="card detail-card p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fa-solid fa-clock-rotate-left text-secondary"></i>
                    <h2 class="h5 fw-bold mb-0">Catatan Aktivitas</h2>
                </div>
                @forelse($catatanList as $catatan)
                    <article class="border-top py-3">
                        <div class="d-flex justify-content-between gap-3">
                            <strong>Catatan lapangan</strong>
                            <small class="text-muted text-nowrap">{{ $catatan['waktu'] ?? '' }}</small>
                        </div>
                        <p class="mb-0 mt-1">{{ $catatan['catatan'] ?? '' }}</p>
                    </article>
                @empty
                    <p class="text-muted border-top pt-3 mb-0">Belum ada catatan aktivitas untuk lahan ini.</p>
                @endforelse
                <a href="{{ route('lahan.index') }}" class="btn btn-outline-secondary btn-sm mt-3 align-self-start">Kembali ke Daftar Lahan</a>
            </section>
        @endif
    </main>
</body>
</html>