<?php

namespace App\Application\Commands\Auth;

class RevokeUserTokensCommand
{
    public function execute(array $data): void
    {
        $data['user']->tokens()->delete();
    }
}
