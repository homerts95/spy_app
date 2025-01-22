<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\DTOs\CreateSpyDTO;
use App\Domain\Models\Spy;
use App\Domain\ValueObjects\Agency;
use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\Name;
use App\Infrastructure\EloquentModel\SpyEloquentModel;

readonly class CreateSpyAction
{
    public function execute(CreateSpyDTO $dto): Spy
    {
        $name = new Name($dto->firstName, $dto->lastName);
        $agency = Agency::from($dto->agency);
        $dateOfBirth = new Date($dto->dateOfBirth);
        $dateOfDeath = $dto->dateOfDeath ? new Date($dto->dateOfDeath) : null;

        $spy = Spy::create(
            name: $name,
            agency: $agency,
            countryOfOperation: $dto->countryOfOperation,
            dateOfBirth: $dateOfBirth,
            dateOfDeath: $dateOfDeath
        );

        $eloquentModel = SpyEloquentModel::fromDomain($spy);

        return $eloquentModel->toDomain();
    }
}
