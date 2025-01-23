<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Application\DTOs\Spy\CreateSpyDTO;
use App\Domain\Models\Spy;
use App\Domain\ValueObjects\Agency;
use App\Domain\ValueObjects\Date;
use App\Domain\ValueObjects\Name;
use App\Application\DTOs\Spy\SpyDTO;
use App\Infrastructure\EloquentModel\SpyEloquentModel;

readonly class SpyService
{
    public function __construct(
        private CreateSpyCommandHandler $createSpyHandler
    )
    {
    }

    public function createSpy(SpyDTO $dto): Spy
    {
        $command = new CreateSpyCommand($dto);
        return $this->createSpyHandler->handle($command);
    }

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
            ->all();
    }

}
