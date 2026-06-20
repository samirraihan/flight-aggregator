<?php

namespace App\Services\Providers;

use App\Contracts\FlightProviderInterface;

class ProviderManager
{
    /**
     * @param FlightProviderInterface[] $providers
     */
    public function __construct(
        protected iterable $providers
    ) {
    }

    /**
     * @return FlightProviderInterface[]
     */
    public function all(): iterable
    {
        return $this->providers;
    }
}