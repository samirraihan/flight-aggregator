<?php

namespace App\Services\Providers;

use App\Contracts\FlightProviderInterface;
use App\DTOs\FlightSearchDto;
use App\Enums\ProviderType;
use App\Transformers\ProviderBFlightTransformer;

class ProviderBService implements FlightProviderInterface
{
    public function __construct(
        protected ProviderBFlightTransformer $transformer
    ) {
    }
    
    public function search(FlightSearchDto $searchDto): array
    {
        $payload = json_decode(
            file_get_contents(config('providers.b')),
            true
        );

        return $this->transformer->transform($payload);
    }

    public function name(): string
    {
        return ProviderType::PROVIDER_B->value;
    }
}
