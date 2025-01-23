<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Events\SpyCreatedEvent;
use App\Domain\Events\Traits\HasDomainEvents;
use App\Domain\ValueObjects\Agency;
use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\Name;

class Spy
{
    use HasDomainEvents;

    private ?int $id;
    private Name $name;
    private Agency $agency;
    private string $countryOfOperation;
    private Date $dateOfBirth;
    private ?Date $dateOfDeath;

    public function __construct(
        ?int $id = null,
        Name   $name,
        Agency $agency,
        string $countryOfOperation,
        Date   $dateOfBirth,
        ?Date  $dateOfDeath = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->agency = $agency;
        $this->countryOfOperation = $countryOfOperation;
        $this->dateOfBirth = $dateOfBirth;
        $this->dateOfDeath = $dateOfDeath;
    }

    public static function create(
        Name   $name,
        Agency $agency,
        string $countryOfOperation,
        Date $dateOfBirth,
        ?Date $dateOfDeath = null
    ): self {

        $spy = new self(
            id: null,
            name: $name,
            agency: $agency,
            countryOfOperation: $countryOfOperation,
            dateOfBirth: $dateOfBirth,
            dateOfDeath: $dateOfDeath
        );

        $spy->addDomainEvent(new SpyCreatedEvent($spy));

        return $spy;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getAgency(): Agency
    {
        return $this->agency;
    }

    public function getCountryOfOperation(): string
    {
        return $this->countryOfOperation;
    }

    public function getDateOfBirth(): Date
    {
        return $this->dateOfBirth;
    }

    public function getDateOfDeath(): ?Date
    {
        return $this->dateOfDeath;
    }

    public function withId(int $id): self
    {
        return new self(
            id: $id,
            name: $this->name,
            agency: $this->agency,
            countryOfOperation: $this->countryOfOperation,
            dateOfBirth: $this->dateOfBirth,
            dateOfDeath: $this->dateOfDeath
        );
    }
}
