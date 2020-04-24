<?php


namespace App\Domain\Genre\Repositories;


use App\Domain\Genre\Entities\Genre;
use App\Infrastructure\Repository\BaseRepository;

class GenreRepository extends BaseRepository
{
    public function model()
    {
        return Genre::class;
    }
}
