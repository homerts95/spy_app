<?php

declare(strict_types=1);

namespace App\Application\Commands;

use App\Application\DTOs\Spy\SpyDTO;

readonly class CreateSpyCommand
{
    public function __construct(
        private SpyDTO $dto
    ) {}

    public function getDTO(): SpyDTO
    {
        return $this->dto;
    }
}
