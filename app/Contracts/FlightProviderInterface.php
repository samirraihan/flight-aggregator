<?php

namespace App\Contracts;

use App\DTOs\FlightSearchDto;

interface FlightProviderInterface
{
    public function search(FlightSearchDto $searchDto): array;

    public function name(): string;
}