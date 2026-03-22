<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // 🔥 todos redirigen al mismo dashboard
        $response->assertRedirect(route('dashboard'));

        // Verificamos que el usuario se creó en la BD
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}