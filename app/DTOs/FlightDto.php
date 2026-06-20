<?php

namespace App\DTOs;

readonly class FlightDto
{
    public function __construct(
        public string $identifier,
        public string $provider,
        public string $carrier,
        public string $flightNumber,
        public string $from,
        public string $to,
        public string $departure,
        public string $arrival,
        public int $stops,
        public float $price,
        public string $currency = 'USD',
        public array $providers = [],
    ) {}

    public function toArray(): array
    {
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