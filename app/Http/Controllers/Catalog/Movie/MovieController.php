<?php

namespace App\Http\Controllers\Catalog\Movie;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Movie\FilterMovieRequest;
use App\Http\Requests\Catalog\Movie\SortMovieRequest;
use App\Models\Catalog\Genre\Genre;
use App\Models\Catalog\Movie\Movie;
use App\Repositories\Catalog\Crew\MovieCrewRepository;
use App\Repositories\Catalog\Genre\MovieGenreRepository;
use App\Repositories\Catalog\Movie\Image\MovieImageRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Repositories\User\Movie\Review\MovieReviewRepository;
use App\Repositories\User\UserRepository;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
        private MovieGenreRepository $movieGenreRepository,
        private MovieRepository $movieRepository,
        private MovieCrewRepository $movieCrewRepository,
        private MovieImageRepository $movieImageRepository,
        private MovieReviewRepository $movieReviewRepository
    ){}

    public function index(Genre $genre, SortMovieRequest $request): View
    {
        return view('catalog.movie.index',
            [
                'genre' => $genre,
                'movies' => $this->movieRepository->paginateByGenre
                (
                    genre: $genre,
                    filters: [],
                    sort: $request->validated('sort')
                )
            ]
        );
    }

    public function show(Genre $genre, Movie $movie): View
    {
        $user = auth()->user();

        return view('catalog.movie.show',
            [
                'genre' => $genre,
                'movie' => $this->movieRepository->findByGenre
                (
                    genre: $genre,
                    movieId: $movie->id
                ),
                'director' => $this->movieCrewRepository->findDirectorByMovie
                (
                    movieId: $movie->id
                ),
                'images' => $this->movieImageRepository->getByMovie
                (
                    movieId: $movie->id
                ),
                'reviews' => $this->movieReviewRepository->getAllByMovie
                (
                    movieId: $movie->id
                ),
                'isFavorite' => $this->userRepository->existsFavoriteMovie
                (
                    user: $user,
                    movie: $movie
                ),
                'userReviewExists' => $this->movieReviewRepository->existsByUserAndMovie
                (
                    user: $user,
                    movieId: $movie->id
                )
            ]
        );
    }

    public function filter(FilterMovieRequest $request): View
    {
        $filters = $request->validated();

        return view('catalog.movie.filter.index',
            [
                'genres' => $this->movieGenreRepository->collection(),
                'movies' => $this->movieRepository->paginate
                (
                    filters: $filters,
                    sort: null
                ),
                'actors' => $this->movieCrewRepository->collection(),
                'directors' => $this->movieCrewRepository->collection()
            ]
        );
    }
}
