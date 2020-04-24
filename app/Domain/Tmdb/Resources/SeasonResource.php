<?php


namespace App\Domain\Tmdb\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Tmdb\Helper\ImageHelper;

/**
 * @OA\Schema(
 *     schema="TMDB\TvShow\Season",
 *     type="object"
 * )
 */

class SeasonResource extends JsonResource
{
    /**
     * @OA\Property(property="id",type="integer")
     * @OA\Property(property="episode_count",type="integer")
     * @OA\Property(property="name",type="string")
     * @OA\Property(property="description",type="string")
     * @OA\Property(property="season_number",type="integer")
     * @OA\Property(property="date",type="string")
     * @OA\Property(property="poster",type="object",
     *      @OA\Property(property="small",type="string"),
     *      @OA\Property(property="original",type="string")
     * )
     * @return array
     */
    public function toArray($request)
    {
        $releaseDate = isset($this->resource['air_date']) && !empty($this->resource['air_date'])
            ? Carbon::createFromFormat('Y-m-d', $this->resource['air_date']) : null;
        $releaseDate = !is_null($releaseDate) ? $releaseDate->format('d/m/Y') : null;

        return [
            'id'            => $this->resource['id'],
            'episode_count' => $this->resource['episode_count'],
            'name'          => $this->resource['name'],
            'description'   => isset($this->resource['overview']) && !empty($this->resource['overview']) ?
                $this->resource['overview'] : null,
            'number'        => $this->resource['season_number'],
            'poster'        => new ImageResource($this->resource['poster_path'] ?? null),
            'release_date'  => $releaseDate
        ];
    }
}
