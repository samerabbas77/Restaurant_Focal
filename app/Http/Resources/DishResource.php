<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            'price' => $this->price,
            "descraption" => $this->descraption,
            'photo' => $this->photo,
            "cat_id" => $this->category->name,
        ];
    }
}
