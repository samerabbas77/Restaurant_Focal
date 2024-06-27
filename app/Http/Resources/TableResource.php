<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ReservationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Number' => $this->Number,
            'chair_number' => $this->chair_number,
            'Is_available' => $this->Is_available,
            'reservations' => $this->reservations->isEmpty() ? 'No reservations yet' : ReservationResource::collection($this->reservations),

        ];;
    }
}
