<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract protected function setModel();

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}