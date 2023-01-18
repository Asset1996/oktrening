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
     * Scope a query to filter by category_id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeCategoryId($query, $CategoryId)
    {
        if (!is_null($CategoryId)) {
            $query->where('category_id', $CategoryId);
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
}
