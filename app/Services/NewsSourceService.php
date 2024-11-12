<?php

namespace App\Services;

use App\Repositories\NewsSourceRepository;
use App\Models\NewsSource;

class NewsSourceService
{
    protected $repository;

    public function __construct(NewsSourceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getNewsSources()
    {
        return $this->repository->all();
    }

    public function createNewsSource(array $data)
    {
        return $this->repository->create($data);
    }

    public function getNewsSource(NewsSource $news_source)
    {
        return $this->repository->find($news_source);
    }

    public function updateNewsSource(array $data, NewsSource $news_source)
    {
        return $this->repository->update($data, $news_source);
    }

    public function deleteNewsSource(NewsSource $news_source)
    {
        return $this->repository->delete($news_source);
    }
}
