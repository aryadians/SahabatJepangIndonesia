<?php

namespace Tests\Feature;

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RealTimeSyncTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin.sync@example.com',
        ]);
    }

    public function test_guest_can_access_guest_sync_endpoint(): void
    {
        $response = $this->getJson('/api/realtime-sync/guest');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'timestamp',
            'epoch',
            'stats' => ['total_alumni', 'active_students', 'departed_students'],
            'latest_departed',
            'batches',
        ]);
        $response->assertJson(['status' => 'success']);
    }

    public function test_guest_cannot_access_admin_sync_endpoint(): void
    {
        $response = $this->get('/admin/api/realtime-sync');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_admin_sync_endpoint(): void
    {
        $response = $this->actingAs($this->admin)->getJson('/admin/api/realtime-sync');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'server_time',
            'epoch',
            'max_consultation_id',
            'max_student_id',
            'notifications' => [
                'pending_leads_count',
                'latest_leads',
                'pending_affiliates_count',
            ],
            'students_kpi' => [
                'total',
                'active',
                'departed',
            ],
        ]);
    }

    public function test_new_lead_is_reflected_in_admin_sync(): void
    {
        // 1. Check initial state
        $initResponse = $this->actingAs($this->admin)->getJson('/admin/api/realtime-sync');
        $initCount = $initResponse->json('notifications.pending_leads_count');

        // 2. Submit new consultation as guest
        $lead = Consultation::create([
            'name' => 'Calon Siswa Live Sync',
            'phone' => '081234567899',
            'program' => 'Tokutei Ginou (SSW)',
            'city' => 'Surabaya',
            'status' => 'pending',
        ]);

        // 3. Admin sync immediately reflects new count and max id
        $syncResponse = $this->actingAs($this->admin)->getJson('/admin/api/realtime-sync');
        $syncResponse->assertStatus(200);
        $this->assertEquals($initCount + 1, $syncResponse->json('notifications.pending_leads_count'));
        $this->assertEquals($lead->id, $syncResponse->json('max_consultation_id'));
    }

    public function test_updating_lead_status_via_ajax_returns_live_kpi_stats(): void
    {
        $lead = Consultation::create([
            'name' => 'Budi Santoso Test',
            'phone' => '081299988877',
            'program' => 'Tokutei Ginou (SSW)',
            'city' => 'Jakarta',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->postJson("/admin/leads/{$lead->id}/status", [
            'status' => 'contacted',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'status' => 'contacted',
        ]);
        $this->assertEquals(0, $response->json('stats.pending'));
        $this->assertEquals(1, $response->json('stats.contacted'));

        // Verify that admin sync endpoint also reflects updated KPIs
        $adminSync = $this->actingAs($this->admin)->getJson('/admin/api/realtime-sync');
        $this->assertEquals(0, $adminSync->json('leads_kpi.pending'));
        $this->assertEquals(1, $adminSync->json('leads_kpi.contacted'));
    }
}
