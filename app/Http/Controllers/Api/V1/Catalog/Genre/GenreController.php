<?php

namespace App\Http\Controllers\Api\V1\Catalog\Genre;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Catalog\Genre\IndexMovieGenreRequest;
use App\Http\Resources\V1\Catalog\Genre\IndexMovieGenreResource;
use App\Repositories\Catalog\Genre\MovieGenreRepository;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    public function __construct(private MovieGenreRepository $genreRepository){}

    public function index(IndexMovieGenreRequest $request): JsonResponse
    {
        $genres = $this->genreRepository->paginate(filters: $request->validated());

        return response()->json(
            [
                'data' => IndexMovieGenreResource::collection($genres),
                'code' => JsonResponse::HTTP_OK
            ]
        );
    }
}
