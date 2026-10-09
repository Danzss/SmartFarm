<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tanaman;
use App\Models\Lahan;
use App\Models\TugasHarian;
use App\Models\SensorTelemetri;
use App\Models\Notifikasi;

class SmartFarmController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap parameter pencarian jika ada di URL (?search=...)
        $search = $request->input('search');

        // 2. Ambil data real dari Database (dengan kalkulasi jumlah/luas)
        $totalTanaman = Tanaman::sum('jumlah'); 
        $totalLahanAktif = Lahan::where('status', 'aktif')->sum('luas_ha');
        
        // 3. Query Tugas Harian (mendukung filter pencarian)
        $tugasQuery = TugasHarian::query();
        if ($search) {
            $tugasQuery->where('judul', 'like', "%{$search}%")
                       ->orWhere('deskripsi', 'like', "%{$search}%");
        }
        
        $tugasHariIni = $tugasQuery->whereDate('tanggal', today())->get()->map(function($tugas) {
            return [
                'id'    => $tugas->id,
                'judul' => $tugas->judul,
                'badge' => $tugas->prioritas,
                'badge_class' => $tugas->prioritas == 'Prioritas' ? 'bg-danger' : ($tugas->prioritas == 'Rutin' ? 'bg-warning text-dark' : 'bg-success'),
                'waktu' => date('H:i', strtotime($tugas->jam)) . ' WIB',
                'checked' => $tugas->status == 'selesai'
            ];
        });

        // 4. Ambil data telemetri sensor IoT terbaru (baris terakhir)
        $sensorTerbaru = SensorTelemetri::latest()->first();

        // 5. Ambil data notifikasi / aktivitas terbaru
        $notifikasiQuery = Notifikasi::latest();
        if ($search) {
            $notifikasiQuery->where('judul', 'like', "%{$search}%")
                            ->orWhere('pesan', 'like', "%{$search}%");
        }
        
        $notifikasi = $notifikasiQuery->take(5)->get()->map(function($notif) {
            return [
                'judul' => $notif->judul,
                'pesan' => $notif->pesan,
                'waktu' => $notif->created_at ? $notif->created_at->diffForHumans() : 'Baru saja',
                'tipe' => $notif->tipe ?? 'success'
            ];
        });

        // 6. Kirim data real ke View Blade (misal: dashboard.index)
        return view('dashboard.index', compact(
            'totalTanaman',
            'totalLahanAktif',
            'tugasHariIni',
            'sensorTerbaru',
            'notifikasi',
            'search'
        ));
    }

    // Fungsi tambahan untuk mengubah status tugas via AJAX/Fetch
    public function updateStatusTugas(Request $request, $id)
    {
        $tugas = TugasHarian::findOrFail($id);
        $tugas->status = $request->input('status'); // 'selesai' atau 'pending'
        $tugas->save();

        return response()->json([
            'success' => true,
            'message' => 'Status tugas berhasil diperbarui.'
        ]);
    }
}