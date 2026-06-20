<?php

namespace App\Services\Flights;

use App\DTOs\FlightSearchDto;
use App\Services\Providers\ProviderManager;
use Throwable;

class FlightAggregationService
{
    public function __construct(
        protected ProviderManager $providerManager
    ) {
    }

    public function aggregate(
        FlightSearchDto $searchDto
    ): array {

        $flights = [];

        $meta = [
            'providers_requested' => 0,
            'providers_responded' => 0,
            'providers_failed' => 0,
            'failed_providers' => [],
        ];

        foreach ($this->providerManager->all() as $provider) {

            $meta['providers_requested']++;

            try {

                $results = $provider->search($searchDto);

                $flights = array_merge(
                    $flights,
                    $results
                );

                $meta['providers_responded']++;

            } catch (Throwable $e) {

                report($e);

                $meta['providers_failed']++;

                $meta['failed_providers'][] =
                    $provider->name();
            }
        }

        return [
            'flights' => $flights,
            'meta' => $meta,
        ];
    }
}