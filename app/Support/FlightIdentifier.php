<?php

namespace App\Support;

use Carbon\Carbon;

class FlightIdentifier
{
    public static function generate(
        string $carrier,
        string $flightNumber,
        string $from,
        string $to,
        string $departure,
        string $arrival,
    ): string {

        $departure = Carbon::parse($departure)
            ->utc()
            ->timestamp;

        $arrival = Carbon::parse($arrival)
            ->utc()
            ->timestamp;

        return sha1(
            implode('|', [
                $carrier,
                $flightNumber,
                $from,
                $to,
                $departure,
                $arrival,
            ])
        );
    }
}
