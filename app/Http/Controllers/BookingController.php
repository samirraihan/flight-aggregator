<?php

namespace App\Http\Controllers;

use App\Actions\Bookings\CreateBookingAction;
use App\Actions\Bookings\GetBookingAction;
use App\DTOs\BookingDto;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Resources\BookingResource;
use Illuminate\Http\JsonResponse;

/**
 * Bookings
 */
class BookingController extends Controller
{
    public function __construct(
        protected CreateBookingAction $createBookingAction,
        protected GetBookingAction $getBookingAction,
    ) {
    }

    /**
     * Create booking
     *
     * Create a booking using a selected flight.
     *
     * @group Bookings
     * @param CreateBookingRequest $request
     * @return JsonResponse
     */
    public function store(
        CreateBookingRequest $request
    ): JsonResponse {
        $booking = $this->createBookingAction->execute(
            BookingDto::fromArray(
                $request->validated()
            )
        );

        return response()->json([
            'message' => 'Booking created successfully.',
            'data' => new BookingResource($booking),
        ], 201);
    }

    /**
     * Get booking
     *
     * Retrieve booking by reference.
     *
     * @group Bookings
     * @urlParam reference string required Booking reference. Example: BK-ABC123XYZ
     * @return JsonResponse
     */
    public function show(
        string $reference
    ): JsonResponse {
        $booking = $this->getBookingAction->execute(
            $reference
        );

        return response()->json([
            'data' => new BookingResource($booking),
        ]);
    }
}