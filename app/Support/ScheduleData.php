<?php

namespace App\Support;

class ScheduleData
{
    public function all(): array
    {
        if (!session()->has('jadwal_data') || !is_array(session()->get('jadwal_data'))) {
            session()->put('jadwal_data', $this->defaults());
        }

        return array_values(session()->get('jadwal_data', []));
    }

    public function notifications(?array $schedule = null): array
    {
        return array_map(function (array $item) {
            $status = $item['status'] ?? 'Belum Mulai';
            $completed = (bool) ($item['selesai'] ?? $status === 'Selesai');
            $tone = $completed
                ? 'success'
                : ((($item['badge'] ?? '') === 'warning' || $status === 'Menunggu') ? 'warning' : 'primary');
            $sector = $item['sektor'] ?? '-';

            return [
                'id' => $item['id'] ?? null,
                'judul' => $item['judul'] ?? 'Aktivitas kebun',
                'kategori' => $item['kategori'] ?? 'Operasional',
                'sektor' => $sector,
                'pesan' => 'Status: ' . $status . ' | Petugas: ' . ($item['petugas'] ?? '-'),
                'waktu' => ($item['waktu'] ?? '-') . ' (' . $sector . ')',
                'status' => $status,
                'tipe' => $tone,
                'selesai' => $completed,
            ];
        }, $schedule ?? $this->all());
    }

    private function defaults(): array
    {
        return [
            [
                'id' => 1,
                'judul' => 'Penyiraman Otomatis Sektor Utara',
                'kategori' => 'Penyiraman',
                'sektor' => 'Sektor Utara',
                'waktu' => '07:00 - 08:30 WIB',
                'petugas' => 'Sistem IoT / Budi',
                'status' => 'Sedang Berjalan',
                'badge' => 'success',
                'selesai' => false,
                'tanggal' => '25',
            ],
            [
                'id' => 2,
                'judul' => 'Pemupukan NPK Tanaman Cabai',
                'kategori' => 'Pemupukan',
                'sektor' => 'Sektor Selatan',
                'waktu' => '09:00 - 11:00 WIB',
                'petugas' => 'Tim Lapangan 2',
                'status' => 'Belum Mulai',
                'badge' => 'pending',
                'selesai' => false,
                'tanggal' => '25',
            ],
            [
                'id' => 3,
                'judul' => 'Penyemprotan Pestisida Alami',
                'kategori' => 'Pengobatan',
                'sektor' => 'Greenhouse C',
                'waktu' => '15:00 - 16:30 WIB',
                'petugas' => 'Ahmad & Tim',
                'status' => 'Menunggu',
                'badge' => 'warning',
                'selesai' => false,
                'tanggal' => '26',
            ],
        ];
    }
}