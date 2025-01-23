<?php

declare(strict_types=1);

namespace App\Application\DTOs\Spy;

use App\Domain\Models\Spy;

readonly class SpyResponseDTO
{

    public function __construct(
        public int     $id,
        public string  $firstName,
        public string  $lastName,
        public string  $agency,
        public string  $countryOfOperation,
        public string  $dateOfBirth,
        public ?string $dateOfDeath = null
    )
    {
    }

    public static function fromDomain(Spy $spy): self
    {
        return new self(
            id: $spy->getId(),
            firstName: $spy->getName()->getFirstName(),
            lastName: $spy->getName()->getLastName(),
            agency: $spy->getAgency()->value,
            countryOfOperation: $spy->getCountryOfOperation(),
            dateOfBirth: $spy->getDateOfBirth()->getValue()->format('Y-m-d'),
            dateOfDeath: $spy->getDateOfDeath()?->getValue()->format('Y-m-d'),
        );
    }

}
