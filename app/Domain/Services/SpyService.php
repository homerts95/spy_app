<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Application\DTOs\CreateSpyDTO;
use App\Domain\Models\Spy;
use App\Domain\ValueObjects\Agency;
use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\Name;
use App\Infrastructure\EloquentModel\SpyEloquentModel;

readonly class SpyService
{
    public function __construct()
    {
    }

    public function createSpy(CreateSpyDTO $dto): SpyEloquentModel
    {
        $spy = $this->createDomainModel($dto);
        return SpyEloquentModel::fromDomainCreate($spy);
    }

    private function createDomainModel(CreateSpyDTO $dto)
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

        return $spy;
    }

    public function getRandomSpies(int $limit): array
    {
        return SpyEloquentModel::query()
            ->inRandomOrder()
            ->limit($limit)
            ->get()
            ->map(fn(SpyEloquentModel $model) => $model->toDomain())
            ->all();
    }

}
