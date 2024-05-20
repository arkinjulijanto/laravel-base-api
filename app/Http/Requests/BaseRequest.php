<?php

namespace App\Http\Requests;

use App\Enums\Retcode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'msg' => 'validation error',
            'retcode' => Retcode::UNPROCESSABLE_ENTITY_ERROR,
            'data' => $validator->errors(),
        ], 422));
    }
}
