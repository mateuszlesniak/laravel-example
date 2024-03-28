<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RosterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'day' => $this->day->format('Y-m-d'),
            'activity_code' => $this->activity_code->label(),
            'flight_number' => $this->flight_number,
            'activity_start' => $this->activity_start?->format('H:i'),
            'activity_end' => $this->activity_end?->format('H:i'),
            'departure' => $this->departure?->format('H:i'),
            'arrival' => $this->arrival?->format('H:i'),
            'check_in' => $this->checkInLocation->code,
            'check_out' => $this->checkOutLocation->code,
        ];
    }
}
