<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileAndAuditLogTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $teacher;
    private User $staff;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Super Admin Test',
            'email' => 'admin_test@sahabatjepangindonesia.com',
            'role' => 'admin',
            'is_active' => true,
            'password' => Hash::make('password123'),
        ]);

        $this->teacher = User::create([
            'name' => 'Sensei Kenji Test',
            'email' => 'sensei_test@sahabatjepangindonesia.com',
            'role' => 'teacher',
            'is_active' => true,
            'password' => Hash::make('password123'),
        ]);

        $this->staff = User::create([
            'name' => 'Staf Operasional Test',
            'email' => 'staff_test@sahabatjepangindonesia.com',
            'role' => 'staff',
            'is_active' => true,
            'password' => Hash::make('password123'),
        ]);
    }

    public function test_all_authenticated_roles_can_access_profile_page(): void
    {
        $this->actingAs($this->admin)->get(route('admin.profile.index'))->assertStatus(200);
        $this->actingAs($this->teacher)->get(route('admin.profile.index'))->assertStatus(200);
        $this->actingAs($this->staff)->get(route('admin.profile.index'))->assertStatus(200);
    }

    public function test_user_can_update_profile_info(): void
    {
        $response = $this->actingAs($this->teacher)->put(route('admin.profile.update'), [
            'name' => 'Sensei Kenji Updated',
            'email' => $this->teacher->email,
            'phone' => '081234567890',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $this->teacher->id,
            'name' => 'Sensei Kenji Updated',
            'phone' => '081234567890',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'profile.updated',
            'user_id' => $this->teacher->id,
        ]);
    }

    public function test_user_can_change_password_with_valid_current_password(): void
    {
        $response = $this->actingAs($this->staff)->put(route('admin.profile.password'), [
            'current_password' => 'password123',
            'password' => 'newsecret2026',
            'password_confirmation' => 'newsecret2026',
        ]);

        $response->assertSessionHas('success');
        $this->staff->refresh();
        $this->assertTrue(Hash::check('newsecret2026', $this->staff->password));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'profile.password_changed',
            'user_id' => $this->staff->id,
        ]);
    }

    public function test_password_change_fails_if_current_password_is_incorrect(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.profile.password'), [
            'current_password' => 'wrongpassword',
            'password' => 'newsecret2026',
            'password_confirmation' => 'newsecret2026',
        ]);

        $response->assertSessionHasErrors(['current_password']);
        $this->admin->refresh();
        $this->assertTrue(Hash::check('password123', $this->admin->password));
    }

    public function test_audit_logs_page_is_restricted_to_admin_only(): void
    {
        // Admin gets 200
        $this->actingAs($this->admin)->get(route('admin.audit-logs.index'))->assertStatus(200);

        // Teacher gets 403
        $this->actingAs($this->teacher)->get(route('admin.audit-logs.index'))->assertStatus(403);

        // Staff gets 403
        $this->actingAs($this->staff)->get(route('admin.audit-logs.index'))->assertStatus(403);
    }

    public function test_audit_log_records_login_and_logout(): void
    {
        // Login success
        $this->post(route('admin.login.submit'), [
            'email' => $this->admin->email,
            'password' => 'password123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'auth.login',
            'user_id' => $this->admin->id,
        ]);

        // Logout
        $this->actingAs($this->admin)->post(route('admin.logout'))->assertRedirect(route('admin.login'));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'auth.logout',
            'user_id' => $this->admin->id,
        ]);
    }

    public function test_admin_can_clear_logs_older_than_30_days(): void
    {
        AuditLog::record('test.old', 'Log lama 40 hari lalu', [], $this->admin);
        AuditLog::where('action', 'test.old')->update(['created_at' => now()->subDays(40)]);

        AuditLog::record('test.recent', 'Log baru hari ini', [], $this->admin);

        $response = $this->actingAs($this->admin)->delete(route('admin.audit-logs.clear'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('audit_logs', ['action' => 'test.old']);
        $this->assertDatabaseHas('audit_logs', ['action' => 'test.recent']);
    }
}
