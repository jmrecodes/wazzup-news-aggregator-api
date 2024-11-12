<?php

namespace App;

use App\Models\NewsCategory;

interface NewsCategoryRepositoryInterface
{
    public function create(array $data): NewsCategory;

    public function all(): array;

    public function find(NewsCategory $news_category): ?NewsCategory;

    public function update(array $data, NewsCategory $news_category): NewsCategory;

    public function delete(NewsCategory $news_category): bool;
}
