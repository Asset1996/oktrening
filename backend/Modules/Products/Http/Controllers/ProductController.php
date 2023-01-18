<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
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
            ->getList();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $Request
     * @return JsonResponse
     */
    public function store(Request $Request)
    {
        return (new ProductService)
            ->setRequest($Request)
            ->create();
    }

    /**
     * Show the specified resource.
     *
     * @param int $Id
     * @return JsonResponse
     */
    public function show(int $Id)
    {
        return (new ProductService)
            ->show($Id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $Id
     * @return JsonResponse
     */
    public function destroy(int $Id)
    {
        return (new ProductService)
            ->delete($Id);
    }
}