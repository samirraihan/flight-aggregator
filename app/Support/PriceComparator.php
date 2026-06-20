<?php

namespace App\Support;

use App\DTOs\FlightDto;

class PriceComparator
{
    public static function cheapest(FlightDto $first, FlightDto $second): FlightDto
    {
        return $first->price <= $second->price
            ? $first
            : $second;
    }
}