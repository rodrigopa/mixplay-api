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
     * @var array
     */
    private $relations = [];

    /**
     * MovieResource constructor.
     * @param $resource
     * @param array $relations
     */
    public function __construct($resource, $relations = [])
    {
        parent::__construct($resource);
        $this->relations = $relations;
    }

    /**
     * @OA\Property(property="id", type="integer")
     * @OA\Property(property="title", type="string")
     *
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'trailer_url' => $this->trailer_url,
            'description' => $this->description,
            'metadata' => json_decode($this->metadata)
        ];

        foreach ($this->relations as $relation) {
            if (isset($this->resource->{$relation}))
                $data[$relation] = $this->resource->{$relation};
        }

        return $data;
    }
}
