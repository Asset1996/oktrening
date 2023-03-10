<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Modules\Products\Http\Requests\AddProductsRequest;
use Modules\Products\Services\ProductService;
use Modules\Products\Http\Requests\GetProductsRequest;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')
            ->only('store', 'update', 'destroy');
    }
    /**
     * Gets list of all products.
     *
     * @param GetProductsRequest $Request
     * @return JsonResponse
     */
    public function index(GetProductsRequest $Request)
    {
        return (new ProductService)
            ->setRequest($Request)
            ->getProducts();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddProductsRequest $Request
     * @return JsonResponse
     */
    public function store(AddProductsRequest $Request)
    {
        return (new ProductService)
            ->setRequest($Request)
            ->createProduct();
    }

    /**
     * Show the specified resource.
     *
     * @param string $Slug
     * @return JsonResponse
     */
    public function show(string $Slug)
    {
        return (new ProductService)
            ->showProduct($Slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $Slug
     * @return JsonResponse
     */
    public function destroy(string $Slug)
    {
        return (new ProductService)
            ->deleteProduct($Slug);
    }
}
