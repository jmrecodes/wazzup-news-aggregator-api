<?php

namespace App\Services;

use App\Repositories\NewsCategoryRepository;
use App\Models\NewsCategory;

class NewsCategoryService
{
    protected $repository;

    public function __construct(NewsCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getNewsCategories()
    {
        return $this->repository->all();
    }

    public function createNewsCategory(array $data)
    {
        return $this->repository->create($data);
    }

    public function getNewsCategory(NewsCategory $news_category)
    {
        return $this->repository->find($news_category);
    }

    public function updateNewsCategory(array $data, NewsCategory $news_category)
    {
        return $this->repository->update($data, $news_category);
    }

    public function deleteNewsCategory(NewsCategory $news_category)
    {
        return $this->repository->delete($news_category);
    }
}
