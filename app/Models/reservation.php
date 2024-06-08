<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use function Laravel\Prompts\table;

class Reservation extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable =[
        'user_id',
        'table_id',
        'start_date',
        'end_date',
    ];
  
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function table(){
        return $this->belongsTo(table::class);
    }
}
