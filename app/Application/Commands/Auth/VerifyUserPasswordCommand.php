<?php

namespace App\Application\Commands\Auth;

use App\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Hash;

class VerifyUserPasswordCommand
{
    /**
     * @throws InvalidCredentialsException
     */
    public function execute(array $data): void
    {
        if (!Hash::check($data['password'], $data['user']->password)) {
            throw new InvalidCredentialsException('The provided password is incorrect');
        }
    }
}
