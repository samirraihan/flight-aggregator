<?php

namespace App\Services\Flights;

use App\DTOs\FlightDto;

class FlightDeduplicationService
{
    /**
     * @param FlightDto[] $flights
     *
     * @return FlightDto[]
     */
    public function handle(array $flights): array
    {
        return collect($flights)
            ->groupBy(function (FlightDto $flight) {

                return implode('|', [
                    $flight->carrier,
                    $flight->flightNumber,
                    \Carbon\Carbon::parse(
                        $flight->departure
                    )->timestamp,
                ]);
            })
            ->map(function ($group) {

                $cheapest = $group
                    ->sortBy('price')
                    ->first();

                return new FlightDto(
                    identifier: $cheapest->identifier,
                    provider: $cheapest->provider,
                    carrier: $cheapest->carrier,
                    flightNumber: $cheapest->flightNumber,
                    from: $cheapest->from,
                    to: $cheapest->to,
                    departure: $cheapest->departure,
                    arrival: $cheapest->arrival,
                    stops: $cheapest->stops,
                    price: $cheapest->price,
                    currency: $cheapest->currency,
                    providers: $group
                        ->pluck('provider')
                        ->unique()
                        ->values()
                        ->all(),
                );
            })
            ->values()
            ->all();
    }
}
