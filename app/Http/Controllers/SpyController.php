<?php

namespace App\Http\Controllers;

use App\Application\Actions\CreateSpyAction;
use App\Application\Actions\GetRandomSpiesAction;
use App\Application\DTOs\CreateSpyDTO;
use App\Http\Requests\CreateSpyRequest;
use App\Infrastructure\EloquentModel\SpyEloquentModel;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SpyController extends Controller
{
    public function __construct(
        private readonly CreateSpyAction      $createSpyAction,
        private readonly GetRandomSpiesAction $getRandomSpiesAction
    )
    {
    }

    public function store(CreateSpyRequest $request): JsonResponse
    {
        $dto = CreateSpyDTO::fromRequest($request->validated());
        $spy = $this->createSpyAction->execute($dto);

        return response()->json([
            'data' => $spy,
            'message' => 'Spy created successfully'
        ], Response::HTTP_CREATED);
    }

    public function random(): JsonResponse
    {
        $spies = $this->getRandomSpiesAction->execute(5);

        return response()->json([
            'data' => $spies,
            'message' => 'Spies retrieved successfully'
        ], Response::HTTP_OK);

    }

}
