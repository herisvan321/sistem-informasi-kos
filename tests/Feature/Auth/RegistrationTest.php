<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'pemilik-kos']);
        Role::create(['name' => 'pencari-kos']);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_as_owner(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Owner',
            'email' => 'owner@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'type_user' => 'pemilik-kos',
        ]);

        $this->assertAuthenticated();
        $user = User::where('email', 'owner@example.com')->first();
        $this->assertTrue($user->hasRole('pemilik-kos'));
        $response->assertRedirect(route('pemilik-kos.dashboard', absolute: false));
    }

    public function test_new_users_can_register_as_seeker(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Seeker',
            'email' => 'seeker@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'type_user' => 'pencari-kos',
        ]);

        $this->assertAuthenticated();
        $user = User::where('email', 'seeker@example.com')->first();
        $this->assertTrue($user->hasRole('pencari-kos'));
        // For now seekers might redirect to home or a generic dashboard
        $response->assertRedirect('/');
    }
}
