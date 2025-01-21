<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Domain\ValueObjects\Auth\AuthToken;
use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    /**
     * @throws InvalidCredentialsException
     */
    public function authenticateUser(LoginRequestDTO $dto): AuthToken
    {
        $user = User::where('email', $dto->email)->first();

        if (! $user || ! Hash::check($dto->password, $user->password)) {
            throw new InvalidCredentialsException('wrong credentials.');
        }

        $user->tokens()->where('name', $dto->email)->delete();

        $token = $user->createToken($dto->email);

        return new AuthToken(
            token: $token->plainTextToken
        );
    }

    public function revokeCurrentToken(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
