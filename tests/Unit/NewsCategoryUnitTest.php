<?php

use App\Models\User;

it('can retrieve all news categories from API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->getJson('/api/news-categories');

    $response->assertStatus(200);

    expect($response->json()[0])->toHaveKeys([
        'id',
        'category',
    ]);
});

it('can create a news category with user preference through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/api/news-categories', [
        'category' => 'Technology',
        'priority' => 1,
    ]);

    $response->assertStatus(201);

    expect($response->json())->toHaveKeys([
        'category',
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

it('can retrieve a specific news category through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $createResponse = $this->postJson('/api/news-categories', [
        'category' => 'Technology',
        'priority' => 1,
    ]);
    $categoryId = $createResponse->json()['id'];

    $response = $this->getJson("/api/news-categories/{$categoryId}");

    $response->assertStatus(200);

    expect($response->json())->toHaveKeys([
        'id',
        'category'
    ]);
});

it('can update a news category through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $createResponse = $this->postJson('/api/news-categories', [
        'category' => 'Technology',
        'priority' => 1,
    ]);
    $categoryId = $createResponse->json()['id'];

    $response = $this->putJson("/api/news-categories/{$categoryId}", [
        'category' => 'Updated Technology'
    ]);

    $response->assertStatus(200);

    expect($response->json())
        ->toHaveKeys(['id', 'category'])
        ->and($response->json()['category'])
        ->toBe('Updated Technology');
});

it('can delete a news category through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $createResponse = $this->postJson('/api/news-categories', [
        'category' => 'Technology',
        'priority' => 1,
    ]);
    $categoryId = $createResponse->json()['id'];

    $response = $this->deleteJson("/api/news-categories/{$categoryId}");

    $response->assertStatus(204);

    $this->getJson("/api/news-categories/{$categoryId}")
        ->assertStatus(404);
});

it('requires authentication for news category operations', function () {
    $this->getJson('/api/news-categories')->assertStatus(401);
    $this->postJson('/api/news-categories')->assertStatus(401);
    $this->putJson('/api/news-categories/1')->assertStatus(401);
    $this->deleteJson('/api/news-categories/1')->assertStatus(401);
});

it('validates required fields when creating news category', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/api/news-categories', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['category']);
});
