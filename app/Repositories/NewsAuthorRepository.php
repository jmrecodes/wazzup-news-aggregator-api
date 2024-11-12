<?php

namespace App\Repositories;

use App\NewsAuthorRepositoryInterface;
use App\Models\NewsAuthor;

class NewsAuthorRepository extends BaseRepository implements NewsAuthorRepositoryInterface
{
    protected function setModel()
    {
        $this->model = new NewsAuthor();
    }

    public function create(array $data): NewsAuthor
    {
        return NewsAuthor::create($data);
    }
}
