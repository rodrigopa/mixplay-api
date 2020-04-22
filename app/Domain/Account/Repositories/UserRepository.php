<?php

namespace App\Domain\Account\Repositories;

use App\Domain\Account\Entities\User;
use App\Infrastructure\Repository\BaseRepository;

class UserRepository extends BaseRepository
{
    const GENRE_MALE = 1;
    const GENRE_FEMALE = 2;

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return User::class;
    }

    public static function getAvailableGenres() {
        return collect([
            self::GENRE_MALE => 'Masculino',
            self::GENRE_FEMALE => 'Feminino'
        ]);
    }
}
