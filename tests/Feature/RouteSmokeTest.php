<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RouteSmokeTest extends TestCase
{
    public function test_guest_is_redirected_from_protected_routes(): void
    {
        $protectedRoutes = [
            '/',
            '/dashboard',
            '/tanaman',
            '/tanaman/create',
            '/lahan',
            '/jadwal',
            '/monitoring',
            '/notifikasi',
            '/hama-penyakit',
            '/hama',
            '/riwayat',
            '/panen',
            '/laporan',
            '/pengaturan',
            '/profile',
            '/tentang',
        ];

        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }

    public function test_authenticated_user_can_access_main_routes(): void
    {
        $this->actingAs(User::factory()->make());

        $routes = [
            '/dashboard',
            '/tanaman',
            '/tanaman/create',
            '/lahan',
            '/jadwal',
            '/monitoring',
            '/notifikasi',
            '/hama-penyakit',
            '/hama',
            '/riwayat',
            '/panen',
            '/laporan',
            '/pengaturan',
            '/profile',
            '/tentang',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $this->assertSame(200, $response->getStatusCode(), "Route {$route} should be accessible for authenticated user");
            if (!in_array($route, ['/tanaman/create', '/notifikasi'], true)) {
                $response->assertSee('Tentang Aplikasi');
            }
        }

        $this->get('/tentang')
            ->assertSee('Tentang SmartFarm')
            ->assertSee('Tentang Aplikasi');

        $this->get('/login')->assertRedirect('/dashboard');
        $this->get('/register')->assertOk();
        $this->get('/forgot-password')->assertOk();
    }

    public function test_main_pages_share_the_same_notification_dropdown(): void
    {
        $this->actingAs(User::factory()->make());

        $routes = [
            '/dashboard',
            '/tanaman',
            '/lahan',
            '/jadwal',
            '/monitoring',
            '/notifikasi',
            '/hama-penyakit',
            '/riwayat',
            '/panen',
            '/laporan',
            '/pengaturan',
            '/deteksi-ai',
        ];

        foreach ($routes as $route) {
            $this->get($route)
                ->assertOk()
                ->assertSee('data-notification-dropdown', false);
        }
    }

    public function test_profile_dropdown_shows_the_authenticated_users_data_on_all_pages(): void
    {
        $user = User::factory()->make([
            'name' => 'Akun Profil Nyata',
            'email' => 'profil-nyata@example.test',
        ]);
        $user->no_hp = '081298765432';
        $this->actingAs($user);

        $routes = [
            '/dashboard',
            '/tanaman',
            '/lahan',
            '/jadwal',
            '/monitoring',
            '/notifikasi',
            '/hama-penyakit',
            '/riwayat',
            '/panen',
            '/laporan',
            '/pengaturan',
            '/deteksi-ai',
        ];

        foreach ($routes as $route) {
            $this->get($route)
                ->assertOk()
                ->assertSee('data-user-profile', false)
                ->assertSee('Akun Profil Nyata')
                ->assertSee('profil-nyata@example.test')
                ->assertSee('081298765432');
        }
    }

    public function test_authenticated_user_can_update_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->from('/pengaturan')->put('/pengaturan', [
            'name' => 'Updated Farm Manager',
            'email' => $user->email,
            'no_hp' => '081234567890',
        ]);

        $response->assertRedirect('/pengaturan');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Farm Manager',
            'email' => $user->email,
            'no_hp' => '081234567890',
        ]);

        $this->get('/dashboard')
            ->assertSee('Updated Farm Manager')
            ->assertSee($user->email)
            ->assertSee('081234567890');
    }

    public function test_authenticated_user_can_record_a_harvest(): void
    {
        $this->actingAs(User::factory()->make());

        $response = $this->post('/panen', [
            'tanggal' => '2026-09-27',
            'komoditas' => 'Tomat Uji',
            'sektor' => 'Sektor Uji',
            'kuantitas' => 12.5,
            'grade' => 'Grade A',
        ]);

        $response->assertRedirect('/panen');
        $response->assertSessionHas('panen_data.0.komoditas', 'Tomat Uji');

        $this->get('/panen')->assertSee('Tomat Uji')->assertSee('12,50 Kg');
    }
}
