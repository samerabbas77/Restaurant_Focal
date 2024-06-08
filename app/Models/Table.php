<?php

namespace App\Models;

use App\Models\reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

  
    protected $fillable = [
        'Number',
        'chair_number',
        'Is_available',
    ];


    public function reservation(){
        return $this->hasMany(reservation::class);
    }
    

}
