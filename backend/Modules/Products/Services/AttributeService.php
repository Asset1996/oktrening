<?php

namespace Modules\Products\Services;

use Illuminate\Http\JsonResponse;
use Modules\Products\Models\Attribute;

class AttributeService
{
    public $Request;

    /**
     * Gets list of attributes.
     *
     * @return JsonResponse
     */
    public function getAttributes()
    {
        $Attributes = Attribute::get();

        $Response['Response'] = [
            'Attributes' => $Attributes
        ];

        return response()->json($Response, 200);
    }

    /**
     * Creates new attribute in DB.
     *
     * @return JsonResponse
     */
    public function createAttribute()
    {
        $Data = $this->Request['data'];

        $Attribute = Attribute::createAttribute(
            $Data['attribute_name'], $Data['attribute_description']
        );

        $Response['Response'] = [
            'Attribute' => $Attribute
        ];

        return response()->json($Response, 200);
    }

    /**
     * Gets single record from DB by Id.
     *
     * @param int $AttributeId
     * @return JsonResponse
     */
    public function showAttribute(int $AttributeId)
    {
        $Attribute = Attribute::where('id', $AttributeId)->firstOrFail();

        $Response['Response'] = [
            'Attribute' => $Attribute
        ];

        return response()->json($Response, 200);
    }

    /**
     * Deletes attribute from DB by Id.
     *
     * @param int $AttributeId
     * @return JsonResponse
     */
    public function deleteAttribute(int $AttributeId)
    {
        $Attribute = Attribute::where('id', $AttributeId)->firstOrFail();
        $Attribute->delete();

        $Response['Response'] = [
            'Message' => 'Attribute was successfully deleted.'
        ];

        return response()->json($Response, 200);
    }

    /**
     * Setter for $request variable.
     *
     * @param $Request
     * @return AttributeService
     */
    public function setRequest($Request)
    {
        $this->Request = $Request;
        return $this;
    }
}
