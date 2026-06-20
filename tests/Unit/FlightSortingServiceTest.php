<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\DTOs\FlightDto;
use App\Services\Flights\FlightSortingService;

class FlightSortingServiceTest extends TestCase
{
    public function test_it_sorts_by_price(): void
    {
        $service = new FlightSortingService();

        $cheap = new FlightDto(
            identifier: '1',
            provider: 'provider_a',
            carrier: 'AA',
            flightNumber: 'AA101',
            from: 'DAC',
            to: 'DXB',
            departure: '2026-07-01T08:00:00',
            arrival: '2026-07-01T12:00:00',
            stops: 0,
            price: 100,
        );

        $expensive = new FlightDto(
            identifier: '2',
            provider: 'provider_b',
            carrier: 'AA',
            flightNumber: 'AA102',
            from: 'DAC',
            to: 'DXB',
            departure: '2026-07-01T10:00:00',
            arrival: '2026-07-01T14:00:00',
            stops: 0,
            price: 300,
        );

        $result = $service->handle(
            [$expensive, $cheap],
            'price'
        );

        $this->assertEquals(
            100,
            $result[0]->price
        );
    }
}