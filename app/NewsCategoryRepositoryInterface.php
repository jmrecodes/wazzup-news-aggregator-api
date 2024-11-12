<?php

namespace App;

use App\Models\NewsCategory;

interface NewsCategoryRepositoryInterface
{
    public function create(array $data): NewsCategory;
}
