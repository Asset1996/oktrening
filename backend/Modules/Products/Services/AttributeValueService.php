<?php

namespace Modules\Products\Services;

use Illuminate\Http\JsonResponse;
use Modules\Products\Models\Attribute;
use Modules\Products\Models\ProductAttributeValue;

class AttributeValueService
{
    public $Request;

    /**
     * Sets the value of product attribute.
     *
     * @return JsonResponse
     */
    public function setAttributeValue()
    {
        $Data = $this->Request['data'];

        $AttributeValue = ProductAttributeValue::createProductAttributeValue(
            $Data['attribute_id'], $Data['product_slug'], $Data['value']
        );

        $Response['Response'] = [
            'AttributeValue' => $AttributeValue
        ];

        return response()->json($Response, 200);
    }

    /**
     * Unsets the value of product attribute.
     *
     * @return JsonResponse
     */
    public function unsetAttributeValue()
    {
        $Data = $this->Request['data'];

        $AttributeValue = ProductAttributeValue::where('attribute_id', $Data['attribute_id'])
            ->where('product_slug', $Data['product_slug'])->firstOrFail();
        $AttributeValue->delete();

        $Response['Response'] = [
            'Message' => 'Value of product attribute was removed.'
        ];

        return response()->json($Response, 200);
    }

    /**
     * Setter for $request variable.
     *
     * @param $Request
     * @return AttributeValueService
     */
    public function setRequest($Request)
    {
        $this->Request = $Request;
        return $this;
    }
}
