<?php


namespace App\Domain\Genre\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Genre",
 *     type="object",
 * )
 */

class GenreResource extends JsonResource
{
    /**
     * @OA\Property(property="id",type="integer")
     * @OA\Property(property="title",type="string")
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
