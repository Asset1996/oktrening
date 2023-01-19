<?php

namespace Modules\Cart\Services;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Modules\Products\Models\Product;
use Illuminate\Support\Facades\Redis;

class CartService
{
    public $Request;

    /**
     * Show all the product in the cart.
     *
     * @return JsonResponse
     */
    public function showCart()
    {
        $CartProducts = json_decode(Redis::get('Products'), true);

        $Totals = self::calculateCartTotal($CartProducts);

        $Response['Response'] = [
            'Cart' => $CartProducts,
            'TotalSum' => $Totals['TotalSum'],
            'TotalQuantity' => $Totals['TotalQuantity']
        ];

        return response()->json($Response, 200);
    }

    /**
     * Adds products into cart.
     *
     * @return JsonResponse
     */
    public function addToCart()
    {
        $Slug = $this->Request['data']['slug'];
        $Quantity = $this->Request['data']['quantity'];
        $RedisData = Redis::get('Products') ? json_decode(Redis::get('Products'), true) : [];

        if (array_key_exists($Slug, $RedisData)){
            $RedisData[$Slug]['Quantity'] = $RedisData[$Slug]['Quantity'] + $Quantity;
            $RedisData[$Slug]['TotalPrice'] = $RedisData[$Slug]['ProductPrice'] * $RedisData[$Slug]['Quantity'];
        }else{
            $Product = Product::where('slug', $Slug)->first();
            $RedisData[$Slug] = [
                'Quantity' => $Quantity,
                'ProductName' => $Product->product_name,
                'ProductPrice' => $Product->product_price,
                'TotalPrice' => $Product->product_price * $Quantity
            ];
        }

        Redis::set('Products', json_encode($RedisData));

        $Totals = self::calculateCartTotal($RedisData);

        $Response['Response'] = [
            'Cart' => $RedisData,
            'TotalSum' => $Totals['TotalSum'],
            'TotalQuantity' => $Totals['TotalQuantity']
        ];

        return response()->json($Response, 200);
    }

    /**
     * Updates product quantity in the cart.
     *
     * @return JsonResponse
     */
    public function updateCart()
    {
        $Slug = $this->Request['data']['slug'];
        $Quantity = $this->Request['data']['quantity'];
        $RedisData = Redis::get('Products') ? json_decode(Redis::get('Products'), true) : [];

        if (!array_key_exists($Slug, $RedisData)){
            throw new HttpResponseException(
                response()->json(['response' => 'Cart does not contain this product.'], 404)
            );
        }

        $RedisData[$Slug]['Quantity'] = $Quantity;
        $RedisData[$Slug]['TotalPrice'] = $RedisData[$Slug]['ProductPrice'] * $Quantity;
        Redis::set('Products', json_encode($RedisData));

        $Totals = self::calculateCartTotal($RedisData);

        $Response['Response'] = [
            'Cart' => $RedisData,
            'TotalSum' => $Totals['TotalSum'],
            'TotalQuantity' => $Totals['TotalQuantity']
        ];

        return response()->json($Response, 200);
    }

    /**
     * Removes specific product from cart.
     *
     * @param $Slug
     * @return JsonResponse
     */
    public function deleteFromCart($Slug)
    {
        $RedisData = Redis::get('Products') ? json_decode(Redis::get('Products'), true) : [];

        if (!array_key_exists($Slug, $RedisData)){
            throw new HttpResponseException(
                response()->json(['response' => 'Cart does not contain this product.'], 404)
            );
        }

        unset($RedisData[$Slug]);
        Redis::set('Products', json_encode($RedisData));

        $Totals = self::calculateCartTotal($RedisData);

        $Response['Response'] = [
            'Cart' => $RedisData,
            'TotalSum' => $Totals['TotalSum'],
            'TotalQuantity' => $Totals['TotalQuantity'],
            'Message' => 'Product was successfully removed from cart.'
        ];

        return response()->json($Response, 200);
    }

    /**
     * Removes all products from cart.
     *
     * @return JsonResponse
     */
    public function clearCart()
    {
        Redis::del('Products');

        $Response['Response'] = [
            'Message' => 'Cart is clear.'
        ];

        return response()->json($Response, 200);
    }

    /**
     * Calculates the overall price sum and quantity of products in cart.
     *
     * @param $CartProducts
     * @return array
     */
    public static function calculateCartTotal($CartProducts)
    {
        $TotalSum = 0;
        $TotalQuantity = 0;

        if ($CartProducts){
            foreach ($CartProducts as $Product){
                $TotalSum = $TotalSum + $Product['TotalPrice'];
                $TotalQuantity = $TotalQuantity + $Product['Quantity'];
            }
        }

        return [
            'TotalSum' => $TotalSum,
            'TotalQuantity' => $TotalQuantity
        ];
    }

    /**
     * Setter for $request variable.
     *
     * @param $Request
     * @return CartService
     */
    public function setRequest($Request)
    {
        $this->Request = $Request;
        return $this;
    }
}
