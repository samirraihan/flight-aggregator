<?php

namespace App\Transformers;

use App\Contracts\FlightNormalizerInterface;
use App\DTOs\FlightDto;
use App\Enums\ProviderType;
use App\Support\FlightIdentifier;
use Carbon\Carbon;

class ProviderBFlightTransformer implements FlightNormalizerInterface
{
    public function transform(array $payload): array
    {
        return collect($payload['data'] ?? [])
            ->map(function (array $flight) {

                $departure = Carbon::parse(
                    $flight['departure_time']
                )->toIso8601String();

                $arrival = Carbon::parse(
                    $flight['arrival_time']
                )->toIso8601String();

                return new FlightDto(
                    identifier: FlightIdentifier::generate(
                        $flight['airline_code'],
                        $flight['number'],
                        $flight['origin'],
                        $flight['destination'],
                        $departure,
                        $arrival,
                    ),
                    provider: ProviderType::PROVIDER_B->value,
                    carrier: $flight['airline_code'],
                    flightNumber: $flight['number'],
                    from: $flight['origin'],
                    to: $flight['destination'],
                    departure: $departure,
                    arrival: $arrival,
                    stops: $flight['segments'],
                    price: (float) $flight['price']['amount'],
                    currency: $flight['price']['currency'],
                    providers: [
                        ProviderType::PROVIDER_B->value,
                    ]
                );
            })
            ->values()
            ->all();
    }
}