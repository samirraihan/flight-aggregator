# Flight Search Aggregator

A Laravel 13 backend application that aggregates flight search results from multiple providers, normalizes different provider schemas, deduplicates flights, and exposes a unified API for searching and booking flights.

---

## Features

* Flight search aggregation from multiple providers
* Unified flight response model
* Flight deduplication
* Sorting and filtering
* Booking creation and retrieval
* Open/Closed Principle compliant provider architecture
* API documentation using Laravel Scribe
* Unit and Feature Tests

---

## Tech Stack

* PHP 8.3+
* Laravel 13
* MySQL
* Laravel Scribe
* PHPUnit

---

## Installation

Clone the repository:

```bash
git clone https://github.com/samirraihan/flight-aggregator.git
cd flight-aggregator
```

Install dependencies:

```bash
composer install
```

Copy environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Configure database credentials in `.env`.

Run migrations:

```bash
php artisan migrate
```

Generate API documentation:

```bash
php artisan scribe:generate
```

Start application:

```bash
php artisan serve
```

---

## API Documentation

After generating documentation:

```bash
php artisan scribe:generate
```

Visit:

```text
http://localhost/docs
```

---

## Search Flights

### Endpoint

```http
GET /api/flights/search
```

### Example Request

```http
GET /api/flights/search?from=DAC&to=DXB&date=2026-07-01&passengers=2
```

### Supported Filters

| Parameter | Description                         |
| --------- | ----------------------------------- |
| sort      | price, departure, arrival, duration |
| carrier   | Airline code                        |
| stops     | Number of stops                     |
| max_price | Maximum ticket price                |

---

## Create Booking

### Endpoint

```http
POST /api/bookings
```

### Request

```json
{
    "flight_id": "147c4d809cb7ed8315f5af324ba168d2b1bc4fc5",
    "passengers": [
        {
            "first_name": "John",
            "last_name": "Doe"
        }
    ]
}
```

---

## Get Booking

### Endpoint

```http
GET /api/bookings/{reference}
```

Example:

```http
GET /api/bookings/BK-ABC123XYZ
```

---

## Running Tests

```bash
php artisan test
```

---

## Future Improvements

* Async provider requests using Laravel HTTP Pool
* Redis caching
* Queue-based provider synchronization
* Provider health monitoring
* Pagination
* Booking flight snapshot persistence
* Rate limiting and throttling
* Distributed tracing and observability
