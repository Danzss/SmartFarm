<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\ActivityLog;

class LahanController extends Controller
{
    private function getDefaultLahan()
    {
        return [
            [
                'id' => 1,
                'nama' => 'Greenhouse Terpadu Alfa',
                'sektor' => 'Sektor A • Greenhouse',
                'komoditas' => 'Tompat Cherry Premium (Lycopersicon esculentum)',
                'luas' => '6.2 Ha',
                'status' => 'Optimal & Cukup Panen',
                'badge' => 'success',
                'suhu' => '26.4°C',
                'kelembaban' => '68%',
                'tanah' => 'AEROPONIK',
                'irigasi' => 'Drip IoT',
                'node' => 'Node A1 - A12 (12 Unit Active)',
                'latitude' => -6.8115,
                'longitude' => 107.6135,
            ],
            [
                'id' => 2,
                'nama' => 'Hidroponik Vertikal Modul 2',
                'sektor' => 'Sektor B • Hidroponik NFT',
                'komoditas' => 'Selada Keriting Hijau (Lactuca sativa)',
                'luas' => '5.0 Ha',
                'status' => 'Aktif • Perawatan Rutin',
                'badge' => 'info',
                'suhu' => '6.2 pH',
                'kelembaban' => '1.8 mS',
                'tanah' => 'Bak 4 Tingkat',
                'irigasi' => 'Pompa NFT',
                'node' => 'Modul Hidroponik B1 - B8',
                'latitude' => -6.8110,
                'longitude' => 107.6165,
            ]
        ];
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');
        $status = $request->input('status');

        if (!session()->has('lahan_data')) {
            session()->put('lahan_data', $this->getDefaultLahan());
        }

        $allLahan = session()->get('lahan_data');
        $lahanList = $allLahan;

        // Filter Pencarian Global
        if ($search) {
            $lahanList = array_filter($lahanList, function ($item) use ($search) {
                return stripos($item['nama'] ?? '', $search) !== false || 
                       stripos($item['komoditas'] ?? '', $search) !== false ||
                       stripos($item['sektor'] ?? '', $search) !== false;
            });
        }

        // Filter Dropdown Kategori
        if ($kategori) {
            $lahanList = array_filter($lahanList, function ($item) use ($kategori) {
                return stripos($item['tanah'] ?? '', $kategori) !== false || 
                       stripos($item['irigasi'] ?? '', $kategori) !== false ||
                       stripos($item['sektor'] ?? '', $kategori) !== false;
            });
        }

        // Filter Status
        if ($status) {
            $lahanList = array_filter($lahanList, function ($item) use ($status) {
                return ($item['status'] ?? '') === $status;
            });
        }

        $lahanList = array_values($lahanList);
        $statusOptions = collect($allLahan)->pluck('status')->filter()->unique()->values();
        $kategoriOptions = collect($allLahan)->flatMap(function ($item) {
            return [$item['tanah'] ?? null, $item['irigasi'] ?? null, $item['sektor'] ?? null];
        })->filter()->unique()->values();
        $totalLuas = collect($allLahan)->sum(function ($item) {
            preg_match('/[0-9]+(?:\.[0-9]+)?/', $item['luas'] ?? '', $match);
            return (float) ($match[0] ?? 0);
        });
        $irigasiCount = collect($allLahan)->pluck('irigasi')->filter()->unique()->count();
        $lahanDenganNode = collect($allLahan)->filter(function ($item) {
            return !empty($item['node']);
        })->count();
        $catatanList = array_slice(session()->get('lahan_catatan', []), 0, 5);
        $katupData = session()->get('katup_data', []);

        return view('lahan', compact('lahanList', 'allLahan', 'search', 'kategori', 'status', 'statusOptions', 'kategoriOptions', 'totalLuas', 'irigasiCount', 'lahanDenganNode', 'catatanList', 'katupData'));
    }

    public function store(Request $request, ActivityLog $activityLog)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:120',
            'sektor' => 'required|string|max:120',
            'komoditas' => 'required|string|max:160',
            'luas' => 'required|numeric|min:0.01|max:100000',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $lahanData = session()->get('lahan_data', $this->getDefaultLahan());

        $newLahan = [
            'id' => (count($lahanData) ? max(array_column($lahanData, 'id')) : 0) + 1,
            'nama' => $validated['nama'],
            'sektor' => $validated['sektor'],
            'komoditas' => $validated['komoditas'],
            'luas' => number_format((float) $validated['luas'], 2, '.', '') . ' Ha',
            'status' => 'Aktif • Baru Didaftarkan',
            'badge' => 'success',
            'suhu' => '27.0°C',
            'kelembaban' => '70%',
            'tanah' => 'ORGANIK',
            'irigasi' => 'Sprinkler',
            'node' => 'Node C1 - C4',
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ];

        array_unshift($lahanData, $newLahan);
        session()->put('lahan_data', $lahanData);
        $activityLog->record('Lahan', 'Lahan ditambahkan', $newLahan['nama'] . ' ditambahkan.', $newLahan['sektor']);

        return back()->with('success', 'Lahan atau greenhouse baru berhasil ditambahkan ke sistem!');
    }

    public function update(Request $request, $id, ActivityLog $activityLog)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:120',
            'sektor' => 'required|string|max:120',
            'komoditas' => 'required|string|max:160',
            'luas' => 'required|numeric|min:0.01|max:100000',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);
        $lahanData = session()->get('lahan_data', $this->getDefaultLahan());
        $found = false;

        foreach ($lahanData as $key => $item) {
            if (($item['id'] ?? null) == $id) {
                $lahanData[$key] = array_merge($item, [
                    'nama' => $validated['nama'],
                    'sektor' => $validated['sektor'],
                    'komoditas' => $validated['komoditas'],
                    'luas' => number_format((float) $validated['luas'], 2, '.', '') . ' Ha',
                    'latitude' => $validated['latitude'] ?? null,
                    'longitude' => $validated['longitude'] ?? null,
                ]);
                $found = true;
                break;
            }
        }

        abort_unless($found, 404);
        session()->put('lahan_data', $lahanData);
        $activityLog->record('Lahan', 'Data lahan diperbarui', $validated['nama'] . ' diperbarui.', $validated['sektor']);
        return back()->with('success', "Data sektor lahan ID #{$id} berhasil diperbarui.");
    }

    public function destroy($id, ActivityLog $activityLog)
    {
        $lahanData = session()->get('lahan_data', $this->getDefaultLahan());
        $deletedLahan = collect($lahanData)->firstWhere('id', $id);
        $remaining = array_values(array_filter($lahanData, function ($item) use ($id) {
            return (string) ($item['id'] ?? '') !== (string) $id;
        }));

        abort_if(count($remaining) === count($lahanData), 404);
        session()->put('lahan_data', $remaining);
        $activityLog->record('Lahan', 'Lahan dihapus', ($deletedLahan['nama'] ?? "Lahan #{$id}") . ' dihapus.', $deletedLahan['sektor'] ?? null);

        return back()->with('success', "Lahan ID #{$id} berhasil dihapus.");
    }

    public function catatData(Request $request, ActivityLog $activityLog)
    {
        $validated = $request->validate([
            'lahan_id' => 'required|integer',
            'catatan' => 'required|string|max:2000',
        ]);
        $lahanData = session()->get('lahan_data', $this->getDefaultLahan());
        $lahan = collect($lahanData)->firstWhere('id', (int) $validated['lahan_id']);
        abort_unless($lahan, 404);

        $catatanList = session()->get('lahan_catatan', []);
        array_unshift($catatanList, [
            'lahan_id' => (int) $validated['lahan_id'],
            'nama_lahan' => $lahan['nama'],
            'catatan' => $validated['catatan'],
            'waktu' => now()->format('d/m/Y H:i'),
        ]);
        session()->put('lahan_catatan', array_slice($catatanList, 0, 100));
        $activityLog->record('Catatan lahan', 'Catatan agronomis dibuat', $validated['catatan'], $lahan['nama'] ?? null);

        return back()->with('success', 'Catatan harian agronomis berhasil disimpan.');
    }

    public function aturKatup(Request $request, ActivityLog $activityLog)
    {
        $validated = $request->validate([
            'lahan_id' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
            'jadwal' => 'nullable|date_format:H:i',
        ]);
        $lahanData = session()->get('lahan_data', $this->getDefaultLahan());
        abort_unless(collect($lahanData)->contains('id', (int) $validated['lahan_id']), 404);

        $katupData = session()->get('katup_data', []);
        $katupData[$validated['lahan_id']] = [
            'status' => $validated['status'],
            'jadwal' => $validated['jadwal'] ?? null,
            'diperbarui' => now()->format('d/m/Y H:i'),
        ];
        session()->put('katup_data', $katupData);
        $activityLog->record('Irigasi', 'Status katup diperbarui', 'Katup ' . $validated['status'] . ($validated['jadwal'] ? ' pukul ' . $validated['jadwal'] : '') . '.', (string) $validated['lahan_id']);

        return back()->with('success', 'Pengaturan katup irigasi berhasil disimpan.');
    }

    public function exportPeta()
    {
        $lahanData = session()->get('lahan_data', $this->getDefaultLahan());
        
        $fileName = 'peta-lahan-smartfarm-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($lahanData) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['ID', 'Nama Lahan', 'Sektor', 'Komoditas', 'Luas', 'Status', 'Suhu', 'Kelembaban', 'Jenis Tanah', 'Irigasi', 'Node IoT', 'Latitude', 'Longitude']);

            foreach ($lahanData as $item) {
                fputcsv($file, [
                    $item['id'] ?? '', $item['nama'] ?? '', $item['sektor'] ?? '',
                    $item['komoditas'] ?? '', $item['luas'] ?? '', $item['status'] ?? '',
                    $item['suhu'] ?? '', $item['kelembaban'] ?? '', $item['tanah'] ?? '',
                    $item['irigasi'] ?? '', $item['node'] ?? '', $item['latitude'] ?? '',
                    $item['longitude'] ?? '',
                ]);
            }

            fclose($file);
        }, $fileName, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function logAktivitas($id)
    {
        $lahan = $this->findLahan($id);
        $catatanList = array_values(array_filter(session()->get('lahan_catatan', []), function ($catatan) use ($id) {
            return (string) ($catatan['lahan_id'] ?? '') === (string) $id;
        }));

        return view('lahan-detail', ['lahan' => $lahan, 'detailType' => 'log', 'catatanList' => $catatanList]);
    }

    public function detailSensor($id)
    {
        return view('lahan-detail', [
            'lahan' => $this->findLahan($id),
            'detailType' => 'sensor',
            'catatanList' => [],
        ]);
    }

    public function urusSegera($id, ActivityLog $activityLog)
    {
        $lahanData = session()->get('lahan_data', $this->getDefaultLahan());
        $found = false;
        foreach ($lahanData as $key => $item) {
            if ($item['id'] == $id) {
                $lahanData[$key]['status'] = 'Perawatan Darurat';
                $lahanData[$key]['badge'] = 'warning';
                $found = true;
                break;
            }
        }

        abort_unless($found, 404);
        session()->put('lahan_data', $lahanData);
        $urgentLahan = collect($lahanData)->firstWhere('id', $id);
        $activityLog->record('Perawatan', 'Perawatan darurat diaktifkan', $urgentLahan['nama'] ?? "Lahan #{$id}", $urgentLahan['sektor'] ?? null);
        return back()->with('success', "Perawatan darurat untuk Sektor Lahan ID #{$id} telah diaktifkan.");
    }

    private function findLahan($id): array
    {
        $lahanData = session()->get('lahan_data', $this->getDefaultLahan());
        $lahan = collect($lahanData)->first(function ($item) use ($id) {
            return (string) ($item['id'] ?? '') === (string) $id;
        });

        abort_unless($lahan, 404);

        return $lahan;
    }
}