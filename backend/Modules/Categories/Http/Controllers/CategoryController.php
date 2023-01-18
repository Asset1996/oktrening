<?php

namespace Modules\Categories\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Modules\Categories\Services\CategoryService;

class CategoryController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')
            ->only('store', 'update', 'destroy');
    }
    /**
     * Gets list of all categories as tree.
     *
     * @param Request $Request
     * @return JsonResponse
     */
    public function index(Request $Request)
    {
        return (new CategoryService)
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
        return (new CategoryService)
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
        return (new CategoryService)
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
        return (new CategoryService)
            ->delete($Id);
    }
}
