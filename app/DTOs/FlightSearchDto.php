<?php

namespace App\DTOs;

readonly class FlightSearchDto
{
    public function __construct(
        public string $from,
        public string $to,
        public string $date,
        public int $passengers = 1,
        public ?string $sort = null,
        public ?string $carrier = null,
        public ?int $stops = null,
        public ?float $maxPrice = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            from: strtoupper($data['from']),
            to: strtoupper($data['to']),
            date: $data['date'],
            passengers: (int) ($data['passengers'] ?? 1),

            sort: $data['sort'] ?? null,

            carrier: !empty($data['carrier'])
                ? strtoupper($data['carrier'])
                : null,

            stops: isset($data['stops']) && $data['stops'] !== ''
                ? (int) $data['stops']
                : null,

            maxPrice: isset($data['max_price']) && $data['max_price'] !== ''
                ? (float) $data['max_price']
                : null,
        );
    }
}
