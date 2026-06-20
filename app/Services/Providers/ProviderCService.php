<?php

namespace App\Services\Providers;

use App\Contracts\FlightProviderInterface;
use App\DTOs\FlightSearchDto;
use App\Enums\ProviderType;
use App\Transformers\ProviderCFlightTransformer;

class ProviderCService implements FlightProviderInterface
{
    public function __construct(
        protected ProviderCFlightTransformer $transformer
    ) {
    }

    public function search(FlightSearchDto $searchDto): array
    {
        $payload = json_decode(
            file_get_contents(config('providers.c')),
            true
        );

        return $this->transformer->transform($payload);
    }

    public function name(): string
    {
        return ProviderType::PROVIDER_C->value;
    }
}