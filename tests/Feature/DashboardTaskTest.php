<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DashboardTaskTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->make());
    }

    public function test_dashboard_task_status_can_be_updated(): void
    {
        $this->withSession(['jadwal_data' => [[
            'id' => 1,
            'judul' => 'Penyiraman Sektor Utara',
            'kategori' => 'Penyiraman',
            'sektor' => 'Sektor Utara',
            'waktu' => '07:00 - 08:30 WIB',
            'petugas' => 'Sistem IoT / Budi',
            'status' => 'Belum Mulai',
            'badge' => 'pending',
            'selesai' => false,
            'tanggal' => '25',
        ]]]);

        $this->postJson('/dashboard/tugas/1', ['status' => 'selesai'])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Status tugas berhasil diperbarui.');

        $this->assertSame('Selesai', session('jadwal_data')[0]['status']);
        $this->assertTrue(session('jadwal_data')[0]['selesai']);
    }

    public function test_dashboard_metrics_are_aggregated_from_current_session_data(): void
    {
        $this->withSession([
            'tanaman_data' => [
                'halaman1' => [
                    ['nama' => 'Tomat', 'populasi' => 120, 'lokasi' => 'Sektor A', 'status' => 'Sehat'],
                    ['nama' => 'Cabai', 'populasi' => 80, 'lokasi' => 'Sektor B', 'status' => 'Hama'],
                ],
                'halaman2' => [],
            ],
            'lahan_data' => [
                ['luas' => '2.50 Ha', 'sektor' => 'Sektor A', 'status' => 'Aktif'],
                ['luas' => '1,50 Ha', 'sektor' => 'Sektor B', 'status' => 'Perawatan Darurat'],
                ['luas' => '8.00 Ha', 'sektor' => 'Sektor C', 'status' => 'Nonaktif'],
            ],
            'panen_data' => [
                ['kuantitas' => 1250],
                ['kuantitas' => 750],
            ],
            'jadwal_data' => [
                ['id' => 1, 'judul' => 'Tugas terbuka', 'status' => 'Belum Mulai', 'selesai' => false],
                ['id' => 2, 'judul' => 'Tugas selesai', 'status' => 'Selesai', 'selesai' => true],
            ],
        ]);

        $this->get('/dashboard')
            ->assertOk()
            ->assertViewHas('totalTanaman', 200)
            ->assertViewHas('totalLahan', 4.0)
            ->assertViewHas('jumlahLahanAktif', 2)
            ->assertViewHas('jumlahSektorAktif', 2)
            ->assertViewHas('butuhTindakan', 3)
            ->assertViewHas('panenTercatatTon', 2.0)
            ->assertViewHas('jumlahCatatanPanen', 2);
    }

    public function test_growth_chart_period_filters_stored_growth_logs_by_date(): void
    {
        $recentId = DB::table('growth_logs')->insertGetId([
            'day' => 'Catatan bulan aktif',
            'actual' => 140,
            'target' => 120,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $olderId = DB::table('growth_logs')->insertGetId([
            'day' => 'Catatan bulan sebelumnya',
            'actual' => 90,
            'target' => 100,
            'created_at' => now()->subMonth(),
            'updated_at' => now()->subMonth(),
        ]);

        try {
            $this->get('/dashboard?periode=bulan')
                ->assertOk()
                ->assertViewHas('periode', 'bulan')
                ->assertViewHas('chartMinggu', function ($growthRows) {
                    $days = collect($growthRows)->pluck('day');
                    return $days->contains('Catatan bulan aktif') && !$days->contains('Catatan bulan sebelumnya');
                });
        } finally {
            DB::table('growth_logs')->whereIn('id', [$recentId, $olderId])->delete();
        }
    }

    public function test_notifications_use_the_same_updated_schedule_as_dashboard(): void
    {
        $this->withSession(['jadwal_data' => [[
            'id' => 71,
            'judul' => 'Pemeriksaan Sektor C',
            'kategori' => 'Inspeksi',
            'sektor' => 'Sektor C',
            'waktu' => '10:00 - 11:00 WIB',
            'petugas' => 'Tim Demo',
            'status' => 'Sedang Berjalan',
            'badge' => 'success',
            'selesai' => false,
            'tanggal' => '27',
        ]]]);

        $this->postJson('/dashboard/tugas/71', ['status' => 'selesai'])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Pemeriksaan Sektor C')
            ->assertSee('Status: Selesai | Petugas: Tim Demo');

        $this->get('/notifikasi')
            ->assertOk()
            ->assertSee('Pemeriksaan Sektor C')
            ->assertSee('Status: Selesai | Petugas: Tim Demo')
            ->assertSee('10:00 - 11:00 WIB (Sektor C)');
    }

    public function test_created_updated_and_deleted_schedule_stays_in_sync_with_notifications(): void
    {
        $this->withSession(['jadwal_data' => []]);

        $this->post('/jadwal', [
            'tanggal' => '27',
            'judul' => 'Jadwal Sinkron Uji',
            'kategori' => 'Penyiraman',
            'sektor' => 'Sektor Uji',
            'waktu' => '11:00 - 12:00 WIB',
            'petugas' => 'Tim Uji',
        ])->assertRedirect();

        $task = collect(session('jadwal_data'))->firstWhere('judul', 'Jadwal Sinkron Uji');
        $this->assertNotNull($task);
        $taskId = $task['id'];

        $this->get('/dashboard')->assertOk()->assertSee('Jadwal Sinkron Uji');
        $this->get('/notifikasi')->assertOk()->assertSee('Jadwal Sinkron Uji');

        $this->post('/jadwal/' . $taskId . '/status', ['aksi' => 'selesai'])->assertRedirect();
        $this->get('/notifikasi')->assertSee('Selesai');

        $this->post('/jadwal/' . $taskId . '/status', ['aksi' => 'mulai'])->assertRedirect();
        $this->get('/notifikasi')
            ->assertSee('Sedang Berjalan')
            ->assertSee('Status: Sedang Berjalan | Petugas: Tim Uji');

        $this->delete('/jadwal/' . $taskId)->assertRedirect();
        $this->get('/dashboard')
            ->assertViewHas('tugasHariIni', function ($tasks) use ($taskId) {
                return !collect($tasks)->contains('id', $taskId);
            })
            ->assertSee('Jadwal dihapus')
            ->assertSee('Jadwal Sinkron Uji');
        $this->get('/notifikasi')->assertDontSee('Jadwal Sinkron Uji');
    }
}
