<?php


namespace App\Domain\Media\Movie\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Movie",
 *     type="object",
 * )
 */

class MovieResource extends JsonResource
{
    /**
     * @OA\Property(property="id", type="integer")
     * @OA\Property(property="title", type="string")
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id
        ];
    }
}
