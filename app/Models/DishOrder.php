<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishOrder extends Pivot
{
    use SoftDeletes;

    protected $table = 'dish_order';
   
}
