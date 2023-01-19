<?php

namespace Modules\Orders\Services;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Modules\Cart\Services\CartService;
use Modules\Orders\Models\Order;
use Illuminate\Support\Facades\Redis;
use Modules\Orders\Models\OrderProduct;

class OrderService
{
    public $Request;

    /**
     * Client confirms the order.
     *
     * @return JsonResponse
     */
    public function confirmOrder()
    {
        $Data = $this->Request['data'];
        $CartProducts = json_decode(Redis::get('Products'), true);

        if (!$CartProducts){
            throw new HttpResponseException(
                response()->json(['response' => 'Cart is empty.'], 404)
            );
        }
        if (auth('sanctum')->check()){
            $Email = auth('sanctum')->user()->email;
            $Phone = auth('sanctum')->user()->phone;
        }else{
            $Email = $Data['email'];
            $Phone = $Data['phone'];
        }
        $Totals = CartService::calculateCartTotal($CartProducts);

        $Order = Order::createOrder($Totals['TotalSum'], $Totals['TotalQuantity'], $Email, $Phone);
        foreach ($CartProducts as $Slug => $Product){
            OrderProduct::createOrderProduct($Order->id, $Slug, $Product['Quantity']);
        }

        Redis::del('Products');

        $Response['Response'] = [
            'Order' => $Order,
            'Message' => 'Order confirmed. Stay with us!'
        ];

        return response()->json($Response, 200);
    }

    /**
     * Get list of the current authenticated user.
     *
     * @return JsonResponse
     */
    public function getMyOrders()
    {
        $Orders = Order::getOrdersByUserId();

        $Response['Response'] = [
            'Orders' => $Orders
        ];

        return response()->json($Response, 200);
    }

    /**
     * Setter for $request variable.
     *
     * @param $Request
     * @return OrderService
     */
    public function setRequest($Request)
    {
        $this->Request = $Request;
        return $this;
    }
}
