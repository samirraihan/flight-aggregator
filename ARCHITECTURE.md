# Architecture Overview

## Goal

The objective is to provide a unified flight search API that aggregates flight data from multiple providers, despite each provider exposing a different response schema.

The system is designed to prioritize:

* Maintainability
* Extensibility
* Reliability
* Separation of concerns

---

# High-Level Flow

```text
Client
   |
   v
FlightController
   |
   v
SearchFlightsAction
   |
   v
FlightSearchService
   |
   +--> FlightAggregationService
   |         |
   |         +--> ProviderManager
   |                     |
   |                     +--> ProviderA
   |                     +--> ProviderB
   |                     +--> ProviderC
   |
   +--> FlightDeduplicationService
   |
   +--> FlightFilteringService
   |
   +--> FlightSortingService
   |
   v
FlightResource
   |
   v
Response
```

---

# Provider Architecture

Each provider implements:

```php
FlightProviderInterface
```

This allows new providers to be added without modifying existing aggregation logic.

Example:

```php
ProviderAService
ProviderBService
ProviderCService
ProviderDService
```

Adding a new provider requires:

1. Creating the provider service
2. Implementing FlightProviderInterface
3. Registering the provider in the service container

No changes are required in the aggregation service.

This follows the Open/Closed Principle.

---

# Provider Normalization

Each provider returns a different response schema.

To isolate schema differences, each provider uses a dedicated transformer.

Example:

```text
Provider A JSON
       |
       v
ProviderAFlightTransformer
       |
       v
FlightDto
```

The rest of the application only works with normalized FlightDto objects.

---

# Deduplication Strategy

Multiple providers may return the same flight with different prices.

Flights are grouped by:

```text
Carrier
Flight Number
Departure Timestamp
```

The cheapest flight is selected as the primary result.

Provider information is preserved for transparency.

Example:

```text
EK585
Provider A = $410
Provider B = $399
Provider C = $405

Result = $399
Providers = [A, B, C]
```

---

# Booking Architecture

Booking flow:

```text
BookingController
        |
        v
CreateBookingAction
        |
        v
BookingService
        |
        v
BookingRepository
        |
        v
Database
```

The repository layer isolates persistence concerns from business logic.

---

# Design Decisions

## DTOs

DTOs are used to transport data between layers and prevent coupling with HTTP requests or database models.

Examples:

```php
FlightDto
FlightSearchDto
BookingDto
```

---

## Actions

Actions act as application use-cases.

Examples:

```php
SearchFlightsAction
CreateBookingAction
GetBookingAction
```

Controllers remain thin and focused on HTTP concerns.

---

## Services

Services encapsulate business logic.

Examples:

```php
FlightSearchService
FlightAggregationService
BookingService
```

---

## Repositories

Repositories abstract database access.

Examples:

```php
BookingRepository
```

This improves testability and separation of concerns.

---

# Error Handling

Provider failures are isolated.

If one provider fails:

* Remaining providers continue to return results
* Failure metadata is included in the response

Example:

```json
{
    "providers_requested": 3,
    "providers_responded": 2,
    "providers_failed": 1
}
```

This allows consumers to understand result completeness.

---

# Scalability Considerations

Potential future improvements:

## Parallel Provider Requests

Use Laravel HTTP Pool or asynchronous requests to reduce latency.

## Caching

Cache identical searches using Redis.

## Queue Processing

Offload expensive provider synchronization tasks.

## Monitoring

Provider health checks and performance metrics.

## Pagination

Support large result sets.

---

# Testing Strategy

## Unit Tests

Focus on isolated business logic.

Examples:

```text
FlightDeduplicationServiceTest
FlightSortingServiceTest
```

## Feature Tests

Validate API behavior.

Examples:

```text
FlightSearchTest
BookingTest
```

---

# Summary

The architecture follows common Laravel enterprise patterns and SOLID principles while remaining intentionally lightweight for the scope of the assignment.

The design enables new providers to be added with minimal changes and keeps business logic independent from transport and persistence concerns.
