<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

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
