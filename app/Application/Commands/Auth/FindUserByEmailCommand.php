<?php

namespace App\Application\Commands\Auth;

use App\Exceptions\UserNotFoundException;
use App\Models\User;

class FindUserByEmailCommand
{
    public function execute(string $email): User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new UserNotFoundException('No user found with the provided email address');
        }

        return $user;
    }
}
