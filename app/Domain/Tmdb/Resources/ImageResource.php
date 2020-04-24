<?php


namespace App\Domain\Tmdb\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Tmdb\Helper\ImageHelper;

class ImageResource extends JsonResource
{
    public function toArray($request)
    {
        if (empty($this->resource) || is_null($this->resource))
            return $this->getSizes();

        $imageHelper = resolve(ImageHelper::class);

        // images
        $small = $imageHelper->getUrl($this->resource, 'w200');
        $medium = $imageHelper->getUrl($this->resource, 'w780');
        $original = $imageHelper->getUrl($this->resource, 'original');

        return $this->getSizes($small, $medium, $original);
    }

    private function getSizes($small = null, $medium = null, $original = null)
    {
        return [
            'small' => $small,
            'medium' => $medium,
            'original' => $original
        ];
    }
}
