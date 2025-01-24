<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Actions\Auth;

use App\Application\Actions\Auth\GenerateTokenAction;
use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Domain\Services\Auth\AuthenticationService;
use App\Domain\ValueObjects\Auth\AuthToken;
use App\Exceptions\InvalidCredentialsException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class LoginActionTest extends TestCase
{
    private AuthenticationService $authService;
    private GenerateTokenAction $loginAction;
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = $this->createMock(AuthenticationService::class);
        $this->loginAction = new GenerateTokenAction($this->authService);
    }

    /**
     * @throws InvalidCredentialsException
     */
    #[Test]
    public function it_should_return_auth_token_when_credentials_are_valid(): void
    {
        //no actual auth / validation of credentials
        $dto = new LoginRequestDTO(
            email: 'test@example.com',
            password: 'password',
        );

        $expectedToken = new AuthToken('test-token');

        $this->authService
            ->expects($this->once())
            ->method('authenticateUser')
            ->with($dto)
            ->willReturn($expectedToken);

        $result = $this->loginAction->execute($dto);

        $this->assertSame($expectedToken, $result);
    }

    #[Test]
    public function it_should_throw_exception_when_credentials_are_invalid(): void
    {
        // Arrange
        $dto = new LoginRequestDTO(
            email: 'test@example.com',
            password: 'wrong-password',
        );

        $this->authService
            ->expects($this->once())
            ->method('authenticateUser')
            ->with($dto)
            ->willThrowException(new InvalidCredentialsException('Invalid credentials'));

        $this->expectException(InvalidCredentialsException::class);
        $this->loginAction->execute($dto);
    }
}
