<?php

namespace App\Http\Controllers;

use App\Actions\Flights\SearchFlightsAction;
use App\DTOs\FlightSearchDto;
use App\Http\Requests\SearchFlightRequest;
use App\Http\Resources\FlightResource;
use Illuminate\Http\JsonResponse;

/**
 * Flight Search
 */
class FlightController extends Controller
{
    public function __construct(
        protected SearchFlightsAction $searchFlightsAction,
    ) {}

    /**
     * Search flights
     *
     * Search and aggregate flights from all providers.
     *
     * @group Flights
     * @param SearchFlightRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        SearchFlightRequest $request
    ): JsonResponse {
        $result = $this->searchFlightsAction->execute(
            FlightSearchDto::fromArray(
                $request->validated()
            )
        );

        return response()->json([
            'meta' => $result['meta'],
            'data' => FlightResource::collection(
                collect($result['data'])
            ),
        ]);
    }
}
