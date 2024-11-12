<?php

namespace App\Repositories;

use App\NewsCategoryInterface;
use App\Models\NewsCategory;

class NewsCategoryRepository extends BaseRepository implements NewsCategoryInterface
{
    protected function setModel()
    {
        $this->model = new NewsCategory;
    }

    public function create(array $data): NewsCategory
    {
        return NewsCategory::create($data);
    }
}