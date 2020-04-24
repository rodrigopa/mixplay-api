<?php


namespace App\Domain\Media\Genre\Resources;

use App\Domain\Media\Movie\Resources\MovieResource;
use App\Infrastructure\Resource\PaginationResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     schema="Genre Collection",
 *     type="object",
 * )
 */

class GenreCollection extends ResourceCollection
{
    /**
     * @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Genre"))
     * @OA\Property(property="links", type="object", ref="#/components/schemas/Pagination")
     * )
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'items' => GenreResource::collection($this->collection),
            'links' => new PaginationResource($this),
        ];
    }
}
