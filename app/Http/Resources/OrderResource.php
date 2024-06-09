<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->user->name,
            'table_id' => $this->table_id,
            'total_price' => $this->total_price,
            'status' => $this->status, 
        ];
    }
}

