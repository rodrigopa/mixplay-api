<?php


namespace App\Domain\Tmdb\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Tmdb\Helper\ImageHelper;

/**
 * @OA\Schema(
 *     schema="TMDB\Media",
 *     type="object"
 * )
 */

class MediaResource extends JsonResource
{
    private function getTitleOrName()
    {
        if (isset($this->resource['title']))
        {
            return $this->resource['title'];
        } else if ($this->resource['name'])
        {
            return $this->resource['name'];
        }

        return null;
    }

    /**
     * @OA\Property(property="id",type="integer")
     * @OA\Property(property="original_title",type="string")
     * @OA\Property(property="original_language",type="string")
     * @OA\Property(property="release_year",type="string")
     * @OA\Property(property="title",type="string")
     * @OA\Property(property="type",type="string")
     * @OA\Property(property="imdb_id",type="string")
     * @OA\Property(property="poster",type="object",
     *      @OA\Property(property="small",type="string"),
     *      @OA\Property(property="original",type="string")
     * )
     * @OA\Property(property="backdrop",type="object",
     *      @OA\Property(property="small",type="string"),
     *      @OA\Property(property="original",type="string")
     * )
     *
     * @return array
     */
    protected function getData()
    {
        $releaseDate = isset($this->resource['release_date']) && !empty($this->resource['release_date'])
            ? Carbon::createFromFormat('Y-m-d', $this->resource['release_date']) : null;
        $releaseYear = !is_null($releaseDate) ? $releaseDate->format('Y') : null;

        $data = [
            'id'                => $this->resource['id'],
            'original_title'    => isset($this->resource['original_title']) ?
                $this->resource['original_title'] : null,

            'original_language'  => isset($this->resource['original_language']) ?
                $this->resource['original_language'] : null,

            'description'       => isset($this->resource['overview']) && !empty($this->resource['overview']) ?
                $this->resource['overview'] : null,

            'release_year'      => $releaseYear,
            'title'             => $this->getTitleOrName(),
            'poster'            => new ImageResource($this->resource['poster_path'] ?? null),
            'backdrop'            => new ImageResource($this->resource['backdrop_path'] ?? null)
        ];

        if (isset($this->resource['media_type']))
            $data['type'] = $this->resource['media_type'];

        return $data;
    }

    public function toArray($request)
    {
        return $this->getData();
    }
}
