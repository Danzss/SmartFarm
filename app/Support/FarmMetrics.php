<?php

namespace App\Support;

use App\Models\Monitoring;

class FarmMetrics
{
    public function summarize(array $schedule): array
    {
        $tanamanData = session()->get('tanaman_data', ['halaman1' => [], 'halaman2' => []]);
        $tanamanList = array_merge($tanamanData['halaman1'] ?? [], $tanamanData['halaman2'] ?? []);
        $tanamanSummary = collect($tanamanList)
            ->groupBy(fn ($item) => trim($item['nama'] ?? '') ?: 'Tanaman tanpa nama')
            ->map(function ($items, $nama) {
                return [
                    'nama' => $nama,
                    'populasi' => $items->sum(fn ($item) => (int) ($item['populasi'] ?? 0)),
                    'lokasi' => $items->pluck('lokasi')->filter()->unique()->implode(', '),
                ];
            })->values();
        $totalTanaman = collect($tanamanList)->sum(fn ($item) => (int) ($item['populasi'] ?? 0));

        $lahanData = collect(session()->get('lahan_data', []));
        $lahanAktif = $lahanData->filter(function ($item) {
            $status = strtolower($item['status'] ?? '');
            return !str_contains($status, 'nonaktif') && !str_contains($status, 'tidak aktif');
        });
        $totalLahan = $lahanAktif->sum(function ($item) {
            preg_match('/[0-9]+(?:[.,][0-9]+)?/', (string) ($item['luas'] ?? ''), $match);
            return (float) str_replace(',', '.', $match[0] ?? '0');
        });
        $lahanPerluPerhatian = $lahanData->filter(function ($item) {
            return preg_match('/darurat|perlu tindakan/i', $item['status'] ?? '') === 1;
        })->count();
        $tanamanPerluPerhatian = collect($tanamanList)->filter(function ($item) {
            $status = strtolower(trim($item['status'] ?? ''));
            return $status !== '' && !in_array($status, ['sehat', 'baik', 'normal', 'optimal'], true);
        })->count();

        $tugasSelesai = count(array_filter($schedule, function ($item) {
            return (bool) ($item['selesai'] ?? false) || ($item['status'] ?? '') === 'Selesai';
        }));
        $tugasTerbuka = count(array_filter($schedule, function ($item) {
            return !(bool) ($item['selesai'] ?? false) && ($item['status'] ?? '') !== 'Selesai';
        }));
        $totalTugas = count($schedule);

        $panenData = session()->get('panen_data', []);
        $hamaReports = session()->get('hama_reports', []);

        return [
            'tanamanList' => $tanamanList,
            'tanamanSummary' => $tanamanSummary,
            'totalTanaman' => $totalTanaman,
            'lahanList' => $lahanData->values(),
            'lahanAktif' => $lahanAktif->values(),
            'totalLahan' => $totalLahan,
            'jumlahLahanAktif' => $lahanAktif->count(),
            'jumlahSektorAktif' => $lahanAktif->pluck('sektor')->filter()->unique()->count(),
            'lahanPerluPerhatian' => $lahanPerluPerhatian,
            'tanamanPerluPerhatian' => $tanamanPerluPerhatian,
            'tugasSelesai' => $tugasSelesai,
            'tugasTerbuka' => $tugasTerbuka,
            'totalTugas' => $totalTugas,
            'butuhTindakan' => $tugasTerbuka + $lahanPerluPerhatian + $tanamanPerluPerhatian,
            'panenData' => $panenData,
            'panenTercatatTon' => collect($panenData)->sum(fn ($item) => (float) ($item['kuantitas'] ?? 0)) / 1000,
            'jumlahCatatanPanen' => count($panenData),
            'jumlahMonitoring' => Monitoring::count(),
            'hamaReports' => $hamaReports,
            'jumlahLaporanHama' => count($hamaReports),
        ];
    }
}
