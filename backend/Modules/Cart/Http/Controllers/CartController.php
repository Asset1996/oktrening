<?php

namespace Modules\Cart\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Modules\Cart\Http\Requests\AddCartRequest;
use Modules\Cart\Services\CartService;

class CartController extends BaseController
{
    /**
     * Shows all products in cart.
     *
     * @return JsonResponse
     */
    public function show()
    {
        return (new CartService)
            ->showCart();
    }

    /**
     * Adds product into cart.
     *
     * @param Request $Request
     * @return JsonResponse
     */
    public function add(AddCartRequest $Request)
    {
        return (new CartService)
            ->setRequest($Request)
            ->addToCart();
    }

    /**
     * Updates product quantity in the cart.
     *
     * @param Request $Request
     * @return JsonResponse
     */
    public function update(Request $Request)
    {
        return (new CartService)
            ->setRequest($Request)
            ->updateCart();
    }

    /**
     * Removes specific product from cart.
     *
     * @param string $Slug
     * @return JsonResponse
     */
    public function delete($Slug)
    {
        return (new CartService)
            ->deleteFromCart($Slug);
    }

    /**
     * Removes all products from cart.
     *
     * @return JsonResponse
     */
    public function clear()
    {
        return (new CartService)
            ->clearCart();
    }
}
