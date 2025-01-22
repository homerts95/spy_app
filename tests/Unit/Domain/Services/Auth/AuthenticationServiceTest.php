<?php


declare(strict_types=1);

namespace Tests\Unit\Domain\Services\Auth;

use App\Domain\Services\AuthenticationService;
use PHPUnit\Framework\TestCase;

class AuthenticationServiceTest extends TestCase
{
    private AuthenticationService $authService;

    /**
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->authService = new AuthenticationService();
    }

 //todo test valid / invalid email password combinations, revoke token and token not found
}
