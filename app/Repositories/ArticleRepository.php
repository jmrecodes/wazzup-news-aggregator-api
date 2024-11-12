<?php

namespace App\Repositories;

use App\ArticleRepositoryInterface;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
{
    protected function setModel()
    {
        $this->model = new Article();
    }

    public function create(array $data): Article
    {
        return Article::create($data);
    }

    public function all(Request $request): Builder
    {
        return Article::select('id', 'title', 'source', 'category', 'author', 'description', 'content', 'published_at')
            ->orderBy('published_at', 'desc')
            ->when($request->has('search') && $request->has('filter_by'), function ($query) use ($request) {
                return $query->where($request->filter_by, 'like', '%' . $request->search . '%');
            });
    }

    public function find(Article $article): Article
    {
        return $article;
    }
}
