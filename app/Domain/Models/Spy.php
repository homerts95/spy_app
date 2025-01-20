<?php

declare(strict_types=1);
namespace App\Domain\Models;

use Illuminate\Support\Facades\Date;

class Spy
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $agency;
    private string $countryOfOperation;
    private Date $dateOfBirth;
    private ?Date $dateOfDeath;

    //todo VOs
    public function __construct(
        string $firstName,
        string $lastName,
        string $agency,
        string $countryOfOperation,
        Date $dateOfBirth,
        ?Date $dateOfDeath = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->agency = $agency;
        $this->countryOfOperation = $countryOfOperation;
        $this->dateOfBirth = $dateOfBirth;
        $this->dateOfDeath = $dateOfDeath;
    }

    public static function create(
        string $firstName,
        string $lastName,
        string $agency,
        string $countryOfOperation,
        Date $dateOfBirth,
        ?Date $dateOfDeath = null
    ): self {
        //todo trigger event
        return new self($firstName,$lastName, $agency, $countryOfOperation, $dateOfBirth, $dateOfDeath);
    }
}
