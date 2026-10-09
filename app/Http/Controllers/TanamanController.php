<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Support\ScheduleData;
use App\Support\ActivityLog;

class TanamanController extends Controller
{
    public function create()
    {
        return view('tanaman.create');
    }

    public function show($id)
    {
        $allData = session()->get('tanaman_data', ['halaman1' => [], 'halaman2' => []]);
        $tanamanList = array_merge($allData['halaman1'] ?? [], $allData['halaman2'] ?? []);
        $tanaman = collect($tanamanList)->firstWhere('id_tanaman', $id);

        if (!$tanaman) {
            abort(404);
        }

        return view('tanaman.index', [
            'tanamanList' => [$tanaman],
            'search' => '',
            'filterLahan' => '',
            'filterStatus' => '',
            'page' => 1,
            'notifikasi' => [],
        ]);
    }

    public function edit($id)
    {
        $allData = session()->get('tanaman_data', ['halaman1' => [], 'halaman2' => []]);
        $tanamanList = array_merge($allData['halaman1'] ?? [], $allData['halaman2'] ?? []);
        $tanaman = collect($tanamanList)->firstWhere('id_tanaman', $id);

        if (!$tanaman) {
            abort(404);
        }

        return view('tanaman.create', ['tanaman' => $tanaman, 'editMode' => true]);
    }

    public function index(Request $request, ScheduleData $scheduleData)
    {
        $search = $request->input('search');
        $filterLahan = $request->input('lahan');
        $filterStatus = $request->input('status');
        $page = $request->input('page', 1);

        if (!session()->has('tanaman_data')) {
            session()->put('tanaman_data', [
                'halaman1' => [],
                'halaman2' => []
            ]);
        }

        $allData = session()->get('tanaman_data');
        $tanamanList = ($page == 2) ? ($allData['halaman2'] ?? []) : ($allData['halaman1'] ?? []);

        // Filter Pencarian
        if ($search) {
            $tanamanList = array_filter($tanamanList, function ($item) use ($search) {
                return stripos($item['nama'] ?? '', $search) !== false || 
                       stripos($item['lokasi'] ?? '', $search) !== false || 
                       stripos($item['id_tanaman'] ?? '', $search) !== false;
            });
        }

        if ($filterLahan) {
            $tanamanList = array_filter($tanamanList, function ($item) use ($filterLahan) {
                return ($item['lokasi'] ?? '') === $filterLahan;
            });
        }

        if ($filterStatus) {
            $tanamanList = array_filter($tanamanList, function ($item) use ($filterStatus) {
                return ($item['status'] ?? '') === $filterStatus;
            });
        }

        $notifikasi = $scheduleData->notifications();

        return view('tanaman', compact('tanamanList', 'search', 'filterLahan', 'filterStatus', 'page', 'notifikasi'));
    }

    public function store(Request $request, ActivityLog $activityLog)
    {
        $imagePath = 'https://images.unsplash.com/photo-1592841200221-a6898f307baa?auto=format&fit=crop&w=600&q=80';
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $imagePath = asset('images/' . $filename);
        }

        $allData = session()->get('tanaman_data', ['halaman1' => [], 'halaman2' => []]);

        $nama = $request->input('nama') ?? $request->input('nama_tanaman');
        $lokasi = $request->input('lokasi') ?? $request->input('sektor', 'Sektor A');
        $populasi = (int) ($request->input('populasi') ?? $request->input('jumlah', 0));
        
        $newItem = [
            'id_tanaman'   => 'TR-' . rand(107, 999),
            'nama'         => $nama,
            'latin'        => $request->input('latin') ?? '-',
            'umur'         => 1,
            'populasi'     => $populasi,
            'lokasi'       => $lokasi,
            'est_panen'    => '90 Hari Lagi',
            'status'       => 'Sehat',
            'status_badge' => 'badge-soft-success',
            'image'        => $imagePath
        ];

        if (!isset($allData['halaman1'])) {
            $allData['halaman1'] = [];
        }

        array_unshift($allData['halaman1'], $newItem);
        session()->put('tanaman_data', $allData);
        $activityLog->record('Tanaman', 'Tanaman ditambahkan', $newItem['nama'] . ' (' . $newItem['populasi'] . ' tanaman) ditambahkan.', $newItem['lokasi']);

        return back()->with('success', 'Data tanaman berhasil ditambahkan!');
    }

    public function update(Request $request, $id, ActivityLog $activityLog)
    {
        $allData = session()->get('tanaman_data', ['halaman1' => [], 'halaman2' => []]);
        $updatedItem = null;

        foreach (['halaman1', 'halaman2'] as $hal) {
            if (isset($allData[$hal])) {
                foreach ($allData[$hal] as $key => $item) {
                    if (($item['id_tanaman'] ?? '') === $id) {
                        $allData[$hal][$key]['nama'] = $request->nama;
                        $allData[$hal][$key]['latin'] = $request->latin;
                        $allData[$hal][$key]['populasi'] = (int) $request->populasi;
                        $allData[$hal][$key]['lokasi'] = $request->lokasi;
                        $updatedItem = $allData[$hal][$key];

                        if ($request->hasFile('image')) {
                            $file = $request->file('image');
                            $filename = time() . '_' . $file->getClientOriginalName();
                            $file->move(public_path('images'), $filename);
                            $allData[$hal][$key]['image'] = asset('images/' . $filename);
                        }
                    }
                }
            }
        }

        session()->put('tanaman_data', $allData);
        if ($updatedItem) {
            $activityLog->record('Tanaman', 'Data tanaman diperbarui', ($updatedItem['nama'] ?? $id) . ' diperbarui.', $updatedItem['lokasi'] ?? null);
        }
        return back()->with('success', "Data tanaman {$id} berhasil diperbarui!");
    }

    public function storeCatatan(Request $request)
    {
        return back()->with('success', 'Catatan harian berhasil disimpan!');
    }

    public function importTemplate(Request $request)
    {
        return back()->with('success', 'Template berhasil diimpor!');
    }

    public function export(): StreamedResponse
    {
        $fileName = 'data_tanaman_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $allData = session()->get('tanaman_data', ['halaman1' => [], 'halaman2' => []]);
        $tanamanList = array_merge($allData['halaman1'] ?? [], $allData['halaman2'] ?? []);

        $callback = function() use ($tanamanList) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['ID Tanaman', 'Nama Varietas', 'Nama Latin', 'Umur (HST)', 'Populasi', 'Lokasi Sektor', 'Status', 'Estimasi Panen']);

            foreach ($tanamanList as $item) {
                fputcsv($file, [
                    $item['id_tanaman'] ?? '-',
                    $item['nama'] ?? '-',
                    $item['latin'] ?? '-',
                    $item['umur'] ?? 0,
                    $item['populasi'] ?? 0,
                    $item['lokasi'] ?? '-',
                    $item['status'] ?? '-',
                    $item['est_panen'] ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy($id, ActivityLog $activityLog)
    {
        $allData = session()->get('tanaman_data', ['halaman1' => [], 'halaman2' => []]);
        $deletedItem = collect(array_merge($allData['halaman1'] ?? [], $allData['halaman2'] ?? []))
            ->firstWhere('id_tanaman', $id);

        if (isset($allData['halaman1'])) {
            $allData['halaman1'] = array_values(array_filter($allData['halaman1'], function ($item) use ($id) {
                return ($item['id_tanaman'] ?? '') !== $id;
            }));
        }

        if (isset($allData['halaman2'])) {
            $allData['halaman2'] = array_values(array_filter($allData['halaman2'], function ($item) use ($id) {
                return ($item['id_tanaman'] ?? '') !== $id;
            }));
        }

        session()->put('tanaman_data', $allData);

        if ($deletedItem) {
            $activityLog->record('Tanaman', 'Tanaman dihapus', ($deletedItem['nama'] ?? $id) . ' dihapus.', $deletedItem['lokasi'] ?? null);
        }

        return back()->with('success', "Data tanaman {$id} berhasil dihapus.");
    }
}