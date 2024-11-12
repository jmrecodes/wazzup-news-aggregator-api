<?php

namespace App\Repositories;

use App\NewsCategoryRepositoryInterface;
use App\Models\NewsCategory;

class NewsCategoryRepository extends BaseRepository implements NewsCategoryRepositoryInterface
{
    protected function setModel()
    {
        $this->model = new NewsCategory();
    }

    public function create(array $data): NewsCategory
    {
        return NewsCategory::create($data);
    }
}
