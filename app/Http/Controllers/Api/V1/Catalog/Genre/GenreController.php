<?php

namespace App\Http\Controllers\Api\V1\Catalog\Genre;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Catalog\Genre\IndexGenreRequest;
use App\Http\Resources\V1\Catalog\Genre\IndexGenreResource;
use App\Repositories\Catalog\Genre\GenreRepository;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    public function __construct(private GenreRepository $genreRepository){}

    public function index(IndexGenreRequest $request): JsonResponse
    {
        $genres = $this->genreRepository->getAllPagination(filters: $request->validated());

        return response()->json(['data' => IndexGenreResource::collection($genres), 'code' => JsonResponse::HTTP_OK]);
    }
}
