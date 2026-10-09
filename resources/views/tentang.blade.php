@extends('layouts.app')

@section('title', 'Tentang Aplikasi - SmartFarm')

@section('content')
    <section class="container-fluid px-0">
        <div class="mb-4">
            <small class="text-success fw-bold text-uppercase">Informasi Aplikasi</small>
            <h3 class="fw-bold text-dark mb-1">Tentang SmartFarm</h3>
            <p class="text-muted small mb-0">Kenali sistem dan fitur yang mendukung pengelolaan pertanian Anda.</p>
        </div>

        <div class="card card-custom p-4 mb-4">
            <div class="d-flex align-items-start gap-3">
                <div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width: 48px; height: 48px;">
                    <i class="fa-solid fa-tractor fs-4"></i>
                </div>
                <div>
                    <h4 class="h5 fw-bold mb-2">Sistem informasi pertanian terpadu</h4>
                    <p class="text-muted mb-0">
                        SmartFarm membantu pengguna mencatat dan memantau kegiatan pertanian dalam satu aplikasi,
                        mulai dari pengelolaan tanaman dan lahan hingga pemantauan, panen, dan pelaporan.
                    </p>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="h6 fw-bold text-dark mb-0">Fitur Aplikasi</h4>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-xl-4">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-seedling"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold mb-1">Kelola tanaman dan lahan</h5>
                            <p class="text-muted small mb-0">Simpan data tanaman, varietas, lahan, dan aktivitas pertanian.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold mb-1">Jadwal dan monitoring</h5>
                            <p class="text-muted small mb-0">Atur kegiatan pertanian serta pantau kondisi lahan dan sensor.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-microscope"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold mb-1">Deteksi dan penanganan</h5>
                            <p class="text-muted small mb-0">Gunakan deteksi AI dan catat hama atau penyakit untuk mendukung tindak lanjut.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-wheat-awn"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold mb-1">Catatan panen</h5>
                            <p class="text-muted small mb-0">Catat hasil panen berdasarkan komoditas, lahan, kuantitas, dan mutu.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card card-custom p-3 h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold mb-1">Riwayat dan laporan</h5>
                            <p class="text-muted small mb-0">Tinjau aktivitas dan rangkum data pertanian dalam laporan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
