<?php

namespace App\Services;

use App\Repositories\NewsAuthorRepository;

class NewsAuthorService
{
    protected $repository;

    public function __construct(NewsAuthorRepository $repository)
    {
        $this->repository = $repository;
    }
}