<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\DTOs\Spy\SpyDTO;
use App\Domain\Services\SpyService;
use App\Infrastructure\EloquentModel\SpyEloquentModel;

readonly class CreateSpyAction
{
    public function __construct(
        private SpyService $spyService,
    )
    {
    }

    public function execute(SpyDTO $dto): SpyEloquentModel
    {
        return $this->spyService->createSpy($dto);
    }
}
