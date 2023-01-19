<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'order_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status_name'
    ];

    /**
     * Creates new product-order record in DB.
     *
     * @param $StatusName
     * @return OrderStatus
     */
    public static function createOrderStatus($StatusName): OrderStatus
    {
        $OrderStatus = new self();
        $OrderStatus->status_name = $StatusName;
        $OrderStatus->save();

        return $OrderStatus;
    }
}
