<?php

namespace App;

use App\Models\NewsSource;
use Symfony\Component\HttpFoundation\JsonResponse;

interface NewsSourceRepositoryInterface
{
    public function create(array $data): NewsSource;

    public function all(): array;

    public function find(NewsSource $id): ?NewsSource;

    public function update(array $data, NewsSource $id): NewsSource;

    public function delete(NewsSource $id): bool;
}
