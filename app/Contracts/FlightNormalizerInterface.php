<?php

namespace App\Contracts;

use App\DTOs\FlightDto;

interface FlightNormalizerInterface
{
    /**
     * @return FlightDto[]
     */
    public function transform(array $payload): array;
}