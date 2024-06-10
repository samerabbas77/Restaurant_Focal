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
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // Register a creating event to change table availability
        static::creating(function ($reservation) {
            // Find the table by ID
            $table = Table::find($reservation->table_id);
            if ($table) {
                // Update the table's availability
                $table->Is_available = 'unavailable';
                $table->save();
            }
        });
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function table(){
        return $this->belongsTo(table::class);
    }
}
