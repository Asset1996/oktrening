<?php

namespace Modules\Products\Http\Requests\AttributeValue;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UnsetAttributeValueRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attribute_id' => 'required|integer|exists:attributes,id',
            'product_slug' => 'required|max:255|exists:products,slug'
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
