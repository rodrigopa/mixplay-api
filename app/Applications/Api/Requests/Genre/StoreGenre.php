<?php

namespace App\Applications\Api\Requests\Genre;

use     public function attributes()
    {
        return [
            'genre' => 'gênero'
        ];
    }
App\Domain\Account\Repositories\UserRepository;
use App\Infrastructure\Request\ApiRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\RequestBody(
 *         request="StoreGenre",
 *         description="Parâmetros para criar gênero",
 *         required=true,
 *         @OA\JsonContent(
 *              @OA\Property(property="name", type="string")
 *         )
 *     )
 */
class StoreGenre extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'name' => 'nome'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}
