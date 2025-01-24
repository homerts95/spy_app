<?php

declare(strict_types=1);

namespace App\Application\Commands\Handlers\Spy;

use App\Application\Commands\CreateSpyCommand;
use App\Domain\Models\Spy;
use App\Domain\ValueObjects\Agency;
use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\Name;
use App\Infrastructure\EloquentModel\SpyEloquentModel;

readonly class CreateSpyCommandHandler
{
    public function handle(CreateSpyCommand $command): Spy
    {
        $spyDTO = $command->getDTO();
        $spy = $this->getDomainSpyObject($spyDTO);
        $eloquentSpy = SpyEloquentModel::fromDomainCreate($spy);
        return $spy->withId($eloquentSpy->id);
    }


    private function getDomainSpyObject($dto): Spy
    {
        $name = new Name($dto->firstName, $dto->lastName);
        $agency = Agency::from($dto->agency);
        $dateOfBirth = new Date($dto->dateOfBirth);
        $dateOfDeath = $dto->dateOfDeath ? new Date($dto->dateOfDeath) : null;

        //event trigger as well
        return Spy::create(
            name: $name,
            agency: $agency,
            countryOfOperation: $dto->countryOfOperation,
            dateOfBirth: $dateOfBirth,
            dateOfDeath: $dateOfDeath
        );
    }
}
