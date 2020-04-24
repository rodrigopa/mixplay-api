<?php

namespace App\Domain\Tmdb\Resources;

use App\Domain\Tmdb\Resources\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     schema="TMDB\Search Collection",
 *     type="object",
 * )
 */

class SearchCollection extends ResourceCollection
{
    /**
     * @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/TMDB\Media"))
     * @OA\Property(property="links", type="object", ref="#/components/schemas/TMDB\Pagination")
     * )
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'items' => MediaResource::collection(collect($this['results'])),
            'links' => new PaginationResource($this->resource),
        ];
    }
}
