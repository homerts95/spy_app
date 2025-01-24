<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Application\Commands\CreateSpyCommand;
use App\Application\Commands\Handlers\Spy\CreateSpyCommandHandler;
use App\Application\DTOs\Spy\SpyDTO;
use App\Application\DTOs\Spy\SpyResponseDTO;
use App\Application\Queries\GetRandomSpiesQuery;
use App\Domain\Models\Spy;

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


    public function getRandomSpies(int $limit): array
    {
        $query = new GetRandomSpiesQuery($limit);
        $spies = $query->execute();

        return array_map(
            fn ($spy) => SpyResponseDTO::fromDomain($spy),
            $spies
        );
    }

}
