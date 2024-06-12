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
            'user Email' => $this->user->email,
            'Table Number' => $this->table->number,
            'start Date' => $this->start_date->format('Y-m-d H:i'),
            'End date' => $this->end_date->format('Y-m-d H:i'),
            'status' => $this->status,
        ];

    }
}
