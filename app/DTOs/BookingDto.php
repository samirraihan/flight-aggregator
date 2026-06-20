<?php

namespace App\DTOs;

readonly class BookingDto
{
    public function __construct(
        public string $flightId,
        public array $passengers,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            flightId: $data['flight_id'],
            passengers: collect($data['passengers'])
                ->map(fn ($passenger) => PassengerDto::fromArray($passenger))
                ->toArray(),
        );
    }
}