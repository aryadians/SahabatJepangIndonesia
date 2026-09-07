<?php

namespace Tests\Feature;

use App\Models\GroupBranch;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SjiGroupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\GroupBranchSeeder::class);
    }

    /**
     * Test public company profile page renders successfully with SJI Group details.
     */
    public function test_guest_can_access_sji_group_company_profile()
    {
        $response = $this->get(route('company.profile'));

        $response->assertStatus(200);
        $response->assertSee('PT SAHABAT JEPANG INDONESIA GROUP');
        $response->assertSee('YOYOK WIDODO');
        $response->assertSee('PT SJI GROUP');
        $response->assertSee('LPK SAHABAT JEPANG INDONESIA');
        $response->assertSee('大心の船橋入国後研修センター');
        $response->assertSee('株式会社 SAHABAT JAPAN AGENCY');
        $response->assertSee('https://www.instagram.com/pt.sjigroup/');
        $response->assertSee('https://www.facebook.com/groups/1402737939919037/');
    }

    /**
     * Test route alias /sji-group redirects to /profil-perusahaan.
     */
    public function test_sji_group_alias_redirects_correctly()
    {
        $response = $this->get('/sji-group');
        $response->assertRedirect(route('company.profile'));

        $aliasResponse = $this->get('/tentang-kami');
        $aliasResponse->assertRedirect(route('company.profile'));
    }

    /**
     * Test admin can view group branches management index.
     */
    public function test_admin_can_view_group_branches_index()
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.group-branches.index'));

        $response->assertStatus(200);
        $response->assertSee('Direktori Lembaga di Bawah SJI Group');
        $response->assertSee('PT SJI GROUP');
        $response->assertSee('大心の船橋入国後研修センター');
    }

    /**
     * Test admin can create a new group branch.
     */
    public function test_admin_can_create_group_branch()
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.group-branches.store'), [
            'name' => 'LPK SJI CABANG SURABAYA TIMUR',
            'japanese_name' => 'LPK サハバット・ジャパン 東スラバヤ校',
            'category_jp' => '日本語学校',
            'category_id' => 'Sekolah Bahasa Jepang Cabang Surabaya Timur',
            'country' => 'ID',
            'phone' => '+62 811-2233-4455',
            'address' => 'Jl. Rungkut Asri No. 12, Surabaya',
            'city' => 'Surabaya',
            'province' => 'Jawa Timur',
            'postal_code' => '60293',
            'sort_order' => 10,
            'is_active' => '1',
            'description' => 'Kampus satelit pelatihan bahasa Jepang regional timur.',
        ]);

        $response->assertRedirect(route('admin.group-branches.index'));
        $this->assertDatabaseHas('group_branches', [
            'name' => 'LPK SJI CABANG SURABAYA TIMUR',
            'city' => 'Surabaya',
            'country' => 'ID',
        ]);
    }

    /**
     * Test admin can update a group branch.
     */
    public function test_admin_can_update_group_branch()
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
        $branch = GroupBranch::first();

        $response = $this->actingAs($admin)->put(route('admin.group-branches.update', $branch->id), [
            'name' => $branch->name . ' (UPDATED)',
            'country' => $branch->country,
            'phone' => '+62 899-9999-8888',
            'address' => $branch->address,
            'city' => $branch->city,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.group-branches.index'));
        $this->assertDatabaseHas('group_branches', [
            'id' => $branch->id,
            'name' => $branch->name . ' (UPDATED)',
            'phone' => '+62 899-9999-8888',
        ]);
    }

    /**
     * Test admin can toggle active status of a branch.
     */
    public function test_admin_can_toggle_branch_status()
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
        $branch = GroupBranch::first();
        $initialStatus = $branch->is_active;

        $response = $this->actingAs($admin)->post(route('admin.group-branches.toggle', $branch->id));

        $response->assertSessionHas('success');
        $this->assertEquals(!$initialStatus, $branch->fresh()->is_active);
    }

    /**
     * Test admin can delete a branch.
     */
    public function test_admin_can_delete_group_branch()
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
        $branch = GroupBranch::create([
            'name' => 'Branch to be deleted',
            'country' => 'ID',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.group-branches.destroy', $branch->id));

        $response->assertRedirect(route('admin.group-branches.index'));
        $this->assertDatabaseMissing('group_branches', ['id' => $branch->id]);
    }

    /**
     * Test updating social media links and corporate profile in admin settings.
     */
    public function test_admin_can_update_social_and_corporate_settings()
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_name' => 'PT SAHABAT JEPANG INDONESIA GROUP',
            'social_facebook' => 'https://facebook.com/groups/new-test-sji',
            'social_instagram' => 'https://instagram.com/pt.sjigroup.official',
            'social_youtube' => 'https://youtube.com/@SJIUpdated',
            'social_tiktok' => 'https://tiktok.com/@sji.updated',
            'contact_whatsapp_link' => 'https://api.whatsapp.com/send?phone=6281333270022&text=TestUpdate',
            'corporate_leader_name' => 'YOYOK WIDODO S.T.',
        ]);

        $response->assertRedirect();
        $this->assertEquals('https://facebook.com/groups/new-test-sji', SiteSetting::get('social_facebook'));
        $this->assertEquals('https://instagram.com/pt.sjigroup.official', SiteSetting::get('social_instagram'));
        $this->assertEquals('YOYOK WIDODO S.T.', SiteSetting::get('corporate_leader_name'));
    }

    /**
     * Test guest can access dedicated curriculum and education page.
     */
    public function test_guest_can_access_curriculum_and_education_page()
    {
        $response = $this->get(route('education.curriculum'));

        $response->assertStatus(200);
        $response->assertSee('PT SAHABAT JEPANG INDONESIA GROUP');
        $response->assertSee('Kurikulum Terpadu');
        $response->assertSee('SCREENING CLASS');
        $response->assertSee('N5 / JFT-BASIC A2');
        $response->assertSee('N4 / KAIWA KERJA');
        $response->assertSee('N3 / SPESIFIK BIDANG');
        $response->assertSee('Native Sensei Asli Jepang');
        $response->assertSee('04:00 AM');
        $response->assertSee('Bangun Tidur');

        // Test route aliases redirect to education.curriculum
        $this->get('/kurikulum')->assertRedirect(route('education.curriculum'));
        $this->get('/edukasi')->assertRedirect(route('education.curriculum'));
    }

    /**
     * Test admin can update site favicon and corporate leader photo.
     */
    public function test_admin_can_update_favicon_and_leader_photo()
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_favicon' => 'https://example.com/custom-favicon.ico',
            'corporate_leader_photo' => 'https://example.com/custom-leader.jpg',
            'corporate_leader_name' => 'YOYOK WIDODO',
        ]);

        $response->assertRedirect();
        $this->assertEquals('https://example.com/custom-favicon.ico', SiteSetting::get('site_favicon'));
        $this->assertEquals('https://example.com/custom-leader.jpg', SiteSetting::get('corporate_leader_photo'));
    }

    /**
     * Test non-admin user (karyawan/teacher) cannot manage group branches.
     */
    public function test_non_admin_cannot_access_group_branches()
    {
        $teacher = User::where('role', 'teacher')->first() ?? User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->get(route('admin.group-branches.index'));
        $response->assertStatus(403);
    }

    /**
     * Test admin can upload favicon file which is converted into circular PNG data uri.
     */
    public function test_admin_can_upload_circular_favicon_file()
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
        $file = \Illuminate\Http\UploadedFile::fake()->image('square_favicon.png', 100, 100);

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_favicon_file' => $file,
        ]);

        $response->assertRedirect();
        $storedFav = SiteSetting::get('site_favicon');
        $this->assertNotNull($storedFav);
        $this->assertStringStartsWith('data:image/png;base64,', $storedFav);
    }
}
