<?php

namespace App\Infrastructure\Request;

use App\Infrastructure\Response\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    use ApiResponse;

    protected function failedValidation(Validator $validator)
    {
        $data = ['errors' => $validator->errors()->toArray()];
        $jsonResponse = $this->responseFail($data, 422);
        throw new HttpResponseException($jsonResponse);
    }

}
