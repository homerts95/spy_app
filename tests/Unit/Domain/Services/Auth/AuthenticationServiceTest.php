<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Services\Auth;

use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Domain\Services\Auth\AuthenticationService;
use App\Domain\ValueObjects\Auth\AuthToken;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\TokenNotFoundException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $this->authService = new AuthenticationService();
        $this->user = User::factory()->create([
            'email' => self::TEST_EMAIL,
            'password' => bcrypt(self::TEST_PASSWORD)
        ]);
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
        $dto = new LoginRequestDTO(
            email: self::TEST_EMAIL,
            password: 'wrongpassword'
        );

        $this->expectException(InvalidCredentialsException::class);

        $this->authService->authenticateUser($dto);
    }

    public function test_revokes_current_token(): void
    {
        $this->actingAs($this->user);

        $token = $this->user->createToken(self::TEST_EMAIL);
        $this->user->withAccessToken($token->accessToken);

        $this->authService->revokeCurrentToken();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id
        ]);
    }
}
