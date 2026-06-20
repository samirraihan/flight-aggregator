<?php

namespace Tests\Feature;

use Tests\TestCase;

class FlightSearchTest extends TestCase
{
    public function test_can_search_flights(): void
    {
        $response = $this->postJson(
            '/api/flights/search',
            [
                'from' => 'DAC',
                'to' => 'DXB',
                'date' => '2026-07-01',
                'passengers' => 2,
            ]
        );

        $response
            ->assertOk()
            ->assertJsonStructure([
                'meta' => [
                    'providers_requested',
                    'providers_responded',
                    'providers_failed',
                    'total_results',
                ],
                'data',
            ]);
    }
}