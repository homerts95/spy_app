<?php

namespace App\Infrastructure\EloquentModel;

use App\Domain\Models\Spy;
use App\Domain\ValueObjects\Agency;
use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\Name;
use Illuminate\Database\Eloquent\Model;

class SpyEloquentModel extends Model
{
    protected $table = 'spies';

    protected $fillable = [
        'first_name',
        'last_name',
        'agency',
        'country_of_operation',
        'date_of_birth',
        'date_of_death'
    ];

    protected $casts = [
        'date_of_birth' => 'datetime',
        'date_of_death' => 'datetime'
    ];

    public function getName(): Name
    {
        return new Name($this->first_name, $this->last_name);
    }

    public function getAgency(): Agency
    {
        return Agency::from($this->agency);
    }

    public function getCountryOfOperation(): string
    {
        return $this->country_of_operation;
    }

    public function getDateOfBirth(): Date
    {
        return new Date($this->date_of_birth->format('Y-m-d'));
    }

    public function getDateOfDeath(): ?Date
    {
        return $this->date_of_death
            ? new Date($this->date_of_death->format('Y-m-d'))
            : null;
    }

    public static function fromDomainCreate(Spy $spy): self
    {
        return static::create([
            'first_name' => $spy->getName()->getFirstName(),
            'last_name' => $spy->getName()->getLastName(),
            'agency' => $spy->getAgency()->value,
            'country_of_operation' => $spy->getCountryOfOperation(),
            'date_of_birth' => $spy->getDateOfBirth()->getValue(),
            'date_of_death' => $spy->getDateOfDeath()?->getValue()
        ]);
    }

    public function toDomain(): Spy
    {
        return new Spy(
            name: $this->getName(),
            agency: $this->getAgency(),
            countryOfOperation: $this->getCountryOfOperation(),
            dateOfBirth: $this->getDateOfBirth(),
            dateOfDeath: $this->getDateOfDeath()
        );
    }
}
