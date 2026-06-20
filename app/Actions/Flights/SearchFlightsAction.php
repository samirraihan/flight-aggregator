<?php

namespace App\Actions\Flights;

use App\DTOs\FlightSearchDto;
use App\Services\Flights\FlightSearchService;

class SearchFlightsAction
{
    public function __construct(
        protected FlightSearchService $flightSearchService,
    ) {
    }

    public function execute(
        FlightSearchDto $searchDto
    ): array {
        return $this->flightSearchService
            ->search($searchDto);
    }
}