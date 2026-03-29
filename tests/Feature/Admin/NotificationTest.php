<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure role exists
        Role::create(['name' => 'super-admin']);
        
        $this->admin = User::factory()->create([
            'status' => 'active',
        ]);
        $this->admin->assignRole('super-admin');

        // Create a notification for the admin
        $this->admin->notifications()->create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'type' => 'App\Notifications\TestNotification',
            'data' => ['message' => 'Notification 1'],
            'read_at' => null,
        ]);
    }

    public function test_admin_can_view_notifications_index()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.notifications.index'));

        $response->assertStatus(200);
        $response->assertSee('Notifikasi');
        $response->assertSee('Notification 1');
    }

    public function test_admin_can_mark_notification_as_read()
    {
        $notification = $this->admin->unreadNotifications->first();

        $response = $this->actingAs($this->admin)
                         ->patch(route('admin.notifications.mark-as-read', $notification->id));

        $response->assertStatus(302);
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_admin_can_mark_all_notifications_as_read()
    {
        // Add one more unread notification
        $this->admin->notifications()->create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'type' => 'App\Notifications\TestNotification',
            'data' => ['message' => 'Notification 2'],
            'read_at' => null,
        ]);

        $this->assertEquals(2, $this->admin->unreadNotifications()->count());

        $response = $this->actingAs($this->admin)
                         ->post(route('admin.notifications.read-all'));

        $response->assertStatus(302);
        $this->assertEquals(0, $this->admin->unreadNotifications()->count());
    }

    public function test_admin_can_delete_notification()
    {
        $notification = $this->admin->notifications->first();

        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.notifications.destroy', $notification->id));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
    }
}
