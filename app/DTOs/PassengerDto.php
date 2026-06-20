<?php

namespace App\DTOs;

readonly class PassengerDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
        );
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ];
    }
}