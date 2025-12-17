<?php

namespace App\Http\Controllers\Catalog\Genre;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Catalog\Genre\IndexGenreRequest;
use App\Repositories\Catalog\Actor\MovieActorRepository;
use App\Repositories\Catalog\Crew\MovieCrewRepository;
use App\Repositories\Catalog\Genre\GenreRepository;
use Illuminate\View\View;

class GenreController extends Controller
{
    public function __construct(
        private GenreRepository $genreRepository,
        private MovieActorRepository $movieActorRepository,
        private MovieCrewRepository $movieCrewRepository,
    ){}

    public function index(IndexGenreRequest $request): View
    {
        $genres = $this->genreRepository->getAllPagination(filters: $request->validated());

        $directors = $this->movieCrewRepository->getAllPagination();

        $actors = $this->movieActorRepository->getAllPagination();

        return view('catalog.genre.index', compact('genres', 'directors', 'actors'));
    }
}
