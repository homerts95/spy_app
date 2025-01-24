<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth;

use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Domain\ValueObjects\Auth\AuthToken;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\TokenNotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationService
{
    /**
     * @throws InvalidCredentialsException
     */
    public function authenticateUser(LoginRequestDTO $dto): AuthToken
    {
        $user = $this->findUserByEmail($dto->email);
        $this->verifyUserPassword($user, $dto->password);

        $this->revokeExistingTokens($user, $dto->email);

        return $this->createNewToken($user, $dto->email);
    }

    /**
     * @throws InvalidCredentialsException
     */
    private function findUserByEmail(string $email): User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new InvalidCredentialsException('Invalid credentials provided.');
        }

        return $user;
    }


    /**
     * @throws InvalidCredentialsException
     */
    private function verifyUserPassword(User $user, string $password): void
    {
        if (!Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException('Invalid credentials provided.');
        }
    }

    private function revokeExistingTokens(User $user, string $tokenName): void
    {
        $userTokens = $user->tokens()->where('name', $tokenName);
        if ($userTokens->exists()) {
            $userTokens->delete();
        }
    }

    private function createNewToken(User $user, string $tokenName): AuthToken
    {
        $token = $user->createToken($tokenName);

        return new AuthToken(
            token: $token->plainTextToken
        );
    }

    /**
     * @throws TokenNotFoundException
     */
    public function revokeCurrentToken(): void
    {
        $currentToken = $this->getCurrentAccessToken();

        if (!$currentToken->exists()) {
            throw new TokenNotFoundException('No active token found for the current user.');
        }

        $currentToken->delete();
    }

    /**
     * @throws TokenNotFoundException
     */
    private function getCurrentAccessToken(): PersonalAccessToken
    {
        $user = auth()->user();

        if (!$user) {
            throw new TokenNotFoundException('No authenticated user found.');
        }

        return $user->currentAccessToken();
    }
}
