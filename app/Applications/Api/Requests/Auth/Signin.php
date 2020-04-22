<?php

namespace App\Applications\Api\Requests;

use App\Domain\Account\Repositories\UserRepository;
use App\Infrastructure\Request\ApiRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\RequestBody(
 *         request="Signin",
 *         description="Parâmetros para login",
 *         required=true,
 *         @OA\JsonContent(
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="password", type="string")
 *         )
 *     )
 */
class Signin extends ApiRequest
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
            'password' => 'senha'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $genreOptions = UserRepository::getAvailableGenres()->keys();

        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
