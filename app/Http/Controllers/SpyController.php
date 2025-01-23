<?php

namespace App\Http\Controllers;

use App\Application\Actions\CreateSpyAction;
use App\Application\Actions\GetRandomSpiesAction;
use App\Application\DTOs\Spy\SpyDTO;
use App\Http\Requests\CreateSpyRequest;
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
        $dto = SpyDTO::fromRequest($request->validated());
        $eloquentSpy = $this->createSpyAction->execute($dto);

        return response()->json([
            'data' => $eloquentSpy->toDomain(),
            'message' => 'Spy created successfully'
        ], Response::HTTP_CREATED);
    }

    public function random(): JsonResponse
    {
        $spies = $this->getRandomSpiesAction->execute();

        return response()->json([
            'data' => $spies,
            'message' => 'Spies retrieved successfully'
        ], Response::HTTP_OK);
    }

}
