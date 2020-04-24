<?php


namespace App\Domain\Media\Movie\Entities;


use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['name'];
}
