<?php


namespace App\Domain\Media\Movie\Entities;


use App\Domain\Media\Video\Entities\Video;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['name', 'year', 'trailer_url', 'description', 'metadata', 'video_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
