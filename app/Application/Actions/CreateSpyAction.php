<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\DTOs\CreateSpyDTO;
use App\Domain\Models\Spy;
use App\Domain\Services\SpyService;
use App\Infrastructure\EloquentModel\SpyEloquentModel;

readonly class CreateSpyAction
{
    public function __construct(
        private readonly SpyService $spyService,
    )
    {
    }

    public function execute(CreateSpyDTO $dto): SpyEloquentModel
    {
        $spy = $this->spyService->createSpy($dto);

        return $spy;
    }
}
