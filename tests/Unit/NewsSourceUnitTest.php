<?php

use App\Models\User;

it('can retrieve all news sources from API endpoint', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user
    $this->actingAs($user);

    // Retrieve all news sources through API endpoint
    $response = $this->getJson('/api/news-sources');

    // Assert the response status
    $response->assertStatus(200);

    // Assert the news sources data
    expect($response->json()[0])->toHaveKeys([
        'id',
        'source',
    ]);
});

it('can create a news source with user preference through API endpoint', function () {
    // Create a user
    $user = User::factory()->create();

    // Authenticate the user
    $this->actingAs($user);

    // Create a news source through API endpoint
    $response = $this->postJson('/api/news-sources', [
        'source' => 'BBC News',
        'priority' => 1,
    ]);

    // Assert the response status
    $response->assertStatus(201);

    // Assert the news source data and user preference data
    expect($response->json())->toHaveKeys([
        'source',
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

it('can retrieve a specific news source through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create a news source first
    $createResponse = $this->postJson('/api/news-sources', [
        'source' => 'BBC News',
        'priority' => 1,
    ]);
    $newsSourceId = $createResponse->json()['id'];

    // Retrieve the specific news source
    $response = $this->getJson("/api/news-sources/{$newsSourceId}");

    // Assert the response status
    $response->assertStatus(200);

    // Assert the news source data
    expect($response->json())->toHaveKeys([
        'id',
        'source'
    ]);
});

it('can update a news source through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create a news source first
    $createResponse = $this->postJson('/api/news-sources', [
        'source' => 'BBC News',
        'priority' => 1,
    ]);
    $newsSourceId = $createResponse->json()['id'];

    // Update the news source
    $response = $this->putJson("/api/news-sources/{$newsSourceId}", [
        'source' => 'Updated BBC News'
    ]);

    // Assert the response status
    $response->assertStatus(200);

    // Assert the updated data
    expect($response->json())
        ->toHaveKeys(['id', 'source'])
        ->and($response->json()['source'])
        ->toBe('Updated BBC News');
});

it('can delete a news source through API endpoint', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create a news source first
    $createResponse = $this->postJson('/api/news-sources', [
        'source' => 'BBC News',
        'priority' => 1,
    ]);
    $newsSourceId = $createResponse->json()['id'];

    // Delete the news source
    $response = $this->deleteJson("/api/news-sources/{$newsSourceId}");

    // Assert the response status
    $response->assertStatus(204);

    // Verify the news source is deleted
    $this->getJson("/api/news-sources/{$newsSourceId}")
        ->assertStatus(404);
});

it('requires authentication for news source operations', function () {
    // Attempt to access without authentication
    $this->getJson('/api/news-sources')->assertStatus(401);
    $this->postJson('/api/news-sources')->assertStatus(401);
    $this->putJson('/api/news-sources/1')->assertStatus(401);
    $this->deleteJson('/api/news-sources/1')->assertStatus(401);
});

it('validates required fields when creating news source', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/api/news-sources', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['source']);
});
