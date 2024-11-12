<?php

namespace App\Services;

use App\Repositories\NewsSourceRepository;

class NewsSourceService
{
    protected $repository;

    public function __construct(\App\Repositories\NewsSourceRepository $repository)
    {
        $this->repository = $repository;
    }
}