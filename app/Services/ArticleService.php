<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ArticleService
{
    protected $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getArticles(int $perPage, Request $request): LengthAwarePaginator
    {
        return $this->repository->all($request)->paginate($perPage);
    }

    public function getArticle($article)
    {
        return $this->repository->find($article);
    }
}
