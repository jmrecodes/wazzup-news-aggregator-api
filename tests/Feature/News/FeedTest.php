<?php

use App\Models\User;

it('can fetch news feed with the intended json format', function () {
    $user = User::find(1);

    $this->actingAs($user);
    $response = $this->get('/api/news-feed');

    $response->assertStatus(200);

    expect($response->json())->each->toHaveKeys(['id', 'title', 'content', 'created_at', 'updated_at']);
});
