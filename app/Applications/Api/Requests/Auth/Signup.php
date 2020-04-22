<?php

namespace App\Applications\Api\Requests;

use App\Domain\Account\Repositories\UserRepository;
use App\Infrastructure\Request\ApiRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\RequestBody(
 *         request="Signup",
 *         description="Parâmetros para registro",
 *         required=true,
 *         @OA\JsonContent(
 *              @OA\Property(property="name",type="string"),
 *              @OA\Property(property="born_date", type="string", description="Formato: d/m/Y"),
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="genre", type="integer", enum= {1,2}, description="Gênero: 1 para masculino, 2 para feminino"),
 *              @OA\Property(property="password", type="string"),
 *              @OA\Property(property="password_confirmation", type="string")
 *         )
 *     )
 */
class Signup extends ApiRequest
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
            'born_date' => 'data de nascimento',
            'genre' => 'gênero',
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
            'name' => 'required',
            'born_date' => 'required|date_format:d/m/Y',
            'email' => 'required|email|unique:users',
            'genre' => ['required', Rule::in($genreOptions)],
            'password' => 'required|confirmed'
        ];
    }
}
