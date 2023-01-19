<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Modules\Products\Services\AttributeValueService;
use Modules\Products\Http\Requests\AttributeValue\SetAttributeValueRequest;
use Modules\Products\Http\Requests\AttributeValue\UnsetAttributeValueRequest;

class AttributeValueController extends BaseController
{
    /**
     * Sets the value of product attribute.
     *
     * @param SetAttributeValueRequest $Request
     * @return JsonResponse
     */
    public function set(SetAttributeValueRequest $Request)
    {
        return (new AttributeValueService)
            ->setRequest($Request)
            ->setAttributeValue();
    }

    /**
     * Unsets the value of product attribute.
     *
     * @param UnsetAttributeValueRequest $Request
     * @return JsonResponse
     */
    public function unset(UnsetAttributeValueRequest $Request)
    {
        return (new AttributeValueService)
            ->setRequest($Request)
            ->unsetAttributeValue();
    }
}
