<?php

namespace App\Services\Flights;

use App\DTOs\FlightDto;
use Carbon\Carbon;

class FlightSortingService
{
    /**
     * @param FlightDto[] $flights
     *
     * @return FlightDto[]
     */
    public function handle(
        array $flights,
        ?string $sort
    ): array {

        if (!$sort) {
            return collect($flights)
                ->sortBy('price')
                ->values()
                ->all();
        }

        $descending = str_starts_with($sort, '-');

        $sortField = ltrim($sort, '-');

        $sorted = match ($sortField) {

            'price' => collect($flights)
                ->sortBy('price'),

            'departure' => collect($flights)
                ->sortBy('departure'),

            'arrival' => collect($flights)
                ->sortBy('arrival'),

            'duration' => collect($flights)
                ->sortBy(function (FlightDto $flight) {

                    return Carbon::parse($flight->arrival)
                        ->diffInMinutes(
                            Carbon::parse($flight->departure)
                        );
                }),

            default => collect($flights)
                ->sortBy('price'),
        };

        if ($descending) {
            $sorted = $sorted->reverse();
        }

        return $sorted
            ->values()
            ->all();
    }
}