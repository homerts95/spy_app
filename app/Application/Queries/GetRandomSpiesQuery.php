<?php

declare(strict_types=1);

namespace App\Application\Queries;

use App\Infrastructure\EloquentModel\SpyEloquentModel;

readonly class GetRandomSpiesQuery
{
    public function __construct(
        private int $limit
    ) {}


    public function execute(): array
    {

        return SpyEloquentModel::query()
            ->inRandomOrder()
            ->limit($this->limit)
            ->get()
            ->map(fn (SpyEloquentModel $model) => $model->toDomain())
            ->all();
    }
}
