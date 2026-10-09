<?php

namespace App\Support;

use Illuminate\Support\Str;

class ActivityLog
{
    public function record(string $kategori, string $judul, string $pesan, ?string $lokasi = null): array
    {
        $logs = session()->get('activity_logs', []);
        $entry = [
            'id' => (string) Str::uuid(),
            'tanggal' => now()->format('d M Y H:i'),
            'occurred_at' => now()->toIso8601String(),
            'kategori' => $kategori,
            'judul' => $judul,
            'pesan' => $pesan,
            'lokasi' => $lokasi ?? '-',
            'petugas' => auth()->user()->name ?? 'Pengguna',
        ];

        array_unshift($logs, $entry);
        session()->put('activity_logs', array_slice($logs, 0, 200));

        return $entry;
    }

    public function all(): array
    {
        return session()->get('activity_logs', []);
    }
}
