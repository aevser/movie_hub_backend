<?php

namespace App\Http\Controllers\Api\V1\Catalog\Actor;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Catalog\Actor\IndexActorRequest;
use App\Http\Resources\V1\Catalog\Actor\IndexActorResource;
use App\Repositories\Catalog\Actor\MovieActorRepository;
use Illuminate\Http\JsonResponse;

class ActorController extends Controller
{
    public function __construct(private MovieActorRepository $movieActorRepository){}

    public function index(IndexActorRequest $request): JsonResponse
    {
        $actors = $this->movieActorRepository->getAllPagination(filters: $request->validated());

        return response()->json(['data' => IndexActorResource::collection($actors), 'code' => JsonResponse::HTTP_OK]);
    }
}
