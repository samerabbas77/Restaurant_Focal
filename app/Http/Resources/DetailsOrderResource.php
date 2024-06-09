<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsOrderResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'dishes' => $this->dishes->map(function ($dish) {
                return [
                    'name' => $dish->name,
                    'price' => $dish->price,
                    'quantity' => $dish->pivot->quantity,
                ];
            }),
        ];
    }
}


