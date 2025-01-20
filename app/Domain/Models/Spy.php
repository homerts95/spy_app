<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\ValueObjects\Agency;
use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\Name;

class Spy
{
    private int $id;
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
        //todo trigger event
        return new self($name, $agency, $countryOfOperation, $dateOfBirth, $dateOfDeath);
    }
}
