<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'table_id',
        'total_price',
        'status',
    ];
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope(new UserScope);
    // }
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($order) {
    //         $order->user_id = Auth::user()->id;
    //     });
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function dishes()
{
    return $this->belongsToMany(Dish::class)->withPivot('quantity');
}


}