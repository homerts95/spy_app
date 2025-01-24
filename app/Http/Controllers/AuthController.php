<?php

namespace App\Http\Controllers;

use App\Application\Actions\Auth\LoginAction;
use App\Application\Actions\Auth\LogoutAction;
use App\Application\DTOs\Auth\LoginRequestDTO;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\TokenNotFoundException;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly LoginAction $loginAction,
        private readonly LogoutAction $logoutAction,
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
