<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;


use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Domain\Services\Auth\AuthenticationService;
use App\Domain\ValueObjects\Auth\AuthToken;
use App\Exceptions\InvalidCredentialsException;

readonly class LoginAction
{
    public function __construct(
        private AuthenticationService $authService
    ) {}

    /**
     * @throws InvalidCredentialsException
     */
    public function execute(LoginRequestDTO $dto): AuthToken
    {
        return $this->authService->authenticateUser($dto);
    }
}
