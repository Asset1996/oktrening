<?php

namespace Modules\Cart\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class AddCartRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required|max:255|exists:products,slug',
            'quantity' => 'integer|min:1',
        ];
    }

    /**
     * Changes the validation data.
     *
     * @return array
     */
    public function validationData()
    {
        return request()->get('data') ?? [];
    }
}
