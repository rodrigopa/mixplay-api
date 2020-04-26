<?php


namespace App\Domain\Media\Video\Repositories;


use App\Domain\Media\Video\Entities\Video;
use App\Infrastructure\Repository\BaseRepository;

class VideoRepository extends BaseRepository
{
    public function model()
    {
        return Video::class;
    }
}
