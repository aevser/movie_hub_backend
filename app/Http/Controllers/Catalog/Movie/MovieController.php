<?php

namespace App\Http\Controllers\Catalog\Movie;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Genre\Genre;
use App\Models\Catalog\Movie\Movie;
use App\Repositories\Catalog\Crew\MovieCrewRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Repositories\User\Movie\Review\MovieReviewRepository;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function __construct(
        private MovieRepository $movieRepository,
        private MovieCrewRepository $movieCrewRepository,
        private MovieReviewRepository $movieReviewRepository
    ){}

    public function index(Genre $genre): View
    {
        $movies = $this->movieRepository->getAllByGenre(genre: $genre);

        return view('catalog.movie.index', compact('movies', 'genre'));
    }

    public function show(Genre $genre, Movie $movie): View
    {
        $movie = $this->movieRepository->getOneByGenre(genre: $genre, id: $movie->id);

        $director = $this->movieCrewRepository->getDirectorByMovieId(movieId: $movie->id);

        $reviews = $this->movieReviewRepository->getAllReviews(movieId: $movie->id);

        $userReviewExists = $this->movieReviewRepository->existsReview(userId: auth()->id(), movieId: $movie->id);

        return view('catalog.movie.show', compact('movie', 'genre', 'director', 'reviews', 'userReviewExists'));
    }
}
