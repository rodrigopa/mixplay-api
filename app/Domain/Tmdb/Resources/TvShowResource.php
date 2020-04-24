<?php


namespace App\Domain\Tmdb\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Tmdb\Helper\ImageHelper;

/**
 * @OA\Schema(
 *     schema="TMDB\TvShow",
 *     type="object",
 * )
 */

class TvShowResource extends MediaResource
{
    /**
     * @OA\Property(property="episodes_count",type="integer")
     * @OA\Property(property="seasons_count",type="integer")
     *
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->getData();
        $data['episodes_count']  = $this->resource['number_of_episodes'];
        $data['seasons_count']  = $this->resource['number_of_seasons'];
        $data['seasons'] = SeasonResource::collection(collect($this->resource['seasons']));
        $data['imdb_id'] = isset($this->resource['external_ids']['imdb_id']) ?
            $this->resource['external_ids']['imdb_id'] : null;
        return $data;
    }
}
