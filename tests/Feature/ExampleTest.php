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
        $response->assertSee('btnRoleAdmin');
        $response->assertSee('btnRoleSensei');
        $response->assertSee('btnRoleSensei2');
        $response->assertSee('loginEmail');
        $response->assertSee('loginPassword');
    }
}
