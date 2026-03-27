<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Report;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolePermissionSeeder;

class ModerationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    protected function getAdmin()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');
        return $admin;
    }

    public function test_admin_can_list_reports(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get(route('admin.moderation'));
        $response->assertStatus(200);
    }

    public function test_admin_can_resolve_report(): void
    {
        $admin = $this->getAdmin();
        $report = Report::factory()->create(['status' => 'Pending']);

        $response = $this->actingAs($admin)->post(route('admin.moderation.resolve', $report->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('reports', ['id' => $report->id, 'status' => 'Resolved']);
    }

    public function test_admin_can_delete_reported_content(): void
    {
        $admin = $this->getAdmin();
        $report = Report::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.moderation.destroy', $report->id));

        $response->assertRedirect();
        $this->assertSoftDeleted('reports', ['id' => $report->id]);
    }
}
