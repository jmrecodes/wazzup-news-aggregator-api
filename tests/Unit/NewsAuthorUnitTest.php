<?php

use App\Models\User;

it('can retrieve all authors from API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->getJson('/api/news-authors');

    $response->assertStatus(200);

    expect($response->json()[0])->toHaveKeys([
        'id',
        'first_name',
        'last_name'
    ]);
});

it('can create an author with user preference through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/api/news-authors', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'priority' => 1,
    ]);

    $response->assertStatus(201);

    expect($response->json())->toHaveKeys([
        'first_name',
        'last_name',
        'users',
    ])->and($response['users'][0])->toHaveKeys([
        'id',
        'name',
        'email',
        'pivot',
    ])->and($response['users'][0]['pivot'])->toHaveKeys([
        'news_feed_priority',
    ]);
});

it('can retrieve a specific author through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $createResponse = $this->postJson('/api/news-authors', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'priority' => 1,
    ]);
    $authorId = $createResponse->json()['id'];

    $response = $this->getJson("/api/news-authors/{$authorId}");

    $response->assertStatus(200);

    expect($response->json())->toHaveKeys([
        'id',
        'first_name',
        'last_name'
    ]);
});

it('can update an author through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $createResponse = $this->postJson('/api/news-authors', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'priority' => 1,
    ]);
    $authorId = $createResponse->json()['id'];

    $response = $this->putJson("/api/news-authors/{$authorId}", [
        'first_name' => 'Jane',
        'last_name' => 'Smith'
    ]);

    $response->assertStatus(200);

    expect($response->json())
        ->toHaveKeys(['id', 'first_name', 'last_name'])
        ->and($response->json()['first_name'])
        ->toBe('Jane');
});

it('can delete an author through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $createResponse = $this->postJson('/api/news-authors', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'priority' => 1,
    ]);
    $authorId = $createResponse->json()['id'];

    $response = $this->deleteJson("/api/news-authors/{$authorId}");

    $response->assertStatus(204);

    $this->getJson("/api/news-authors/{$authorId}")
        ->assertStatus(404);
});

it('requires authentication for author operations', function () {
    $this->getJson('/api/news-authors')->assertStatus(401);
    $this->postJson('/api/news-authors')->assertStatus(401);
    $this->putJson('/api/news-authors/1')->assertStatus(401);
    $this->deleteJson('/api/news-authors/1')->assertStatus(401);
});

it('validates required fields when creating author', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/api/news-authors', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['first_name', 'last_name']);
});
