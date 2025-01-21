<?php

namespace App\Http\Controllers;

use App\Application\Actions\Auth\LoginAction;
use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Domain\Services\AuthenticationService;
use App\Exceptions\InvalidCredentialsException;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly LoginAction $loginAction,
    ) {}

    /**
     * Create a new auth token
     */
    public function token(LoginRequest $request): JsonResponse
    {
        try {
            $dto = LoginRequestDTO::fromRequest($request->validated());
            $token = $this->loginAction->execute($dto);

            return response()->json($token->toArray());
        } catch (InvalidCredentialsException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
