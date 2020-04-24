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
 *              @OA\Property(property="video_id", type="integer"),
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
            'video_id' => 'vídeo'
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
            'video_id' => 'required|exists:videos,id'
        ];
    }
}
