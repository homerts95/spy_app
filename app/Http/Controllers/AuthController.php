<?php

namespace App\Http\Controllers;

use App\Application\Actions\Auth\GenerateTokenAction;
use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly GenerateTokenAction $generateTokenAction,
    )
    {
    }

    /**
     * Create a new auth token
     * @throws InvalidCredentialsException|UserNotFoundException
     */
    public function token(LoginRequest $request): JsonResponse
    {
        $dto = LoginRequestDTO::fromRequest($request->validated());
        $token = $this->generateTokenAction->execute(
            $dto
        );

        return response()->json($token->toArray());
    }

}
