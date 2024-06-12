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
            'user name'  => $this->user->name,
            'Tabel'      => $this->table->number,
            'Start Date' => $this->start_date,
            'End Date'   =>$this->end_date,

        ];;
    }
}
