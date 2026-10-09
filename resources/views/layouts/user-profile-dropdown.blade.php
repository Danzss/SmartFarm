@php($profileUser = Auth::user())

<div class="dropdown" data-user-profile>
    <button type="button" id="userProfileDropdownButton" class="btn btn-link p-0 border-0 text-decoration-none d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Buka profil akun">
        <span class="text-end">
            <strong class="d-block text-dark" style="font-size: .8rem;">{{ $profileUser->name }}</strong>
            <small class="text-muted" style="font-size: .7rem;">{{ $profileUser->email }}</small>
        </span>
        <span class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 36px; height: 36px;">
            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($profileUser->name, 0, 1)) }}
        </span>
    </button>

    <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0" aria-labelledby="userProfileDropdownButton" style="width: 280px;">
        <div class="p-3 border-bottom">
            <strong class="d-block text-dark">{{ $profileUser->name }}</strong>
            <small class="text-muted">Profil akun SmartFarm</small>
        </div>
        <div class="px-3 py-2 small">
            <div class="text-muted">Email</div>
            <div class="text-dark text-break mb-2">{{ $profileUser->email }}</div>
            <div class="text-muted">Nomor telepon</div>
            <div class="text-dark">{{ $profileUser->no_hp ?: 'Belum diisi' }}</div>
        </div>
        <div class="p-2 border-top">
            <a href="{{ route('pengaturan.index') }}" class="dropdown-item rounded-2">
                <i class="fa-solid fa-user-gear me-2"></i>Profil & Pengaturan
            </a>
        </div>
    </div>
</div>
