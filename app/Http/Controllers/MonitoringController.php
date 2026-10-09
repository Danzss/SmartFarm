<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;
use App\Support\ActivityLog;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $lokasi = $request->input('lokasi', 'Sektor A1 - Tomat Cherry Sweet Gold');
        $rentang = $request->input('rentang', '28 Hari Terakhir');
        $fokus = $request->input('fokus', 'Tinggi & Vigor (Tingkat)');

        $logs = $this->getLogs();

        return view('monitoring', compact('logs', 'lokasi', 'rentang', 'fokus'));
    }

    public function store(Request $request, ActivityLog $activityLog)
    {
        $request->validate([
            'komoditas' => 'required',
            'minggu_petak' => 'required',
            'tinggi_tanaman' => 'required',
            'warna_daun' => 'required',
            'ketebalan_batang' => 'required',
            'proporsi_bunga' => 'required',
        ]);

        // Handle Upload Foto
        $fotoUrl = 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=500&q=80';
        if ($request->hasFile('foto_pengamatan')) {
            $path = $request->file('foto_pengamatan')->store('public/monitoring');
            $fotoUrl = asset('storage/' . str_replace('public/', '', $path));
        }

        $catatan = trim((string) $request->input('catatan_lapangan', ''));
        if ($catatan === '') {
            $catatan = 'Inspeksi manual komoditas ' . $request->input('komoditas', 'pertanian') . '.';
        }

        // Simpan ke Database MySQL menggunakan Model Monitoring
        Monitoring::create([
            'tanggal' => 'Baru Saja, ' . date('H:i') . ' WIB',
            'petugas' => auth()->user()->name ?? 'Farm Manager',
            'fase' => 'Inspeksi Periode ' . $request->input('minggu_petak'),
            'tinggi' => $request->input('tinggi_tanaman'),
            'kondisi' => $request->input('warna_daun'),
            'status_bunga' => $request->input('proporsi_bunga'),
            'foto' => $fotoUrl,
            'catatan' => $catatan,
        ]);
        $activityLog->record(
            'Monitoring',
            'Inspeksi monitoring dicatat',
            'Periode ' . $request->input('minggu_petak') . ', tinggi ' . $request->input('tinggi_tanaman') . ', kondisi ' . $request->input('warna_daun') . '.',
            $request->input('komoditas')
        );

        return redirect()->route('monitoring.index')->with('success', 'Data inspeksi dan catatan monitoring baru berhasil disimpan!');
    }

    public function exportCsv()
    {
        $logs = $this->getLogs();

        return response()->streamDownload(function () use ($logs) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Tanggal', 'Petugas', 'Fase', 'Tinggi Tanaman', 'Kondisi Daun', 'Status Bunga', 'Catatan']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log['tanggal'] ?? '',
                    $log['petugas'] ?? '',
                    $log['fase'] ?? '',
                    $log['tinggi'] ?? '',
                    $log['kondisi'] ?? '',
                    $log['status_bunga'] ?? '',
                    $log['catatan'] ?? '',
                ]);
            }

            fclose($file);
        }, 'log-monitoring-' . date('Y-m-d') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function getLogs(): array
    {
        return Monitoring::latest()->get()->toArray();
    }
}