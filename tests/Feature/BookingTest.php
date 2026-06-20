<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_booking(): void
    {
        $response = $this->postJson(
            '/api/bookings',
            [
                'flight_id' => 'test-flight-id',
                'passengers' => [
                    [
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                    ],
                ],
            ]
        );

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'reference',
                ],
            ]);
    }
}