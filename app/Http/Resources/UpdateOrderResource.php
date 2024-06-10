<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdateOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'user name' => $this->user->name,
            'table number' => $this->table_id,
            'total price' => $this->total_price,
            'status' => $this->status,
            'dishes' =>$this->dishes->map(function ($dish) {
                return [
                    'name' => $dish->name,
                    'price' => $dish->price,
                    'quantity' => $dish->pivot->quantity,
                ];
            }),
        ];
    }
}


