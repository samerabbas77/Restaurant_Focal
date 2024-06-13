<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'user_email' => $this->user->email,
            'table_id' => $this->table_id,
            'start_date' => $this->start_date->format('Y-m-d H:i'),
            'end_date' => $this->end_date->format('Y-m-d H:i'),
            'status' => $this->status,
            // 'created_at' => $this->created_at->format('Y-m-d H:i'),
            // 'updated_at' => $this->updated_at->format('Y-m-d H:i'),
        ];
    }
}
