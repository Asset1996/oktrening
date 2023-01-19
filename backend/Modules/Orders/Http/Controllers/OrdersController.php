<?php

namespace Modules\Orders\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Modules\Orders\Services\OrderService;
use Illuminate\Http\Request;

class OrdersController extends BaseController
{
    /**
     * Client confirms the order.
     *
     * @return JsonResponse
     */
    public function confirm(Request $Request)
    {
        return (new OrderService())
            ->setRequest($Request)
            ->confirmOrder();
    }
}
