<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\GrowthLog;
use App\Support\FarmMetrics;
use App\Support\ScheduleData;

class LaporanController extends Controller
{
    /**
     @param Request $request
     @return \Illuminate\View\View
     */
    public function index(Request $request, ScheduleData $scheduleData, FarmMetrics $farmMetrics)
    {
        $periode = $request->input('periode', 'bulan_ini');
        $kategori = $request->input('kategori', 'semua');
        $metrics = $farmMetrics->summarize($scheduleData->all());
        $growthLogs = GrowthLog::select('day', 'actual', 'target')->orderBy('id')->get()->toArray();

        return view('laporan', array_merge($metrics, compact('periode', 'kategori', 'growthLogs')));
    }

    /**
     @return \Illuminate\Http\Response
     */
    public function exportPdf(ScheduleData $scheduleData, FarmMetrics $farmMetrics)
    {
        $metrics = $farmMetrics->summarize($scheduleData->all());
        $pdf = Pdf::loadView('laporan-pdf', $metrics);

        return $pdf->download('laporan-smartfarm.pdf');
    }

    public function exportCsv(ScheduleData $scheduleData, FarmMetrics $farmMetrics)
    {
        $metrics = $farmMetrics->summarize($scheduleData->all());
        $rows = [
            ['Ringkasan', '', 'Populasi tanaman', '', $metrics['totalTanaman'], 'tanaman', ''],
            ['Ringkasan', '', 'Luas lahan aktif', '', number_format($metrics['totalLahan'], 2, '.', ''), 'Ha', ''],
            ['Ringkasan', '', 'Tugas terbuka', '', $metrics['tugasTerbuka'], 'tugas', ''],
            ['Ringkasan', '', 'Panen tercatat', '', number_format($metrics['panenTercatatTon'], 2, '.', ''), 'Ton', ''],
            ['Ringkasan', '', 'Catatan monitoring', '', $metrics['jumlahMonitoring'], 'catatan', ''],
            ['Ringkasan', '', 'Laporan hama', '', $metrics['jumlahLaporanHama'], 'laporan', ''],
        ];

        foreach ($metrics['lahanList'] as $lahan) {
            $rows[] = ['Lahan', $lahan['id'] ?? '', $lahan['nama'] ?? '', $lahan['sektor'] ?? '', $lahan['luas'] ?? '', $lahan['status'] ?? '', $lahan['komoditas'] ?? ''];
        }

        foreach ($metrics['tanamanList'] as $tanaman) {
            $rows[] = ['Tanaman', $tanaman['id_tanaman'] ?? '', $tanaman['nama'] ?? '', $tanaman['lokasi'] ?? '', $tanaman['populasi'] ?? 0, $tanaman['status'] ?? '', $tanaman['est_panen'] ?? ''];
        }

        foreach ($metrics['panenData'] as $panen) {
            $rows[] = ['Panen', $panen['id'] ?? '', $panen['komoditas'] ?? '', $panen['sektor'] ?? '', $panen['kuantitas'] ?? 0, $panen['grade'] ?? '', $panen['tanggal'] ?? ''];
        }

        return response()->streamDownload(function () use ($rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Jenis Data', 'ID', 'Nama / Metrik', 'Lokasi / Sektor', 'Nilai / Luas / Jumlah', 'Status / Grade', 'Catatan / Tanggal']);

            foreach ($rows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        }, 'laporan-smartfarm-' . date('Y-m-d') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}