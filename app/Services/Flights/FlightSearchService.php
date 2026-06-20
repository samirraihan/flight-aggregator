<?php

namespace App\Services\Flights;

use App\DTOs\FlightSearchDto;

class FlightSearchService
{
    public function __construct(
        protected FlightAggregationService $aggregationService,
        protected FlightDeduplicationService $deduplicationService,
        protected FlightFilteringService $filteringService,
        protected FlightSortingService $sortingService,
    ) {
    }

    public function search(
        FlightSearchDto $searchDto
    ): array {

        $aggregated = $this->aggregationService
            ->aggregate($searchDto);

        $flights = $aggregated['flights'];

        $flights = $this->deduplicationService
            ->handle($flights);
// dd($searchDto);
        $flights = $this->filteringService
            ->handle($flights, $searchDto);
//             dd(
//     count($flights),
//     $flights
// );

        $flights = $this->sortingService
            ->handle($flights, $searchDto->sort);

        return [
            'meta' => [
                ...$aggregated['meta'],
                'total_results' => count($flights),
            ],

            'data' => $flights,
        ];
    }
}