<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->make());
    }

    public function test_module_actions_flow_into_dashboard_history_reports_and_schedule(): void
    {
        $this->withSession([
            'lahan_data' => [],
            'tanaman_data' => ['halaman1' => [], 'halaman2' => []],
            'jadwal_data' => [],
        ]);

        $this->post('/lahan', [
            'nama' => 'Lahan Alur Uji',
            'sektor' => 'Sektor Alur',
            'komoditas' => 'Tomat',
            'luas' => 2.5,
        ])->assertRedirect();

        $this->post('/tanaman', [
            'nama' => 'Tomat Alur Uji',
            'lokasi' => 'Sektor Alur',
            'populasi' => 320,
        ])->assertRedirect();

        $this->post('/jadwal', [
            'tanggal' => '27',
            'judul' => 'Penyemprotan Alur Uji',
            'kategori' => 'Pengobatan',
            'sektor' => 'Sektor Alur',
            'waktu' => '10:00 - 11:00 WIB',
            'petugas' => 'Tim Uji',
        ])->assertRedirect();

        $this->post('/hama/laporan', [
            'tanaman' => 'Tomat Alur Uji',
            'gejala' => 'Bercak daun uji',
            'lokasi' => 'Sektor Alur',
            'tingkat' => 'tinggi',
        ])->assertRedirect();

        $this->post('/panen', [
            'tanggal' => '2026-09-27',
            'komoditas' => 'Tomat Alur Uji',
            'sektor' => 'Sektor Alur',
            'kuantitas' => 1500,
            'grade' => 'Grade A',
        ])->assertRedirect();

        $this->post('/riwayat', [
            'kategori' => 'Operasional',
            'judul' => 'Catatan Manual Alur Uji',
            'pesan' => 'Pemeriksaan selesai',
            'lokasi' => 'Sektor Alur',
        ])->assertRedirect();

        $this->assertCount(6, session('activity_logs'));

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Catatan Manual Alur Uji')
            ->assertSee('Penyemprotan Alur Uji');

        $this->get('/riwayat')
            ->assertOk()
            ->assertSee('Lahan Alur Uji')
            ->assertSee('Tomat Alur Uji')
            ->assertSee('Penyemprotan Alur Uji')
            ->assertSee('Bercak daun uji')
            ->assertSee('Catatan Manual Alur Uji');

        $this->get('/laporan')
            ->assertOk()
            ->assertSee('Lahan Alur Uji')
            ->assertSee('Tomat Alur Uji');

        $this->get('/hama-penyakit')
            ->assertOk()
            ->assertSee('Bercak daun uji')
            ->assertSee('1 laporan');

        $this->get('/jadwal?tanggal=27')
            ->assertOk()
            ->assertSee('Penyemprotan Alur Uji');
    }
}
