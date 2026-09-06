<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_model_role_helper_methods(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $teacher = User::factory()->create(['role' => 'teacher']);
        $staff = User::factory()->create(['role' => 'staff']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isTeacher());
        $this->assertFalse($admin->isStaff());
        $this->assertTrue($admin->canManageUsers());
        $this->assertTrue($admin->canManageFinance());

        $this->assertFalse($teacher->isAdmin());
        $this->assertTrue($teacher->isTeacher());
        $this->assertFalse($teacher->isStaff());
        $this->assertFalse($teacher->canManageUsers());
        $this->assertFalse($teacher->canManageFinance());

        $this->assertFalse($staff->isAdmin());
        $this->assertFalse($staff->isTeacher());
        $this->assertTrue($staff->isStaff());
        $this->assertFalse($staff->canManageUsers());
        $this->assertTrue($staff->canManageFinance());
    }

    public function test_admin_can_access_user_management_and_see_kpi_and_matrix(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create(['role' => 'teacher']);
        User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Matriks Hak Akses Resmi');
        $response->assertSee('Administrator');
        $response->assertSee('Pengajar / Sensei');
        $response->assertSee('Karyawan / Staf');
    }

    public function test_teacher_cannot_access_user_management(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_staff_cannot_access_user_management(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($staff)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_admin_and_staff_can_access_finance_but_teacher_is_blocked(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $staff = User::factory()->create(['role' => 'staff']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        // Admin can access finance
        $this->actingAs($admin)->get(route('admin.finance.index'))->assertStatus(200);

        // Staff can access finance
        $this->actingAs($staff)->get(route('admin.finance.index'))->assertStatus(200);

        // Teacher is blocked with 403
        $this->actingAs($teacher)->get(route('admin.finance.index'))->assertStatus(403);
    }

    public function test_admin_can_toggle_user_active_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $targetUser = User::factory()->create(['role' => 'staff', 'is_active' => true]);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle', $targetUser->id));

        $response->assertRedirect();
        $this->assertFalse($targetUser->fresh()->is_active);

        // Toggle back
        $response2 = $this->actingAs($admin)->post(route('admin.users.toggle', $targetUser->id));
        $response2->assertRedirect();
        $this->assertTrue($targetUser->fresh()->is_active);
    }

    public function test_admin_can_create_new_staff_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Staff Keuangan LPK',
            'email' => 'keuangan@sahabatjepangindonesia.com',
            'role' => 'staff',
            'password' => 'secret123',
            'is_active' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'keuangan@sahabatjepangindonesia.com',
            'role' => 'staff',
            'is_active' => true,
        ]);
    }
}
