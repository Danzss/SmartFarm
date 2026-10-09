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
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tanaman.index') }}"
                    class="nav-link {{ request()->routeIs('tanaman.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-seedling me-2"></i>Tanaman
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lahan.index') }}"
                    class="nav-link {{ request()->routeIs('lahan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-map-location-dot me-2"></i>Lahan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('jadwal.index') }}"
                    class="nav-link {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check me-2"></i>Jadwal
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('monitoring.index') }}"
                    class="nav-link {{ request()->routeIs('monitoring.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-desktop me-2"></i>Monitoring
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('deteksi-ai.index') }}"
                    class="nav-link {{ request()->routeIs('deteksi-ai.*') || request()->routeIs('ai-deteksi.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-microscope me-2"></i>Deteksi Penyakit AI
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('hama.index') }}"
                    class="nav-link {{ request()->routeIs('hama.*') || request()->routeIs('hama-penyakit.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-bug me-2"></i>Hama & Penyakit
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('riwayat.index') }}"
                    class="nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('panen.index') }}"
                    class="nav-link {{ request()->routeIs('panen.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wheat-awn me-2"></i>Panen
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('laporan.index') }}"
                    class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-lines me-2"></i>Laporan
                </a>
            </li>
        </ul>
    </div>

    <div>
        <ul class="nav nav-pills flex-column mb-3">
            <li class="nav-item">
                <a href="{{ route('pengaturan.index') }}"
                    class="nav-link {{ request()->routeIs('pengaturan.*') || request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear me-2"></i>Profil dan Pengaturan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tentang.index') }}"
                    class="nav-link {{ request()->routeIs('tentang.*') ? 'active' : '' }}">
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