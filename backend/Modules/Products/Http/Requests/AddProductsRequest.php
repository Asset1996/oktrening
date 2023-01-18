<?php

namespace Modules\Products\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class AddProductsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name' => 'required|max:255',
            'category_id' => [
                'required', 'integer',
                Rule::exists('categories', 'id')->whereNotNull('parent_id')
            ],
            'product_price' => 'required|integer',
            'product_description' => 'required'
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
