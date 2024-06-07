<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable =[
        'user_id',
        'table_id',
        'total_price',
        'status',
    ];
    protected $dates = ['deleted_at'];
    
    public static $searchable = ['user_id','table_id','total_price','status'];
    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'dish_order')->withPivot('quantity');
    }

}
