<?php


namespace App\Infrastructure\Resource;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


/**
 * @OA\Schema(
 *     schema="Pagination",
 *     type="object",
 * )
 */
class PaginationResource extends JsonResource
{
    /**
     *          @OA\Property(
     *               type="object",
     *               @OA\Property(
     *                   property="total_pages",
     *                   description="Total de páginas",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="current_page",
     *                   description="Página atual",
     *                   type="string"
     *               ),
 *                   @OA\Property(
     *                   property="total",
     *                   description="Total de registros",
     *                   type="string"
     *               ),
     *           )
     */
    public function toArray($request)
    {
        return [
            'total_pages' => $this->lastPage(),
            'current_page' => $this->currentPage(),
            'total' => $this->total()
        ];
    }
}
