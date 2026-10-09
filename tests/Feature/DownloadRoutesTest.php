<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class DownloadRoutesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->make());
    }

    public function test_csv_export_routes_return_downloadable_files(): void
    {
        $exports = [
            ['/tanaman/export', 'ID Tanaman'],
            ['/lahan/export-peta', 'Nama Lahan'],
            ['/monitoring/export', 'Tanggal'],
            ['/laporan/export-csv', 'Jenis Data'],
            ['/panen/export', 'ID Panen'],
            ['/riwayat/export', 'Jenis Kegiatan'],
        ];

        foreach ($exports as [$uri, $expectedHeader]) {
            $response = $this->get($uri)->assertOk();
            $this->assertStringContainsString('attachment;', $response->headers->get('content-disposition'));
            $this->assertStringContainsString($expectedHeader, $response->streamedContent(), "CSV export {$uri} should include its header");
        }
    }

    public function test_pdf_export_returns_a_pdf_attachment(): void
    {
        $response = $this->get('/laporan/export-pdf')->assertOk();

        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type'));
        $this->assertStringContainsString('attachment;', $response->headers->get('content-disposition'));
    }

    public function test_download_controls_link_to_registered_routes(): void
    {
        $this->get('/tanaman')->assertSee(route('tanaman.export'));
        $this->get('/lahan')->assertSee(route('lahan.export'));
        $this->get('/monitoring')->assertSee(route('monitoring.export'));
        $this->get('/laporan')->assertSee(route('laporan.export-csv'))->assertSee(route('laporan.export-pdf'));
        $this->get('/panen')->assertSee(route('panen.export'));
        $this->get('/riwayat')->assertSee(route('riwayat.export'));
    }

    public function test_report_page_and_csv_use_the_current_operational_data(): void
    {
        $this->withSession([
            'tanaman_data' => [
                'halaman1' => [['nama' => 'Tomat Laporan Uji', 'lokasi' => 'Sektor Uji', 'populasi' => 125, 'status' => 'Sehat']],
                'halaman2' => [],
            ],
            'lahan_data' => [['nama' => 'Lahan Laporan Uji', 'sektor' => 'Sektor Uji', 'komoditas' => 'Tomat', 'luas' => '1.25 Ha', 'status' => 'Aktif']],
            'panen_data' => [['id' => 'HN-UJI', 'tanggal' => '2026-09-27', 'komoditas' => 'Tomat Laporan Uji', 'sektor' => 'Sektor Uji', 'kuantitas' => 1500, 'grade' => 'Grade A']],
            'jadwal_data' => [],
        ]);

        $this->get('/laporan')
            ->assertOk()
            ->assertSee('Tomat Laporan Uji')
            ->assertSee('Lahan Laporan Uji')
            ->assertSee('1.500');

        $csv = $this->get('/laporan/export-csv')->assertOk()->streamedContent();
        $this->assertStringContainsString('Lahan Laporan Uji', $csv);
        $this->assertStringContainsString('Tomat Laporan Uji', $csv);
        $this->assertStringContainsString('HN-UJI', $csv);
    }
}