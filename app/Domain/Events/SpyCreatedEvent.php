<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Models\Spy;
use DateTimeImmutable;

class SpyCreatedEvent
{
    public function __construct(
        private readonly Spy $spy
    ) {}

    public function getSpy(): Spy
    {
        return $this->spy;
    }

    public function toArray(): array
    {
        $spy = $this->getSpy();

        return [
            'spy_id' => $spy->getId(),
            'name' => $spy->getName(),
            'agency' => $spy->getAgency(),
            'country_of_operation' =>$spy->getCountryOfOperation(),
            'date_of_birth' => $spy->getDateOfBirth()->getValue()->format('Y-m-d'),
            'date_of_death' => $spy->getDateOfDeath()?->getValue()->format('Y-m-d'),
            'created_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
        ];
    }
}
