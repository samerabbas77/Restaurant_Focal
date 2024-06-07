<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =[
        'service_rating',
        'user_id',
        'comments',
    ];
    public static $searchable = ['service_rating','user_id','comments'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
