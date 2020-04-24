<?php


namespace App\Domain\Media\Genre\Repositories;


use App\Domain\Genre\Entities\Genre;
use App\Infrastructure\Repository\BaseRepository;

class GenreRepository extends BaseRepository
{
    public function model()
    {
        return Genre::class;
    }

    public function getOrderedByName($order = 'asc')
    {
        return $this->model->orderBy('name', $order);
    }
}
