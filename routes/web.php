<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Support\ScheduleData;
use App\Support\ActivityLog;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TanamanController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DeteksiAiController; // <-- 1. TAMBAHKAN INI

// Redirect ke dashboard jika sudah login, jika belum dialihkan ke login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

// Middleware auth untuk semua route internal SmartFarm
Route::middleware(['auth'])->group(function () {

    // ---------------- DASHBOARD ----------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/tugas/{id}', [DashboardController::class, 'updateTugas'])->name('dashboard.tugas.update');

    // ---------------- TANAMAN & VARIETAS ----------------
    Route::get('/tanaman/export', [TanamanController::class, 'export'])->name('tanaman.export');
    Route::post('/tanaman/import', [TanamanController::class, 'importTemplate'])->name('tanaman.import');
    Route::post('/tanaman/catatan', [TanamanController::class, 'storeCatatan'])->name('tanaman.catatan');
    Route::resource('tanaman', TanamanController::class);

    // ---------------- LAHAN ----------------
    Route::get('/lahan', [LahanController::class, 'index'])->name('lahan.index');
    Route::post('/lahan', [LahanController::class, 'store'])->name('lahan.store');
    Route::put('/lahan/{id}', [LahanController::class, 'update'])->name('lahan.update');
    Route::delete('/lahan/{id}', [LahanController::class, 'destroy'])->name('lahan.destroy');
    Route::post('/lahan/catat-data', [LahanController::class, 'catatData'])->name('lahan.catat');
    Route::post('/lahan/atur-katup', [LahanController::class, 'aturKatup'])->name('lahan.katup');
    Route::get('/lahan/export-peta', [LahanController::class, 'exportPeta'])->name('lahan.export');
    Route::get('/lahan/{id}/log', [LahanController::class, 'logAktivitas'])->name('lahan.log');
    Route::get('/lahan/{id}/sensor', [LahanController::class, 'detailSensor'])->name('lahan.sensor');
    Route::post('/lahan/{id}/urus', [LahanController::class, 'urusSegera'])->name('lahan.urus');

    // ---------------- JADWAL ----------------
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal/{id}/status', [JadwalController::class, 'updateStatus'])->name('jadwal.status');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // ---------------- NOTIFIKASI ----------------
    Route::get('/notifikasi', function (ScheduleData $scheduleData) {
        $notifikasiList = $scheduleData->notifications();
        $totalTugas = count($notifikasiList);
        $tugasSelesai = count(array_filter($notifikasiList, fn ($item) => $item['selesai']));

        return view('notifikasi', compact('notifikasiList', 'totalTugas', 'tugasSelesai'));
    })->name('notifikasi.index');

    // ---------------- MONITORING ----------------
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::post('/monitoring', [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::get('/monitoring/export', [MonitoringController::class, 'exportCsv'])->name('monitoring.export');
    Route::post('/monitoring/refresh', function () {
        return back()->with('success', 'Data sensor IoT berhasil disinkronkan ulang!');
    })->name('monitoring.refresh');

    // ---------------- DETEKSI AI ----------------
    Route::get('/deteksi-ai', [DeteksiAiController::class, 'index'])->name('deteksi-ai.index');
    Route::post('/deteksi-ai/proses', [DeteksiAiController::class, 'proses'])->name('deteksi-ai.proses');

    Route::get('/ai-deteksi', function () {
        return redirect()->route('deteksi-ai.index');
    })->name('ai-deteksi.index');

    // ---------------- HAMA & PENYAKIT ----------------
    Route::get('/hama-penyakit', function (ScheduleData $scheduleData) {
        $hamaReports = session()->get('hama_reports', []);
        $laporanPrioritas = count(array_filter($hamaReports, fn ($report) => ($report['tingkat'] ?? '') === 'tinggi'));
        $jadwalSemprotAktif = count(array_filter($scheduleData->all(), function ($task) {
            return ($task['kategori'] ?? '') === 'Pengobatan' && !($task['selesai'] ?? false);
        }));

        return view('hama', compact('hamaReports', 'laporanPrioritas', 'jadwalSemprotAktif'));
    })->name('hama.index');

    Route::get('/hama', function (ScheduleData $scheduleData) {
        $hamaReports = session()->get('hama_reports', []);
        $laporanPrioritas = count(array_filter($hamaReports, fn ($report) => ($report['tingkat'] ?? '') === 'tinggi'));
        $jadwalSemprotAktif = count(array_filter($scheduleData->all(), function ($task) {
            return ($task['kategori'] ?? '') === 'Pengobatan' && !($task['selesai'] ?? false);
        }));

        return view('hama', compact('hamaReports', 'laporanPrioritas', 'jadwalSemprotAktif'));
    })->name('hama.alt');

    Route::post('/hama/laporan', function (Request $request, ActivityLog $activityLog) {
        $data = $request->validate([
            'tanaman' => 'required|string|max:100',
            'gejala' => 'required|string|max:500',
            'lokasi' => 'required|string|max:120',
            'tingkat' => 'required|in:rendah,sedang,tinggi',
        ]);

        $report = array_merge($data, [
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'tanggal' => now()->format('d M Y H:i'),
            'status' => 'Belum ditangani',
        ]);
        $reports = session()->get('hama_reports', []);
        array_unshift($reports, $report);
        session()->put('hama_reports', array_slice($reports, 0, 100));
        $activityLog->record('Hama/Penyakit', 'Gejala dilaporkan', $data['tanaman'] . ': ' . $data['gejala'], $data['lokasi']);

        return redirect()->route('hama.index')->with('success', 'Laporan gejala berhasil dicatat.');
    })->name('hama.report');

    Route::post('/hama/jadwal', function (Request $request, ScheduleData $scheduleData, ActivityLog $activityLog) {
        $data = $request->validate([
            'judul' => 'required|string|max:160',
            'sektor' => 'required|string|max:120',
            'tanggal' => 'required|date',
            'waktu' => 'required|string|max:60',
            'petugas' => 'required|string|max:120',
        ]);

        $schedule = $scheduleData->all();
        $task = array_merge($data, [
            'id' => (count($schedule) ? max(array_column($schedule, 'id')) : 0) + 1,
            'kategori' => 'Pengobatan',
            'status' => 'Belum Mulai',
            'badge' => 'pending',
            'selesai' => false,
            'tanggal' => \Illuminate\Support\Carbon::parse($data['tanggal'])->format('d'),
        ]);
        array_unshift($schedule, $task);
        session()->put('jadwal_data', $schedule);
        $activityLog->record('Jadwal', 'Penyemprotan ditambahkan ke jadwal', $task['judul'], $task['sektor']);

        return redirect()->route('jadwal.index')->with('success', 'Tindakan hama ditambahkan ke jadwal.');
    })->name('hama.jadwal');

    // ---------------- RIWAYAT ----------------
    Route::get('/riwayat/export', function (ActivityLog $activityLog) {
        $logs = $activityLog->all();
        return response()->streamDownload(function () use ($logs) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Waktu & Tanggal', 'Jenis Kegiatan', 'Aktivitas', 'Detail', 'Lahan / Sektor', 'Pelaksana']);
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log['tanggal'] ?? '', $log['kategori'] ?? '', $log['judul'] ?? '',
                    $log['pesan'] ?? '', $log['lokasi'] ?? '', $log['petugas'] ?? '',
                ]);
            }
            fclose($file);
        }, 'riwayat-kegiatan-' . date('Y-m-d') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    })->name('riwayat.export');

    Route::get('/riwayat', function (Request $request, ActivityLog $activityLog) {
        $allActivities = $activityLog->all();
        $search = trim((string) $request->query('search', ''));
        $kategori = $request->query('kategori', '');
        $activities = array_values(array_filter($allActivities, function ($activity) use ($search, $kategori) {
            $matchesCategory = !$kategori || ($activity['kategori'] ?? '') === $kategori;
            $searchText = implode(' ', [
                $activity['judul'] ?? '', $activity['pesan'] ?? '',
                $activity['lokasi'] ?? '', $activity['petugas'] ?? '',
            ]);
            return $matchesCategory && (!$search || stripos($searchText, $search) !== false);
        }));
        $activityCounts = collect($allActivities)->countBy('kategori');

        return view('riwayat', [
            'activities' => $activities,
            'totalActivities' => count($allActivities),
            'activityCounts' => $activityCounts,
            'search' => $search,
            'kategori' => $kategori,
            'categories' => $activityCounts->keys(),
        ]);
    })->name('riwayat.index');

    Route::post('/riwayat', function (Request $request, ActivityLog $activityLog) {
        $data = $request->validate([
            'kategori' => 'required|string|max:80',
            'judul' => 'required|string|max:160',
            'pesan' => 'required|string|max:1000',
            'lokasi' => 'nullable|string|max:120',
        ]);

        $activityLog->record($data['kategori'], $data['judul'], $data['pesan'], $data['lokasi'] ?? null);

        return redirect()->route('riwayat.index')->with('success', 'Catatan aktivitas berhasil disimpan.');
    })->name('riwayat.store');

    // ---------------- PANEN ----------------
    Route::get('/panen/export', function () {
        $records = array_map(function ($record) {
            return [
                $record['id'] ?? '', $record['tanggal'] ?? '', $record['komoditas'] ?? '',
                $record['sektor'] ?? '', $record['kuantitas'] ?? 0, $record['grade'] ?? '',
                $record['distribusi'] ?? 'Belum didistribusikan',
            ];
        }, session()->get('panen_data', []));

        return response()->streamDownload(function () use ($records) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['ID Panen', 'Tanggal', 'Komoditas', 'Lahan / Sektor', 'Kuantitas (Kg)', 'Grade / Mutu', 'Status Distribusi']);
            foreach ($records as $record) {
                fputcsv($file, $record);
            }
            fclose($file);
        }, 'rekap-panen-' . date('Y-m-d') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    })->name('panen.export');

    Route::get('/panen', function () {
        $panenRecords = session()->get('panen_data', []);
        $totalPanenKg = collect($panenRecords)->sum(fn ($record) => (float) ($record['kuantitas'] ?? 0));
        $totalPanenTon = $totalPanenKg / 1000;
        $jumlahPanen = count($panenRecords);
        $gradeCounts = collect($panenRecords)->countBy(fn ($record) => $record['grade'] ?? 'Tidak diklasifikasikan');
        $gradeAPercent = $jumlahPanen > 0
            ? round(($gradeCounts->filter(fn ($count, $grade) => str_starts_with(strtolower($grade), 'grade a'))->sum() / $jumlahPanen) * 100, 1)
            : 0;
        $topCommodity = collect($panenRecords)
            ->groupBy(fn ($record) => $record['komoditas'] ?? 'Tanpa komoditas')
            ->map(fn ($records) => $records->sum(fn ($record) => (float) ($record['kuantitas'] ?? 0)))
            ->sortDesc();
        $topCommodityVolumeKg = $topCommodity->first() ?? 0;
        $topCommodity = $topCommodity->keys()->first();
        $monthlyHarvest = collect($panenRecords)
            ->groupBy(fn ($record) => \Illuminate\Support\Carbon::parse($record['tanggal'])->format('Y-m'))
            ->map(fn ($records) => $records->sum(fn ($record) => (float) ($record['kuantitas'] ?? 0)) / 1000)
            ->sortKeys();
        $gradeLabels = $gradeCounts->keys()->values();
        $gradeValues = $gradeCounts->values();
        $harvestBySector = collect($panenRecords)
            ->groupBy(fn ($record) => $record['sektor'] ?? 'Sektor tidak dicatat')
            ->map(fn ($records) => $records->sum(fn ($record) => (float) ($record['kuantitas'] ?? 0)));
        $monthlyHarvestLabels = $monthlyHarvest->keys()->map(function ($month) {
            return \Illuminate\Support\Carbon::createFromFormat('Y-m', $month)->format('M Y');
        })->values();
        $monthlyHarvestValues = $monthlyHarvest->values();

        return view('panen', compact(
            'panenRecords', 'totalPanenKg', 'totalPanenTon', 'jumlahPanen', 'topCommodityVolumeKg',
            'gradeCounts', 'gradeAPercent', 'topCommodity', 'monthlyHarvest',
            'gradeLabels', 'gradeValues', 'harvestBySector', 'monthlyHarvestLabels', 'monthlyHarvestValues'
        ));
    })->name('panen.index');

    Route::post('/panen', function (Request $request, ActivityLog $activityLog) {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'komoditas' => 'required|string|max:100',
            'sektor' => 'required|string|max:100',
            'kuantitas' => 'required|numeric|min:0.01',
            'grade' => 'required|string|max:20',
        ]);

        $records = session()->get('panen_data', []);
        array_unshift($records, [
            'id' => 'HN-' . now()->format('Ymd-His'),
            'tanggal' => $data['tanggal'],
            'komoditas' => $data['komoditas'],
            'sektor' => $data['sektor'],
            'kuantitas' => $data['kuantitas'],
            'grade' => $data['grade'],
            'distribusi' => 'Belum didistribusikan',
        ]);
        session()->put('panen_data', $records);
        $activityLog->record('Panen', 'Panen dicatat', $data['komoditas'] . ' · ' . number_format((float) $data['kuantitas'], 2, ',', '.') . ' kg · ' . $data['grade'], $data['sektor']);

        return redirect()->route('panen.index')->with('success', 'Data hasil panen berhasil dicatat.');
    })->name('panen.store');

    // ---------------- LAPORAN ----------------
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.export-csv');

    // ---------------- PENGATURAN / PROFIL ----------------
    Route::get('/pengaturan', function () {
        return view('pengaturan', ['user' => Auth::user()]);
    })->name('pengaturan.index');

    Route::put('/pengaturan', function (Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:30',
        ]);

        $user->update($validated);

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    })->name('pengaturan.update');

    Route::get('/profile', function () {
        return view('pengaturan', ['user' => Auth::user()]);
    })->name('profile.edit');

    Route::view('/tentang', 'tentang')->name('tentang.index');
});

// ---------------- AUTHENTICATION ROUTES ----------------

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password yang Anda masukkan salah.',
    ])->onlyInput('email');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Silakan login.');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::get('/reset-password/{token}', function (Request $request, string $token) {
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->query('email')
    ]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem.']);
    }

    $user->password = Hash::make($request->password);
    $user->setRememberToken(Str::random(60));
    $user->save();

    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    return redirect()->route('login')->with('status', 'Password berhasil diperbarui! Silakan login.');
})->name('password.update');