<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_slug',
        'quantity'
    ];

    /**
     * Creates new product-order record in DB.
     *
     * @param $OrderId
     * @param $ProductSlug
     * @param $Quantity
     * @return OrderProduct
     */
    public static function createOrderProduct($OrderId, $ProductSlug, $Quantity): OrderProduct
    {
        $OrderProduct = new self();
        $OrderProduct->order_id = $OrderId;
        $OrderProduct->product_slug = $ProductSlug;
        $OrderProduct->quantity = $Quantity;
        $OrderProduct->save();

        return $OrderProduct;
    }
}
