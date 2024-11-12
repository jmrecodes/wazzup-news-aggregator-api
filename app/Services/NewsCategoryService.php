<?php

namespace App\Services;

use App\Repositories\NewsCategoryRepository;

class NewsCategoryService
{
    protected $repository;

    public function __construct(NewsCategoryRepository $repository)
    {
        $this->repository = $repository;
    }
}