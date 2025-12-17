<?php

namespace App\Http\Controllers\Api\V1\Catalog\Actor;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Catalog\Actor\IndexMovieActorRequest;
use App\Http\Resources\V1\Catalog\Actor\IndexMovieActorResource;
use App\Repositories\Catalog\Actor\MovieActorRepository;
use Illuminate\Http\JsonResponse;

class ActorController extends Controller
{
    public function __construct(private MovieActorRepository $movieActorRepository){}

    public function index(IndexMovieActorRequest $request): JsonResponse
    {
        $actors = $this->movieActorRepository->paginate
        (
            filters: $request->validated()
        );

        return response()->json(
            [
                'data' => IndexMovieActorResource::collection($actors),
                'code' => JsonResponse::HTTP_OK,
                'pagination' =>
                    [
                        'total' => $actors->total(),
                        'per_page' => $actors->perPage(),
                        'current_page' => $actors->currentPage(),
                        'last_page' => $actors->lastPage()
                    ]
            ]
        );
    }
}
