<?php

namespace App\Applications\Api\Requests\Tmdb;

use App\Infrastructure\Request\ApiRequest;

class ValidateSearch extends ApiRequest
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
            'query.required' => 'Busca inválida.'
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
            'query' => 'required'
        ];
    }
}
