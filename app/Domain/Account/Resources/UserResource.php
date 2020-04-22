<?php

namespace App\Domain\Account\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 * )
 */

class UserResource extends JsonResource
{
    /**
     * @OA\Property(property="id",type="integer")
     * @OA\Property(property="name",type="string")
     * @OA\Property(property="born_date",type="string")
     * @OA\Property(
     *     property="genre",
     *     type="integer",
     *     enum= {1,2},
     *     description="Gênero: 1 para masculino, 2 para feminino"
     * )
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'born_date' => $this->born_date,
            'genre' => $this->genre
        ];
    }
}
