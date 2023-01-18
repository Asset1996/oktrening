<?php

namespace Modules\Products\Services;

use Illuminate\Http\JsonResponse;
use Modules\Products\Models\Product;

class ProductService
{
    public $Request;

    /**
     * Gets list of products.
     *
     * @return JsonResponse
     */
    public function getList()
    {
        $Product = Product::CategoryId($this->Request->get('category_id'))
            ->ProductPriceFrom($this->Request->get('product_price_from'))
            ->ProductPriceTo($this->Request->get('product_price_to'))
            ->ProductName($this->Request->get('product_name'));

        $Response['Response'] = [
            'Products' => $Product->get()
        ];

        return response()->json($Response, 200);
    }

    /**
     * Creates new product in DB.
     *
     * @return JsonResponse
     */
    public function create()
    {
        $Data = $this->Request['data'];

        $Product = Product::createProduct(
            $Data['product_name'], $Data['category_id'], $Data['product_price'], $Data['product_description']
        );

        $Response['Response'] = [
            'Product' => $Product
        ];

        return response()->json($Response, 200);
    }

    /**
     * Gets single record from DB by Id.
     *
     * @return JsonResponse
     */
    public function show($Id)
    {
        $Product = Product::findorfail($Id);

        $Response['Response'] = [
            'Product' => $Product
        ];

        return response()->json($Response, 200);
    }

    /**
     * Deletes product from DB by Id.
     *
     * @return JsonResponse
     */
    public function delete($Id)
    {
        $Product = Product::findorfail($Id);
        $Product->delete();

        $Response['Response'] = [
            'Message' => 'Product was successfully deleted.'
        ];

        return response()->json($Response, 200);
    }

    /**
     * Setter for $request variable.
     *
     * @param $Request
     * @return ProductService
     */
    public function setRequest($Request)
    {
        $this->Request = $Request;
        return $this;
    }
}