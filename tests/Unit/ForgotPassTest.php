<?php

use App\Models\User;
use Illuminate\Support\Facades\Password;

it('can send forgot password email from API endpoint', function () {
    $user = User::factory()->create();

    $response = $this->postJson(route('forgot-password'), ['email' => $user->email]);

    $response->assertStatus(200);
    expect($response->json('message'))->toBe('We have emailed your password reset link!');
});

it('can reset user password from API endpoint', function () {
    $user = User::factory()->create();

    $token = Password::createToken($user);

    $response = $this->postJson(route('reset-password'), [
        'email' => $user->email,
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'token' => $token,
    ]);

    $response->assertStatus(200);
    expect($response->json('message'))->toBe('Password reset successfully');
});
