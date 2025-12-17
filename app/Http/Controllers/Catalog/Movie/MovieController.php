<?php

namespace App\Http\Controllers\Catalog\Movie;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Genre\Genre;
use App\Models\Catalog\Movie\Movie;
use App\Repositories\Catalog\Crew\MovieCrewRepository;
use App\Repositories\Catalog\Movie\Image\MovieImageRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Repositories\User\Movie\Review\MovieReviewRepository;
use App\Repositories\User\UserRepository;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
        private MovieRepository $movieRepository,
        private MovieCrewRepository $movieCrewRepository,
        private MovieImageRepository $movieImageRepository,
        private MovieReviewRepository $movieReviewRepository
    ){}

    public function index(Genre $genre): View
    {
        return view('catalog.movie.index',
            [
                'genre' => $genre,
                'movies' => $this->movieRepository->paginateByGenre(
                    genre: $genre,
                    filters: []
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
                'movie' => $this->movieRepository->findByGenre(
                    genre: $genre,
                    movieId: $movie->id
                ),

                'director' => $this->movieCrewRepository->findDirectorByMovie($movie),
                'images' => $this->movieImageRepository->getByMovie($movie->id),
                'reviews' => $this->movieReviewRepository->getAllByMovie($movie->id),
                'isFavorite' => $this->userRepository->existsFavoriteMovie(
                    user: $user,
                    movie: $movie
                ),
                'userReviewExists' => $this->movieReviewRepository->existsByUserAndMovie(
                    user: $user,
                    movieId: $movie->id
                )
            ]
        );
    }
}
