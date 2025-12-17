<?php

namespace App\Services\Catalog\Actor;

use App\Models\Catalog\Movie\Movie;
use App\Repositories\Catalog\Actor\MovieActorRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\MovieClientService;

class ImportMovieActorService
{
    public function __construct(
        private MovieClientService $movieClientService,
        private MovieRepository $movieRepository,
        private MovieActorRepository $movieActorRepository
    ){}

    public function import(Movie $movie): int
    {
        $credits = $this->movieClientService->credits(movieId: $movie->movie_db_id);

        $casts = $credits['cast'];

        $attach = [];

        if (empty($casts))
        {
            return 0;
        }

        foreach ($casts as $cast)
        {
            $actor = $this->movieActorRepository->updateOrCreate
            (
                movieDbId: $cast['id'],
                data:
                [
                    'name' => $cast['name'],
                    'image_url' =>
                        $cast['profile_path']
                        ? 'https://image.tmdb.org/t/p/w500' . $cast['profile_path']
                        : null
                ]
            );

            $attach[$actor->id] =
                [
                    'character' => $cast['character']
                ];
        }

        $this->movieRepository->attachActors(movie: $movie, attach: $attach);

        return count($attach);
    }
}
