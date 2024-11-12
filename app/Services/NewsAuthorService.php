<?php

namespace App\Services;

use App\Repositories\NewsAuthorRepository;
use App\Models\NewsAuthor;

class NewsAuthorService
{
    protected $repository;

    public function __construct(NewsAuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getNewsAuthors()
    {
        return $this->repository->all();
    }

    public function createNewsAuthor(array $data)
    {
        return $this->repository->create($data);
    }

    public function getNewsAuthor(NewsAuthor $news_author)
    {
        return $this->repository->find($news_author);
    }

    public function updateNewsAuthor(array $data, NewsAuthor $news_author)
    {
        return $this->repository->update($data, $news_author);
    }

    public function deleteNewsAuthor(NewsAuthor $news_author)
    {
        return $this->repository->delete($news_author);
    }
}
