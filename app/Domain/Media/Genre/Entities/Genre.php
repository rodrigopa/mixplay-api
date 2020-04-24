<?php


namespace App\Domain\Genre\Entities;


use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['name'];
}
