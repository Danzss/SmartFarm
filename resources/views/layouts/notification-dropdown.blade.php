@php
    $notificationDropdownItems = app(\App\Support\ScheduleData::class)->notifications();
    $notificationDropdownUnreadCount = collect($notificationDropdownItems)->where('selesai', false)->count();
@endphp

<div class="dropdown" data-notification-dropdown>
    <button type="button" id="notificationDropdownButton" class="btn btn-link p-0 border-0 text-secondary position-relative" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Buka notifikasi">
        <i class="fa-regular fa-bell fs-5"></i>
        @if ($notificationDropdownUnreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: .6rem;">{{ $notificationDropdownUnreadCount }}</span>
        @endif
    </button>

    <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0" aria-labelledby="notificationDropdownButton" style="width: 340px; border-radius: 12px; overflow: hidden; font-size: .8rem;">
        <div class="bg-success text-white p-3 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="fa-solid fa-bell me-2"></i>Notifikasi</span>
            <span class="badge bg-white text-success fw-bold px-2 py-1" style="font-size: 11px; border-radius: 20px;">{{ $notificationDropdownUnreadCount }} Baru</span>
        </div>

        <div class="p-2" style="max-height: 300px; overflow-y: auto;">
            @forelse ($notificationDropdownItems as $notification)
                <a href="{{ route('notifikasi.index') }}" class="d-block p-2 border-bottom text-decoration-none text-dark">
                    <span class="fw-bold d-block mb-1">{{ $notification['judul'] }}</span>
                    <span class="text-muted d-block mb-1" style="font-size: 11.5px;">{{ $notification['pesan'] }}</span>
                    <span class="text-primary d-block" style="font-size: 11px;"><i class="fa-regular fa-clock me-1"></i>{{ $notification['waktu'] }}</span>
                </a>
            @empty
                <div class="text-center text-muted py-4" style="font-size: 13px;">Tidak ada notifikasi.</div>
            @endforelse
        </div>

        <div class="p-2 text-center bg-light border-top">
            <a href="{{ route('notifikasi.index') }}" class="text-success text-decoration-none fw-semibold" style="font-size: .75rem;">Lihat Semua Notifikasi</a>
        </div>
    </div>
</div>
