<?php

namespace App\Infrastructure\Repository;

use Bosnadev\Repositories\Eloquent\Repository;

abstract class BaseRepository extends Repository
{
    public function getModel()
    {
        return $this->model;
    }
}
