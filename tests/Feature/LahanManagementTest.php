<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LahanManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->make());
    }

    public function test_lahan_can_be_created_updated_and_deleted(): void
    {
        $this->post('/lahan', [
            'nama' => 'Greenhouse Uji',
            'sektor' => 'Sektor Uji',
            'komoditas' => 'Tomat',
            'luas' => 1.25,
            'latitude' => -6.8,
            'longitude' => 107.6,
        ])->assertRedirect();

        $created = collect(session('lahan_data'))->firstWhere('nama', 'Greenhouse Uji');
        $this->assertNotNull($created);
        $this->assertSame('1.25 Ha', $created['luas']);

        $this->put('/lahan/' . $created['id'], [
            'nama' => 'Greenhouse Uji Updated',
            'sektor' => 'Sektor Uji',
            'komoditas' => 'Tomat Cherry',
            'luas' => 1.5,
            'latitude' => -6.8,
            'longitude' => 107.6,
        ])->assertRedirect();

        $this->assertSame('Greenhouse Uji Updated', collect(session('lahan_data'))->firstWhere('id', $created['id'])['nama']);

        $this->delete('/lahan/' . $created['id'])->assertRedirect();
        $this->assertNull(collect(session('lahan_data'))->firstWhere('id', $created['id']));
    }

    public function test_status_filter_only_shows_matching_lahan(): void
    {
        $this->withSession(['lahan_data' => [
            ['id' => 1, 'nama' => 'Lahan Aktif', 'sektor' => 'Sektor A', 'komoditas' => 'Tomat', 'luas' => '1 Ha', 'status' => 'Aktif', 'badge' => 'success'],
            ['id' => 2, 'nama' => 'Lahan Perawatan', 'sektor' => 'Sektor B', 'komoditas' => 'Cabai', 'luas' => '2 Ha', 'status' => 'Perawatan Darurat', 'badge' => 'warning'],
        ]]);

        $this->get('/lahan?status=' . urlencode('Perawatan Darurat'))
            ->assertOk()
            ->assertViewHas('lahanList', function ($lahanList) {
                return count($lahanList) === 1 && $lahanList[0]['nama'] === 'Lahan Perawatan';
            });
    }

    public function test_notes_valve_settings_and_details_are_saved(): void
    {
        $this->post('/lahan/catat-data', [
            'lahan_id' => 1,
            'catatan' => 'Pemeriksaan kelembaban selesai.',
        ])->assertRedirect();
        $this->post('/lahan/catat-data', [
            'lahan_id' => 1,
            'catatan' => 'Pembaruan pemeriksaan terbaru.',
        ])->assertRedirect();

        $this->post('/lahan/atur-katup', [
            'lahan_id' => 1,
            'status' => 'aktif',
            'jadwal' => '07:30',
        ])->assertRedirect();

        $this->get('/lahan')
            ->assertOk()
            ->assertSee('Pemeriksaan kelembaban selesai.')
            ->assertSee('Pembaruan pemeriksaan terbaru.')
            ->assertSee('07:30')
            ->assertViewHas('catatanList', function ($catatanList) {
                return $catatanList[0]['catatan'] === 'Pembaruan pemeriksaan terbaru.';
            });

        $this->get('/lahan/1/sensor')->assertOk()->assertSee('Ringkasan Sensor Lahan');
        $this->get('/lahan/1/log')->assertOk()->assertSee('Pemeriksaan kelembaban selesai.');
    }

    public function test_map_export_returns_csv_download(): void
    {
        $response = $this->get('/lahan/export-peta')->assertOk();

        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));
        $this->assertStringContainsString('Nama Lahan', $response->streamedContent());
    }
}