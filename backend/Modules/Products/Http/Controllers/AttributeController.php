<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Modules\Products\Services\AttributeService;

class AttributeController extends BaseController
{
    /**
     * Gets list of all attributes.
     *
     * @param Request $Request
     * @return JsonResponse
     */
    public function index(Request $Request)
    {
        return (new AttributeService)
            ->setRequest($Request)
            ->getAttributes();
    }

    /**
     * Store a newly created attribute in storage.
     *
     * @param Request $Request
     * @return JsonResponse
     */
    public function store(Request $Request)
    {
        return (new AttributeService)
            ->setRequest($Request)
            ->createAttribute();
    }

    /**
     * Show the specified attribute.
     *
     * @param int $AttributeId
     * @return JsonResponse
     */
    public function show(int $AttributeId)
    {
        return (new AttributeService)
            ->showAttribute($AttributeId);
    }

    /**
     * Remove the specified attribute from storage.
     *
     * @param int $AttributeId
     * @return JsonResponse
     */
    public function destroy(int $AttributeId)
    {
        return (new AttributeService)
            ->deleteAttribute($AttributeId);
    }
}
