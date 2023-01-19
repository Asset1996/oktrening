<?php

namespace Modules\Products\Services;

use Illuminate\Http\JsonResponse;
use Modules\Products\Models\Product;
use Modules\Products\Models\ProductAttributeValue;

class ProductService
{
    public $Request;

    /**
     * Gets list of products.
     *
     * @return JsonResponse
     */
    public function getProducts()
    {
        $Product = (new Product())->setStandardFilters()
            ->getProducts($this->Request);

        $Product = $Product->each(function ($item){
            $AttributeValues = ProductAttributeValue::getByProductSlug($item->slug);
            $item['custom_attributes'] = $AttributeValues;
        });

        $Response['Response'] = [
            'Products' => $Product
        ];

        return response()->json($Response, 200);
    }

    /**
     * Creates new product in DB.
     *
     * @return JsonResponse
     */
    public function createProduct()
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
     * @param string $Slug
     * @return JsonResponse
     */
    public function showProduct(string $Slug)
    {
        $Product = Product::where('slug', $Slug)->firstOrFail();
        $AttributeValues = ProductAttributeValue::select(
            'product_attributes_values.value', 'attributes.attribute_name'
        )
            ->leftJoin('attributes', 'attributes.id', 'product_attributes_values.attribute_id')
            ->where('product_attributes_values.product_slug', $Product->slug)
            ->get();

        $Product['custom_attributes'] = $AttributeValues;

        $Response['Response'] = [
            'Product' => $Product
        ];

        return response()->json($Response, 200);
    }

    /**
     * Deletes product from DB by Id.
     *
     * @param string $Slug
     * @return JsonResponse
     */
    public function deleteProduct(string $Slug)
    {
        $Product = Product::where('slug', $Slug)->firstOrFail();
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
