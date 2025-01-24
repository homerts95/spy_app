<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth;

use App\Application\Commands\Auth\CreateAuthTokenCommand;
use App\Application\Commands\Auth\FindUserByEmailCommand;
use App\Application\Commands\Auth\RevokeUserTokensCommand;
use App\Application\Commands\Auth\VerifyUserPasswordCommand;
use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Domain\ValueObjects\Auth\AuthToken;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\TokenNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

readonly class AuthenticationService
{
    public function __construct(
        private FindUserByEmailCommand    $findUserCommand,
        private VerifyUserPasswordCommand $verifyPasswordCommand,
        private RevokeUserTokensCommand   $revokeTokensCommand,
        private CreateAuthTokenCommand    $createTokenCommand
    )
    {
    }

    /**
     * @throws InvalidCredentialsException|UserNotFoundException
     */
    public function authenticateUser(LoginRequestDTO $dto): AuthToken
    {

        $user = $this->findUserCommand->execute($dto->email);

        $this->verifyPasswordCommand->execute([
            'user' => $user,
            'password' => $dto->password
        ]);

        $this->revokeTokensCommand->execute([
            'user' => $user,
            'email' => $dto->email
        ]);

        return $this->createTokenCommand->execute([
            'user' => $user,
            'email' => $dto->email
        ]);
    }
}
