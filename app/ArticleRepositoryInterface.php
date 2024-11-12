<?php

namespace App;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface ArticleRepositoryInterface
{
    public function create(array $data): Article;

    public function all(Request $request): Builder;

    public function find(Article $article): ?Article;
}
