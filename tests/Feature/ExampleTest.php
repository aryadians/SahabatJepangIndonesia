<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_login_page_renders_with_redesigned_components(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertSee('LPK SAHABAT JEPANG');
        $response->assertSee('SO KEMENAKER RI');
        $response->assertSee('clockWibSide');
        $response->assertSee('clockJstSide');
        $response->assertSee('Khusus Administrator, Sensei');
        $response->assertSee('loginEmail');
        $response->assertSee('loginPassword');
        $response->assertDontSee('btnRoleAdmin');
    }

    public function test_admin_login_authentication_succeeds_for_admin_and_staff(): void
    {
        $admin = \App\Models\User::factory()->create([
            'email' => 'admin_test@sahabatjepangindonesia.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin_test@sahabatjepangindonesia.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_login_fails_with_invalid_credentials(): void
    {
        $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'email' => 'admin@sahabatjepangindonesia.com',
            'password' => 'salah_password',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
