<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Domain\Services\SpyService;
use App\Infrastructure\EloquentModel\SpyEloquentModel;

readonly class GetRandomSpiesAction
{

    public function __construct(
        private readonly SpyService $spyService,
    )
    {
    }
    public function execute(int $limit = 5): array
    {
      return  $this->spyService->getRandomSpies($limit);
    }
}
