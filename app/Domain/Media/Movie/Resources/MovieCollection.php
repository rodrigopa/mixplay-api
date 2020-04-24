<?php


namespace App\Domain\Media\Movie\Resources;

use App\Infrastructure\Resource\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     schema="Movie Collection",
 *     type="object",
 * )
 */

class MovieCollection extends ResourceCollection
{
    /**
     * @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Movie"))
     * @OA\Property(property="links", type="object", ref="#/components/schemas/Pagination")
     * )
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'items' => MovieResource::collection($this->collection),
            'links' => new PaginationResource($this),
        ];
    }
}
