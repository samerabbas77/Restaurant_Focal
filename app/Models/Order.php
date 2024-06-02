<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable =[
            'id',
            'status',
            'user_id',
           'table_id',
           'total_price',
    ];

    public function dishes()
    {
       return $this->belongsToMany(Dish::class);
    }
}
