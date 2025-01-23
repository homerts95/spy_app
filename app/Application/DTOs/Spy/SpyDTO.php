<?php

declare(strict_types=1);

namespace App\Application\DTOs\Spy;

readonly class SpyDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $agency,
        public string $countryOfOperation,
        public string $dateOfBirth,
        public ?string $dateOfDeath = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            agency: $data['agency'],
            countryOfOperation: $data['country_of_operation'],
            dateOfBirth: $data['date_of_birth'],
            dateOfDeath: $data['date_of_death'] ?? null
        );
    }
}
