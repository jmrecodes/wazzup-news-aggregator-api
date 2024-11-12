<?php

namespace App;

use App\Models\NewsAuthor;

interface NewsAuthorRepositoryInterface
{
    public function create(array $data): NewsAuthor;
}
