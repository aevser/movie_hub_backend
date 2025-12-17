<?php

namespace App\Http\Controllers\Catalog\Genre;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Catalog\Genre\IndexMovieGenreRequest;
use App\Repositories\Catalog\Actor\MovieActorRepository;
use App\Repositories\Catalog\Crew\MovieCrewRepository;
use App\Repositories\Catalog\Genre\MovieGenreRepository;
use Illuminate\View\View;

class GenreController extends Controller
{
    public function __construct(
        private MovieGenreRepository $genreRepository,
        private MovieActorRepository $movieActorRepository,
        private MovieCrewRepository  $movieCrewRepository,
    ){}

    public function index(IndexMovieGenreRequest $request): View
    {
        $filters = $request->validated();

        return view('catalog.genre.index',
            [
                'genres' => $this->genreRepository->paginate(filters: $filters),
                'actors' => $this->movieActorRepository->paginate(filters: $filters),
                'directors' => $this->movieCrewRepository->paginate(filters: $filters)
            ]
        );
    }
}
