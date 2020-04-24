<?php


namespace App\Domain\Tmdb\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Tmdb\Helper\ImageHelper;

/**
 * @OA\Schema(
 *     schema="TMDB\Movie"
 * )
 */

class MovieResource extends MediaResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->getData();
        $data['imdb_id']  = $this->resource['imdb_id'];
        return $data;
    }
}
