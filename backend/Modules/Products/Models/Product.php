<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'product_name',
        'category_id',
        'product_price',
        'product_description'
    ];

    /**
     * @var $StandardFilters - are all filters, except custom filters.
     */
    protected $StandardFilters;

    /**
     * Setter for $StandardFilters variable
     * $StandardFilters - are all filters, except custom filters.
     *
     * @param $Request
     * @return Product
     */
    public function setStandardFilters()
    {
        $this->StandardFilters = array_merge(
            app(self::class)->getFillable(),
            ['product_price_from', 'product_price_to']
        );
        return $this;
    }

    public function scopeCustomFilters($query, $CustomFilers)
    {
        $query->leftJoin(
            'product_attributes_values',
            'product_attributes_values.product_slug',
            'products.slug'
        )
            ->leftJoin('attributes', 'attributes.id', 'product_attributes_values.attribute_id');
        foreach ($CustomFilers as $FilterName => $FilterValue) {
            $query->where('attributes.attribute_name', $FilterName)
                ->where('product_attributes_values.value', $FilterValue);
        }
    }

    /**
     * Scope a query to filter by category_id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeCategoryId($query, $CategoryId)
    {
        if (!is_null($CategoryId)) {
            $query->where('products.category_id', $CategoryId);
        }
    }

    /**
     * Scope a query to filter by product_price.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeProductPriceFrom($query, $ProductPriceFrom)
    {
        if (!is_null($ProductPriceFrom)) {
            $query->where('product_price', '>=', $ProductPriceFrom);
        }
    }

    /**
     * Scope a query to filter by product_price.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeProductPriceTo($query, $ProductPriceTo)
    {
        if (!is_null($ProductPriceTo)) {
            $query->where('product_price', '<=', $ProductPriceTo);
        }
    }

    /**
     * Scope a query to filter by product_name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeProductName($query, $ProductName)
    {
        if (!is_null($ProductName)) {
            $query->where('product_name', 'like', '%' . $ProductName . '%');
        }
    }

    /**
     * Creates new product in DB.
     *
     * @param string $ProductName
     * @param int $CategoryId
     * @param int $ProductPrice
     * @param string $ProductDescription
     * @return Product
     */
    public static function createProduct(
        string $ProductName, int $CategoryId, int $ProductPrice, string $ProductDescription
    ): Product
    {
        $Product = new self();
        $Product->slug = uniqid();
        $Product->product_name = $ProductName;
        $Product->category_id = $CategoryId;
        $Product->product_price = $ProductPrice;
        $Product->product_description = $ProductDescription;
        $Product->save();

        return $Product;
    }

    /**
     * Get filtered products.
     *
     * @param $Request
     * @return Product
     */
    public function getProducts($Request)
    {
        return $this->select(
            'products.id', 'products.slug', 'products.product_name', 'products.category_id', 'products.product_price',
            'products.product_description'
        )
            ->CategoryId($Request->get('category_id'))
            ->ProductPriceFrom($Request->get('product_price_from'))
            ->ProductPriceTo($Request->get('product_price_to'))
            ->ProductName($Request->get('product_name'))
            ->CustomFilters($Request->except($this->StandardFilters))
            ->groupBy('products.id')
            ->get();
    }
}
