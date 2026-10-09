<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;
use App\Models\GrowthLog;
use App\Support\ActivityLog;
use App\Support\FarmMetrics;
use App\Support\ScheduleData;

class DashboardController extends Controller
{
    public function index(Request $request, ScheduleData $scheduleData, FarmMetrics $farmMetrics, ActivityLog $activityLog)
    {
        $search = $request->input('search');
        $periodeOptions = [
            'hari' => 'Hari Ini',
            'minggu' => 'Minggu Ini',
            'bulan' => 'Bulan Ini',
            'semua' => 'Semua Data',
        ];
        $requestedPeriode = $request->input('periode', 'minggu');
        $periode = is_string($requestedPeriode) && array_key_exists($requestedPeriode, $periodeOptions)
            ? $requestedPeriode
            : 'minggu';
        $periodeLabel = $periodeOptions[$periode];

        $allJadwal = $scheduleData->all();
        $tugasHariIni = $allJadwal;
        $metrics = $farmMetrics->summarize($allJadwal);

        // Filter Pencarian jika ada
        if ($search) {
            $tugasHariIni = array_filter($tugasHariIni, function ($item) use ($search) {
                return stripos($item['judul'] ?? '', $search) !== false || 
                       stripos($item['sektor'] ?? '', $search) !== false ||
                       stripos($item['petugas'] ?? '', $search) !== false;
            });
        }

        $totalTugas = $metrics['totalTugas'];
        $tugasSelesai = $metrics['tugasSelesai'];
        $persentase = $totalTugas > 0 ? round(($tugasSelesai / $totalTugas) * 100) : 0;

        // 2. Data Sensor IoT Terbaru dari Database
        $latestSensor = SensorData::latest()->first();
        $sensorTanah  = $latestSensor?->kelembaban_tanah;
        $sensorSuhu   = $latestSensor?->suhu_udara;
        $sensorCahaya = $latestSensor?->intensitas_cahaya;
        $sensorPh     = $latestSensor?->ph_tanah;
        $sensorTerakhir = $latestSensor?->created_at?->format('d M Y, H:i');

        $notifikasi = $scheduleData->notifications($allJadwal);
        $activityFeed = array_map(function ($event) {
            return [
                'tipe' => 'primary',
                'judul' => $event['judul'],
                'waktu' => $event['tanggal'],
                'pesan' => $event['pesan'] . (($event['lokasi'] ?? '-') !== '-' ? ' · ' . $event['lokasi'] : ''),
            ];
        }, $activityLog->all());
        if (!$activityFeed) {
            $activityFeed = $notifikasi;
        }

        // 4. Grafik Pertumbuhan (Chart.js)
        $growthQuery = GrowthLog::select('day', 'actual', 'target')->orderBy('id', 'asc');
        if ($periode === 'hari') {
            $growthQuery->whereDate('created_at', today());
        } elseif ($periode === 'minggu') {
            $growthQuery->where('created_at', '>=', now()->startOfWeek());
        } elseif ($periode === 'bulan') {
            $growthQuery->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
        }
        $chartMinggu = $growthQuery->get()->toArray();

        return view('dashboard', array_merge($metrics, compact(
            'tugasHariIni',
            'notifikasi',
            'activityFeed',
            'search',
            'periode',
            'periodeLabel',
            'periodeOptions',
            'sensorTanah',
            'sensorSuhu',
            'sensorCahaya',
            'sensorPh',
            'sensorTerakhir',
            'chartMinggu',
            'persentase'
        )));
    }

    public function updateTugas(Request $request, $id, ScheduleData $scheduleData, ActivityLog $activityLog)
    {
        $status = $request->input('status');
        $jadwalList = $scheduleData->all();
        $updated = false;

        $updatedTask = null;
        foreach ($jadwalList as &$item) {
            if ((string) ($item['id'] ?? '') === (string) $id) {
                if ($status === 'selesai') {
                    $item['status'] = 'Selesai';
                    $item['badge'] = 'success';
                    $item['selesai'] = true;
                } else {
                    $item['status'] = 'Belum Mulai';
                    $item['badge'] = 'pending';
                    $item['selesai'] = false;
                }

                $updated = true;
                $updatedTask = $item;
                break;
            }
        }

        session()->put('jadwal_data', $jadwalList);
        if ($updatedTask) {
            $activityLog->record('Jadwal', 'Status tugas diperbarui', ($updatedTask['judul'] ?? 'Tugas') . ': ' . ($updatedTask['status'] ?? ''), $updatedTask['sektor'] ?? null);
        }

        return response()->json([
            'success' => $updated,
            'message' => $updated ? 'Status tugas berhasil diperbarui.' : 'Tugas tidak ditemukan.',
        ]);
    }
}