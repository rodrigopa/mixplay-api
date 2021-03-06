<?php

namespace App\Domain\Account\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 * )
 */

class UserResource extends JsonResource
{
    /**
     * @OA\Property(property="id",type="integer")
     * @OA\Property(property="name",type="string")
     * @OA\Property(property="email",type="string")
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}
