<?php

namespace App\Http\Controllers\User\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Review\CreateMovieReviewRequest;
use App\Models\Catalog\Genre\Genre;
use App\Models\Catalog\Movie\Movie;
use App\Repositories\User\Movie\Review\MovieReviewRepository;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function __construct(private MovieReviewRepository $movieReviewRepository){}

    public function store(CreateMovieReviewRequest $request, Genre $genre, Movie $movie): RedirectResponse
    {
        $this->movieReviewRepository->create(userId: auth()->id(), movieId: $movie->id, data: $request->validated());

        return redirect()->route('genres.movies.show', compact('genre', 'movie'));
    }

    public function destroy(Genre $genre, Movie $movie, int $id): RedirectResponse
    {
        $this->movieReviewRepository->delete(userId: auth()->id(), movieId: $movie->id, id: $id);

        return redirect()->route('genres.movies.show', [$genre, $movie]);
    }
}
