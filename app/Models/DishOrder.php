<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishOrder extends Pivot
{
    use SoftDeletes;

    protected $table = 'dish_order';
    protected $dates = ['deleted_at'];

    public static function restoreDisheOrders($orderId)
    {
        return static::withTrashed()
            ->where('order_id', $orderId)
            ->update(['deleted_at' => null]);
    }
}
