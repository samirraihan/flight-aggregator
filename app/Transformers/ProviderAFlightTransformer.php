<?php

namespace App\Transformers;

use App\Contracts\FlightNormalizerInterface;
use App\DTOs\FlightDto;
use App\Enums\ProviderType;
use App\Support\FlightIdentifier;
use Carbon\Carbon;

class ProviderAFlightTransformer implements FlightNormalizerInterface
{
    public function transform(array $payload): array
    {
        return collect($payload['flights'] ?? [])
            ->map(function (array $flight) {

                return new FlightDto(
                    identifier: FlightIdentifier::generate(
                        $flight['carrier'],
                        $flight['flight_no'],
                        $flight['from'],
                        $flight['to'],
                        $flight['depart'],
                        $flight['arrive'],
                    ),
                    provider: ProviderType::PROVIDER_A->value,
                    carrier: $flight['carrier'],
                    flightNumber: $flight['flight_no'],
                    from: $flight['from'],
                    to: $flight['to'],
                    departure: Carbon::parse(
                        $flight['depart']
                    )->utc()->toIso8601String(),
                    arrival: Carbon::parse(
                        $flight['arrive']
                    )->utc()->toIso8601String(),
                    stops: $flight['stops'],
                    price: (float) $flight['fare_usd'],
                    currency: 'USD',
                    providers: [
                        ProviderType::PROVIDER_A->value,
                    ]
                );
            })
            ->values()
            ->all();
    }
}
