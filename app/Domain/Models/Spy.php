<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Events\HasDomainEvents;
use App\Domain\Events\SpyCreatedEvent;
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
        Name   $name,
        Agency $agency,
        string $countryOfOperation,
        Date   $dateOfBirth,
        ?Date  $dateOfDeath = null
    )
    {
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
        Date   $dateOfBirth,
        ?Date  $dateOfDeath = null
    ): self
    {
        $spy = new self($name, $agency, $countryOfOperation, $dateOfBirth, $dateOfDeath);
        $spy->addDomainEvent(new SpyCreatedEvent($spy)); // event is recorded because is not handled here

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
}
