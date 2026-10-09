<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\ScheduleData;
use App\Support\ActivityLog;

class JadwalController extends Controller
{
    public function index(Request $request, ScheduleData $scheduleData)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');
        $sektor = $request->input('sektor');
        $tanggal = $request->input('tanggal', '25');
        $view = $request->input('view', 'agenda');

        $allJadwal = $scheduleData->all();
        $jadwalList = $allJadwal;

        // Filter Tanggal
        if ($tanggal) {
            $jadwalList = array_filter($jadwalList, function ($item) use ($tanggal) {
                return isset($item['tanggal']) && $item['tanggal'] == $tanggal;
            });
        }

        // Filter Pencarian
        if ($search) {
            $jadwalList = array_filter($jadwalList, function ($item) use ($search) {
                return stripos($item['judul'] ?? '', $search) !== false || 
                       stripos($item['sektor'] ?? '', $search) !== false ||
                       stripos($item['petugas'] ?? '', $search) !== false;
            });
        }

        // Filter Kategori
        if ($kategori && $kategori !== 'Semua') {
            $jadwalList = array_filter($jadwalList, function ($item) use ($kategori) {
                return strcasecmp($item['kategori'] ?? '', $kategori) === 0;
            });
        }

        // Filter Sektor
        if ($sektor && $sektor !== 'Semua Sektor') {
            $jadwalList = array_filter($jadwalList, function ($item) use ($sektor) {
                return stripos($item['sektor'] ?? '', $sektor) !== false;
            });
        }

        $totalTugas = count($jadwalList);
        $tugasSelesai = count(array_filter($jadwalList, function ($item) {
            return isset($item['selesai']) && $item['selesai'] === true;
        }));
        
        $persentase = $totalTugas > 0 ? round(($tugasSelesai / $totalTugas) * 100) : 0;

        // Menghitung data dinamis untuk Chart berdasarkan pengelompokan tanggal yang ada di session
        $chartLabels = ['Tgl 23', 'Tgl 24', 'Tgl 25', 'Tgl 26', 'Tgl 27', 'Tgl 28', 'Tgl 29'];
        $chartData = [];

        foreach (['23', '24', '25', '26', '27', '28', '29'] as $tgl) {
            $tugasHariIni = array_filter($allJadwal, function ($item) use ($tgl) {
                return isset($item['tanggal']) && $item['tanggal'] == $tgl;
            });
            $totalHariIni = count($tugasHariIni);
            $selesaiHariIni = count(array_filter($tugasHariIni, function ($item) {
                return isset($item['selesai']) && $item['selesai'] === true;
            }));

            // Jika ada tugas, hitung persentasenya. Jika kosong, berikan nilai default atau 0.
            $chartData[] = $totalHariIni > 0 ? round(($selesaiHariIni / $totalHariIni) * 100) : (intval($tgl) <= intval($tanggal) ? 75 : 0);
        }

        return view('jadwal', compact(
            'jadwalList', 'search', 'kategori', 'sektor', 'tanggal', 'view', 
            'totalTugas', 'tugasSelesai', 'persentase', 'chartLabels', 'chartData'
        ));
    }

    public function store(Request $request, ScheduleData $scheduleData, ActivityLog $activityLog)
    {
        $jadwalList = $scheduleData->all();
        
        $newItem = [
            'id' => time(),
            'judul' => $request->input('judul'),
            'kategori' => $request->input('kategori'),
            'sektor' => $request->input('sektor'),
            'waktu' => $request->input('waktu'),
            'petugas' => $request->input('petugas'),
            'status' => 'Belum Mulai',
            'badge' => 'pending',
            'selesai' => false,
            'tanggal' => $request->input('tanggal', '25')
        ];

        array_unshift($jadwalList, $newItem);
        session()->put('jadwal_data', $jadwalList);
        $activityLog->record('Jadwal', 'Jadwal dibuat', $newItem['judul'], $newItem['sektor']);

        return redirect()->route('jadwal.index', ['tanggal' => $newItem['tanggal']])->with('success', 'Jadwal baru berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $id, ScheduleData $scheduleData, ActivityLog $activityLog)
    {
        $aksi = $request->input('aksi');
        $jadwalList = $scheduleData->all();
        $updatedTask = null;

        foreach ($jadwalList as &$item) {
            if ($item['id'] == $id) {
                if ($aksi === 'mulai') {
                    $item['status'] = 'Sedang Berjalan';
                    $item['badge'] = 'success';
                    $item['selesai'] = false;
                } elseif ($aksi === 'pause') {
                    $item['status'] = 'Menunggu';
                    $item['badge'] = 'warning';
                    $item['selesai'] = false;
                } elseif ($aksi === 'selesai') {
                    $item['status'] = 'Selesai';
                    $item['badge'] = 'success';
                    $item['selesai'] = true;
                }
                $updatedTask = $item;
            }
        }

        session()->put('jadwal_data', $jadwalList);
        if ($updatedTask) {
            $activityLog->record('Jadwal', 'Status jadwal diperbarui', ($updatedTask['judul'] ?? 'Jadwal') . ': ' . ($updatedTask['status'] ?? $aksi), $updatedTask['sektor'] ?? null);
        }
        return redirect()->back()->with('success', 'Status jadwal berhasil diperbarui!');
    }

    public function destroy($id, ScheduleData $scheduleData, ActivityLog $activityLog)
    {
        $jadwalList = $scheduleData->all();
        $deletedTask = collect($jadwalList)->firstWhere('id', $id);
        
        $jadwalList = array_values(array_filter($jadwalList, function ($item) use ($id) {
            return $item['id'] != $id;
        }));

        session()->put('jadwal_data', $jadwalList);
        if ($deletedTask) {
            $activityLog->record('Jadwal', 'Jadwal dihapus', $deletedTask['judul'] ?? "Jadwal #{$id}", $deletedTask['sektor'] ?? null);
        }
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
    }
}