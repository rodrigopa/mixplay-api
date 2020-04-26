<?php


namespace App\Domain\Media\Video\Entities;


use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['sd', 'hd', 'fullhd'];
}
