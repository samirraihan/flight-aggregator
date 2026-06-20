<?php

namespace App\Services\Providers;

use App\Contracts\FlightProviderInterface;
use App\DTOs\FlightSearchDto;
use App\Enums\ProviderType;
use App\Transformers\ProviderAFlightTransformer;

class ProviderAService implements FlightProviderInterface
{
    public function __construct(
        protected ProviderAFlightTransformer $transformer
    ) {
    }

    public function search(FlightSearchDto $searchDto): array
    {
        $payload = json_decode(
            file_get_contents(config('providers.a')),
            true
        );

        return $this->transformer->transform($payload);
    }

    public function name(): string
    {
        return ProviderType::PROVIDER_A->value;
    }
}
