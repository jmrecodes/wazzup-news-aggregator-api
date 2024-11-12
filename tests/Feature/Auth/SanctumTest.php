<?php

use App\Models\User;

uses(Tests\TestCase::class)->in('Feature');

it('can generate a valid API token for a user via login endpoint', function () {
    $password = 'password123';
    $user = User::factory()->create([
        'password' => bcrypt($password),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => $password,
    ]);

    // Assert the response
    $response->assertStatus(200);
    $response->assertJsonStructure(['access_token', 'token_type']);

    $token = $response->json('access_token');

    // Assert the token
    expect($token)->toBeString();
    expect($token)->not->toBeEmpty();

    // Verify the token works
    $this->withToken($token)
         ->getJson('/api/user')
         ->assertStatus(200)
         ->assertJsonStructure(['id', 'name', 'email']);
});

it('cannot access protected routes with an invalid token', function () {
    $invalidToken = 'invalid-token';

    // Assert unauthorized
    $response = $this->withToken($invalidToken)
        ->getJson('/api/user')
        ->assertUnauthorized();

    // Assert the message
    expect($response->json('message'))->toBe('Unauthenticated.');
});

it('can logout through API endpoint', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Assert the response
    $this->withToken($token)
         ->postJson('/api/logout')  // Tests API endpoint
         ->assertStatus(200);

    // Assert the token is revoked
    expect($user->tokens()->count())->toBe(0);
});

it('can register a new user', function () {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ];

    $response = $this->post('/api/register', $userData);

    // Assert the response
    $response->assertStatus(201);

    // Assert the user is created
    $this->assertDatabaseHas('users', ['email' => $userData['email']]);
});

it('cannot login with invalid credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(422);
});

it('can refresh the API token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withToken($token)->post('/api/refresh');

    // Assert the response
    $response->assertStatus(200);
    $response->assertJsonStructure(['access_token']);

    // Assert the token to be different
    expect($response->json('access_token'))->not->toBe($token);
});

it('cannot use the token after logout', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $this->withToken($token)
         ->postJson('/api/logout')
         ->assertOk();

    // Clear auth cache
    $this->app->forgetInstance('auth');

    $response = $this->withToken($token)->getJson('/api/user');

    // Assert unauthorized using the same token
    $response->assertUnauthorized();

    // Assert the message
    expect($response->json('message'))->toBe('Unauthenticated.');
});
