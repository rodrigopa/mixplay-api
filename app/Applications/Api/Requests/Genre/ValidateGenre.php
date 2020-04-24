<?php

namespace App\Applications\Api\Requests\Genre;

use App\Infrastructure\Request\ApiRequest;

class ValidateGenre extends ApiRequest
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

    public function messages()
    {
        return [
            'genre.exists' => 'O gênero não existe.'
        ];
    }

    public function validationData()
    {
        return $this->route()->parameters();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'genre' => 'required|exists:genres,id'
        ];
    }
}
