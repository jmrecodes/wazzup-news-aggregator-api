<?php

namespace App\Repositories;

use App\NewsSourceRepositoryInterface;
use App\Models\NewsSource;

class NewsSourceRepository extends BaseRepository implements NewsSourceRepositoryInterface
{
    protected function setModel()
    {
        $this->model = new NewsSource;
    }

    public function create(array $data): NewsSource
    {
        return NewsSource::create($data);
    }
}