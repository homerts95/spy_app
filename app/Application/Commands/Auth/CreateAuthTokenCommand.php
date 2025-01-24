<?php

namespace App\Application\Commands\Auth;

use App\Domain\ValueObjects\Auth\AuthToken;

class CreateAuthTokenCommand
{
    public function execute(array $data): AuthToken
    {
        $token = $data['user']->createToken(
            name: 'auth_token',
        );

        return new AuthToken(
            token: $token->plainTextToken
        );
    }
}
