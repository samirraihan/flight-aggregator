<?php

namespace App\Transformers;

use App\Contracts\FlightNormalizerInterface;
use App\DTOs\FlightDto;
use App\Enums\ProviderType;
use App\Support\FlightIdentifier;
use Carbon\Carbon;

class ProviderCFlightTransformer implements FlightNormalizerInterface
{
    public function transform(array $payload): array
    {
        return collect($payload['results'] ?? [])
            ->map(function (array $flight) {

                $departure = Carbon::createFromTimestamp(
                    $flight['times']['dep']
                )->toIso8601String();

                $arrival = Carbon::createFromTimestamp(
                    $flight['times']['arr']
                )->toIso8601String();

                return new FlightDto(
                    identifier: FlightIdentifier::generate(
                        $flight['iata'],
                        $flight['code'],
                        $flight['route']['src'],
                        $flight['route']['dst'],
                        $departure,
                        $arrival,
                    ),
                    provider: ProviderType::PROVIDER_C->value,
                    carrier: $flight['iata'],
                    flightNumber: $flight['code'],
                    from: $flight['route']['src'],
                    to: $flight['route']['dst'],
                    departure: $departure,
                    arrival: $arrival,
                    stops: $flight['layovers'],
                    price: (float) $flight['total_price'],
                    currency: $flight['currency'],
                    providers: [
                        ProviderType::PROVIDER_C->value,
                    ]
                );
            })
            ->values()
            ->all();
    }
}