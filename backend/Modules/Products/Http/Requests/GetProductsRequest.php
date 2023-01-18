<?php

namespace Modules\Products\Http\Requests;

use App\Http\Requests\BaseRequest;

class GetProductsRequest extends BaseRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name' => 'max:255',
            'category_id' => 'integer|exists:categories,id',
            'product_price_from' => 'integer',
            'product_price_to' => 'integer|gte:product_price_from'
        ];
    }
}
