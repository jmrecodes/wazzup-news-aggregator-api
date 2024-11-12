<?php

namespace App;

use App\Models\NewsAuthor;

interface NewsAuthorRepositoryInterface
{
    public function create(array $data): NewsAuthor;

    public function all(): array;

    public function find(NewsAuthor $news_author): ?NewsAuthor;

    public function update(array $data, NewsAuthor $news_author): NewsAuthor;

    public function delete(NewsAuthor $news_author): bool;
}
