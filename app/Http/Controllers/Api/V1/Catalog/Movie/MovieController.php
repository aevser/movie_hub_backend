<?php

namespace App\Http\Controllers\Api\V1\Catalog\Movie;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Catalog\Movie\IndexMovieRequest;
use App\Http\Resources\V1\Catalog\Movie\IndexMovieResource;
use App\Http\Resources\V1\Catalog\Movie\ShowMovieResource;
use App\Models\Catalog\Movie\Movie;
use App\Repositories\Catalog\Movie\MovieRepository;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    public function __construct(private MovieRepository $movieRepository){}

    public function index(IndexMovieRequest $request): JsonResponse
    {
        $movies = $this->movieRepository->paginate
        (
            filters: $request->validated(),
            sort: null,
            search: null
        );

        return response()->json(
            [
                'data' => IndexMovieResource::collection($movies),
                'code' => JsonResponse::HTTP_OK
            ]
        );
    }

    public function show(Movie $movie): JsonResponse
    {
        $movie = $this->movieRepository->find
        (
            id: $movie->id
        );

        return response()->json(
            [
                'data' => ShowMovieResource::make($movie),
                'code' => JsonResponse::HTTP_OK
            ]
        );
    }
}
