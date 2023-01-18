<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
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

    /**
     * Error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required',
            'unique' => 'The :attribute is already used',
            'min' => 'The :attribute must be minimum :min symbols',
            'max' => 'The :attribute must be maximum :max symbols',
            'email' => 'The :attribute must be email type',
            'required_without' => 'The :attribute or :values required',
            'required_without_all' => 'The :attribute or :values required',
            'exists' => 'The :attribute does not match',
        ];
    }

    /**
     * Throws exception, when validation failed.
     *
     * @return array
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['response' => $validator->errors()], 422));
    }

    /**
     * Return validation data.
     *
     * @return array
     */
    public function GetData()
    {
        return $this->validationData();
    }
}
