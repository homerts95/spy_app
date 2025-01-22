<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Infrastructure\EloquentModel\SpyEloquentModel;

readonly class GetRandomSpiesAction
{
    public function execute(int $limit = 5): array
    {
        return SpyEloquentModel::query()
            ->inRandomOrder()
            ->limit($limit)
            ->get()
            ->map(fn (SpyEloquentModel $model) => $model->toDomain())
            ->all();
    }
}
