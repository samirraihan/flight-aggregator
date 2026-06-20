<?php

namespace App\Services\Booking;

use App\DTOs\BookingDto;
use App\Models\Booking;
use App\Repositories\BookingRepository;
use App\Support\ReferenceGenerator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingService
{
    public function __construct(
        protected BookingRepository $bookingRepository,
    ) {
    }

    public function create(BookingDto $bookingDto): Booking
    {
        $reference = ReferenceGenerator::booking();

        return $this->bookingRepository->create([
            'reference' => $reference,
            'flight_identifier' => $bookingDto->flightId,

            /**
             * For take-home simplicity.
             *
             * In production we'd usually store
             * flight snapshot details too.
             */
            'flight_snapshot' => null,

            'passengers' => collect($bookingDto->passengers)
                ->map(fn ($passenger) => $passenger->toArray())
                ->values()
                ->all(),
        ]);
    }

    public function findByReference(string $reference): Booking
    {
        $booking = $this->bookingRepository
            ->findByReference($reference);

        if (!$booking) {
            throw new ModelNotFoundException(
                'Booking not found.'
            );
        }

        return $booking;
    }
}