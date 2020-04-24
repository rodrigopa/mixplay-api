<?php


namespace App\Domain\Tmdb\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TMDB\Pagination",
 *     type="object",
 * )
 */
class PaginationResource extends JsonResource
{
    /**
     *          @OA\Property(
     *               type="object",
     *               @OA\Property(
     *                   property="total",
     *                   description="Total de resultados",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="total_pages",
     *                   description="Total de páginas",
     *                   type="integer"
     *               ),
     *               @OA\Property(
     *                   property="current_page",
     *                   description="Página atual",
     *                   type="integer"
     *               ),
     *           )
     */
    public function toArray($request)
    {
        return [
            'total_pages' => $this['total_pages'],
            'current_page' => $this['page'],
            'total' => $this['total_results']
        ];
    }
}
