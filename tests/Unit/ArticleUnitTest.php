<?php

it('can retrieve paginated articles from API endpoint', function () {
    $response = $this->get('/api/news');

    $response->assertStatus(200);

    expect($response->json())->toHaveKeys([
        'current_page',
        'data',
        'first_page_url',
        'from',
        'last_page',
        'last_page_url',
        'links',
        'next_page_url',
        'path',
        'per_page',
        'prev_page_url',
        'to',
        'total',
    ]);

    expect($response->json('data'))
        ->toHaveCount(15)
        ->each()
        ->toHaveKeys([
            'id',
            'title',
            'source',
            'category',
            'author',
            'description',
            'content',
            'published_at',
        ]);
});

it('can retrieve paginated articles with custom per_page value', function () {
    $response = $this->get('/api/news?per_page=5');

    $response->assertStatus(200);

    expect($response->json('data'))->toHaveCount(5);
});

it('can retrieve paginated articles with custom page value', function () {
    $response = $this->get('/api/news?page=2');

    $response->assertStatus(200);

    expect($response->json('data'))->toHaveCount(15);
});

it('can retrieve paginated articles with custom per_page and page values', function () {
    $response = $this->get('/api/news?per_page=5&page=2');

    $response->assertStatus(200);

    expect($response->json('data'))->toHaveCount(5);
});

it('can retrieve first page of paginated articles', function () {
    $response = $this->get('/api/news?page=1');

    $response->assertStatus(200);

    expect($response->json('data'))->toHaveCount(15);
});

it('can retrieve paginated articles with filter by keyword', function () {
    $response = $this->get('/api/news?search=lorem&filter_by=title');

    $response->assertStatus(200);

    expect($response->json('data'))->toBeArray();

    if (count($response->json('data')) > 0) {
        expect($response->json('data'))->each()
            ->toHaveKeys([
                'id',
                'title',
                'source',
                'category',
                'author',
                'description',
                'content',
                'published_at',
            ]);
    }
});

it('can retrieve paginated articles with filter by published date', function () {
    $response = $this->get('/api/news?search=2024&filter_by=published_at');

    $response->assertStatus(200);

    expect($response->json('data'))->toBeArray();

    if (count($response->json('data')) > 0) {
        expect($response->json('data'))->each()
            ->toHaveKeys([
                'id',
                'title',
                'source',
                'category',
                'author',
                'description',
                'content',
                'published_at',
            ]);
    }
});

it('can retrieve paginated articles with filter by category', function () {
    $response = $this->get('/api/news?search=technology&filter_by=category');

    $response->assertStatus(200);

    expect($response->json('data'))->toBeArray();

    if (count($response->json('data')) > 0) {
        expect($response->json('data'))->each()
            ->toHaveKeys([
                'id',
                'title',
                'source',
                'category',
                'author',
                'description',
                'content',
                'published_at',
            ]);
    }
});

it('can retrieve paginated articles with filter by source', function () {
    $response = $this->get('/api/news?search=bbc&filter_by=source');

    $response->assertStatus(200);

    expect($response->json('data'))->toBeArray();

    if (count($response->json('data')) > 0) {
        expect($response->json('data'))->each()
            ->toHaveKeys([
                'id',
                'title',
                'source',
                'category',
                'author',
                'description',
                'content',
                'published_at',
            ]);
    }
});

it('can retrieve single article by ID', function () {
    $response = $this->get('/api/news/1');

    $response->assertStatus(200);

    expect($response->json())->toHaveKeys([
        'id',
        'title',
        'source',
        'category',
        'author',
        'description',
        'content',
        'published_at',
    ]);
});
