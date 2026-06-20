<?php

namespace App\Actions\Bookings;

use App\DTOs\BookingDto;
use App\Models\Booking;
use App\Services\Booking\BookingService;

class CreateBookingAction
{
    public function __construct(
        protected BookingService $bookingService,
    ) {
    }

    public function execute(
        BookingDto $bookingDto
    ): Booking {
        return $this->bookingService
            ->create($bookingDto);
    }
}