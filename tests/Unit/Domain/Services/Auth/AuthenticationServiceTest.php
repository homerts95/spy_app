<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Services\Auth;

use App\Application\Commands\Auth\CreateAuthTokenCommand;
use App\Application\Commands\Auth\FindUserByEmailCommand;
use App\Application\Commands\Auth\RevokeUserTokensCommand;
use App\Application\Commands\Auth\VerifyUserPasswordCommand;
use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Domain\Services\Auth\AuthenticationService;
use App\Domain\ValueObjects\Auth\AuthToken;
use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AuthenticationServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthenticationService $authService;
    private User $user;
    private const TEST_EMAIL = 'prosperty.tests@spies.test';
    private const TEST_PASSWORD = 'secret';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => self::TEST_EMAIL,
            'password' => bcrypt(self::TEST_PASSWORD)
        ]);

        $findUserCommand = Mockery::mock(FindUserByEmailCommand::class);
        $verifyPasswordCommand = Mockery::mock(VerifyUserPasswordCommand::class);
        $revokeTokensCommand = Mockery::mock(RevokeUserTokensCommand::class);
        $createTokenCommand = Mockery::mock(CreateAuthTokenCommand::class);

        $findUserCommand->shouldReceive('execute')
            ->with(self::TEST_EMAIL)
            ->andReturn($this->user);

        $verifyPasswordCommand->shouldReceive('execute')
            ->with(['user' => $this->user, 'password' => self::TEST_PASSWORD]);

        $revokeTokensCommand->shouldReceive('execute')
            ->with(['user' => $this->user, 'email' => self::TEST_EMAIL]);

        $createTokenCommand->shouldReceive('execute')
            ->with(['user' => $this->user, 'email' => self::TEST_EMAIL])
            ->andReturn(new AuthToken('test-token'));

        // Create our service with the mocked commands
        $this->authService = new AuthenticationService(
            $findUserCommand,
            $verifyPasswordCommand,
            $revokeTokensCommand,
            $createTokenCommand
        );
    }

    public function test_authenticates_user_with_valid_credentials(): void
    {
        $dto = new LoginRequestDTO(
            email: self::TEST_EMAIL,
            password: self::TEST_PASSWORD
        );

        $result = $this->authService->authenticateUser($dto);

        $this->assertInstanceOf(AuthToken::class, $result);
    }

    public function test_throws_exception_for_invalid_credentials(): void
    {
        $findUserCommand = Mockery::mock(FindUserByEmailCommand::class);
        $findUserCommand->shouldReceive('execute')
            ->with(self::TEST_EMAIL)
            ->andReturn($this->user);

        $verifyPasswordCommand = Mockery::mock(VerifyUserPasswordCommand::class);
        $verifyPasswordCommand->shouldReceive('execute')
            ->andThrow(new InvalidCredentialsException());

        $this->authService = new AuthenticationService(
            $findUserCommand,
            $verifyPasswordCommand,
            Mockery::mock(RevokeUserTokensCommand::class),
            Mockery::mock(CreateAuthTokenCommand::class)
        );

        $dto = new LoginRequestDTO(
            email: self::TEST_EMAIL,
            password: 'wrongpassword'
        );

        $this->expectException(InvalidCredentialsException::class);

        $this->authService->authenticateUser($dto);
    }
}
