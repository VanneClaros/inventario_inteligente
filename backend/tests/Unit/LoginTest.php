<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('users with admin role can access dashboard', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
        'rol' => 'admin',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
});

test('users with vendedor role can access dashboard', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
        'rol' => 'vendedor',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
});

test('users with other roles cannot access dashboard', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
        'rol' => 'cliente',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(403);
});