<?php

namespace App\Actions\Bookings;

use App\Models\Booking;
use App\Services\Booking\BookingService;

class GetBookingAction
{
    public function __construct(
        protected BookingService $bookingService,
    ) {
    }

    public function execute(
        string $reference
    ): Booking {
        return $this->bookingService
            ->findByReference($reference);
    }
}