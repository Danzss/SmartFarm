<?php

namespace Tests\Feature;

use App\Models\Monitoring;
use App\Models\User;
use Tests\TestCase;

class MonitoringStoreTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->make());
    }

    public function test_monitoring_store_uses_default_note_when_catatan_is_empty(): void
    {
        $this->post('/monitoring', [
            'komoditas' => 'Tomat',
            'minggu_petak' => 'Minggu ke-4',
            'tinggi_tanaman' => '55 cm',
            'warna_daun' => 'Hijau segar',
            'ketebalan_batang' => '2.4 cm',
            'proporsi_bunga' => '8%',
            'catatan_lapangan' => '',
        ])->assertRedirect(route('monitoring.index'))
          ->assertSessionHas('success');

        $latest = Monitoring::latest()->first();

        $this->assertNotNull($latest);
        $this->assertNotNull($latest->catatan);
        $this->assertStringContainsString('Inspeksi manual komoditas Tomat', $latest->catatan);
    }
}
