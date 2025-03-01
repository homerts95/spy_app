<?php

declare(strict_types=1);

namespace App\Application\DTOs\Auth;

readonly class LoginRequestDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
        );
    }
}
