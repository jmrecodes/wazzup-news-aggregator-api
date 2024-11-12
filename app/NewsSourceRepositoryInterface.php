<?php

namespace App;

use App\Models\NewsSource;
use Illuminate\Support\Collection;

interface NewsSourceRepositoryInterface
{
    public function create(array $data): NewsSource;

    public function all(): Collection;

    public function find(NewsSource $id): ?NewsSource;

    public function update(array $data, NewsSource $id): NewsSource;

    public function delete(NewsSource $id): bool;
}
