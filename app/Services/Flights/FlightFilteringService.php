<?php

namespace App\Services\Flights;

use App\DTOs\FlightDto;
use App\DTOs\FlightSearchDto;

class FlightFilteringService
{
    /**
     * @param FlightDto[] $flights
     * @return FlightDto[]
     */
    public function handle(
        array $flights,
        FlightSearchDto $searchDto
    ): array {

        return collect($flights)
            ->filter(function (FlightDto $flight) use ($searchDto) {

                if (
                    !empty($searchDto->carrier) &&
                    $flight->carrier !== strtoupper($searchDto->carrier)
                ) {
                    return false;
                }

                if (
                    $searchDto->stops !== null &&
                    $flight->stops !== $searchDto->stops
                ) {
                    return false;
                }

                if (
                    $searchDto->maxPrice !== null &&
                    $flight->price > $searchDto->maxPrice
                ) {
                    return false;
                }

                return true;
            })
            ->values()
            ->all();
    }
}