<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\DTOs\FlightDto;
use App\Services\Flights\FlightDeduplicationService;

class FlightDeduplicationServiceTest extends TestCase
{
    public function test_it_keeps_cheapest_duplicate(): void
    {
        $service = new FlightDeduplicationService();

        $flight1 = new FlightDto(
            identifier: '1',
            provider: 'provider_a',
            carrier: 'EK',
            flightNumber: 'EK585',
            from: 'DAC',
            to: 'DXB',
            departure: '2026-07-01T03:45:00',
            arrival: '2026-07-01T06:50:00',
            stops: 0,
            price: 410,
            providers: ['provider_a']
        );

        $flight2 = new FlightDto(
            identifier: '2',
            provider: 'provider_b',
            carrier: 'EK',
            flightNumber: 'EK585',
            from: 'DAC',
            to: 'DXB',
            departure: '2026-07-01T03:45:00',
            arrival: '2026-07-01T06:50:00',
            stops: 0,
            price: 399,
            providers: ['provider_b']
        );

        $result = $service->handle([
            $flight1,
            $flight2,
        ]);

        $this->assertCount(1, $result);

        $this->assertEquals(
            399,
            $result[0]->price
        );
    }
}