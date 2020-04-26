<?php

namespace App\Applications\Api\Requests\Media\Movie;

use App\Domain\Account\Repositories\UserRepository;
use App\Infrastructure\Request\ApiRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\RequestBody(
 *         request="StoreMovie",
 *         description="Parâmetros para cadastrar um filme",
 *         required=true,
 *         @OA\JsonContent(
 *              @OA\Property(property="name", type="string"),
 *              @OA\Property(property="year", type="integer"),
 *              @OA\Property(property="trailer_url", type="string"),
 *              @OA\Property(property="description", type="string"),
 *              @OA\Property(property="metadata", type="string"),
 *              @OA\Property(property="videos", type="string"),
 *         )
 *     )
 */
class StoreMovie extends ApiRequest
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
            'name' => 'nome',
            'year' => 'ano',
            'trailer_url' => 'URL do trailer',
            'description' => 'descrição',
            'metadata' => 'metadata',
            'videos' => 'videos'
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
            'name' => 'required',
            'year' => 'required|integer',
            'trailer_url' => 'required|url',
            'description' => 'required',
            'videos' => 'required|json',
            'metadata' => 'required|json'
        ];
    }
}
