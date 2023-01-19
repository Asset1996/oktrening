<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'order_sum',
        'client_email',
        'client_phone',
        'order_status_id'
    ];

    /**
     * Creates new product in DB.
     *
     * @param $ProductName
     * @param $CategoryId
     * @param $ProductPrice
     * @param $ProductDescription
     * @return Order
     */
    public static function createOrder($OrderSum, $OrderQuantity, $ClientEmail, $ClientPhone = null): Order
    {
        $Order = new self();
        $Order->user_id = auth('sanctum')->check() ? auth('sanctum')->user()->id : null;
        $Order->order_sum = $OrderSum;
        $Order->order_quantity = $OrderQuantity;
        $Order->client_email = $ClientEmail;
        $Order->client_phone = $ClientPhone;
        $Order->order_status_id = 1;
        $Order->save();

        return $Order;
    }
}
