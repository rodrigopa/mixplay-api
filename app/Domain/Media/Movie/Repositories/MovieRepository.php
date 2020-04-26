<?php


namespace App\Domain\Media\Movie\Repositories;


use App\Domain\Media\Movie\Entities\Movie;
use App\Infrastructure\Repository\BaseRepository;

class MovieRepository extends BaseRepository
{
    public function model()
    {
        return Movie::class;
    }

    public function getWithVideo($id)
    {
        return $this->model->with('video')->find($id);
    }
}
