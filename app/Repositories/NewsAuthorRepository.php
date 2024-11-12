<?php

namespace App\Repositories;

use App\NewsAuthorInterface;
use App\Models\NewsAuthor;

class NewsAuthorRepository extends BaseRepository implements NewsAuthorInterface
{
    protected function setModel()
    {
        $this->model = new NewsAuthor;
    }

    public function create(array $data): NewsAuthor
    {
        return NewsAuthor::create($data);
    }
}