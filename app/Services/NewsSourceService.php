<?php

namespace App\Services;

use App\Repositories\NewsSourceRepository;

class NewsSourceService
{
    protected $repository;

    public function __construct(NewsSourceRepository $repository)
    {
        $this->repository = $repository;
    }
}