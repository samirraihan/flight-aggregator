<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    public function toArray(
        Request $request
    ): array {
        return [
            'flight_id' => $this->identifier,
            'carrier' => $this->carrier,
            'flight_number' => $this->flightNumber,
            'from' => $this->from,
            'to' => $this->to,
            'departure' => $this->departure,
            'arrival' => $this->arrival,
            'stops' => $this->stops,
            'price' => $this->price,
            'currency' => $this->currency,
            'providers' => $this->providers,
        ];
    }
}