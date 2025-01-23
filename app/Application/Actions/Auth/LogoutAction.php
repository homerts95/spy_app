<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Domain\Services\Auth\AuthenticationService;
use App\Exceptions\TokenNotFoundException;

readonly class LogoutAction
{
    public function __construct(
        private AuthenticationService $authService
    )
    {
    }

    /**
     * @throws TokenNotFoundException
     */
    public function execute(): void
    {
        $this->authService->revokeCurrentToken();
    }
}
