<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Auth;

readonly class AuthToken
{
    public function __construct(
        private string $token,
        private string $type = 'Bearer'
    ) {}

    public function getPlainTextToken(): string
    {
        return $this->token;
    }

    public function getType(): string
    {
        return $this->type;
    }

}
