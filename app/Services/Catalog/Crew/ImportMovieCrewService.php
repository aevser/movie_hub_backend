<?php

namespace App\Services\Catalog\Crew;

use App\Models\Catalog\Movie\Movie;
use App\Repositories\Catalog\Crew\MovieCrewRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\MovieClientService;

class ImportMovieCrewService
{
    public function __construct(
        private MovieClientService $movieClientService,
        private MovieRepository $movieRepository,
        private MovieCrewRepository $movieCrewRepository
    ){}

    public function import(Movie $movie): int
    {
        $credits = $this->movieClientService->credits(movieId: $movie->movie_db_id);

        $crews = $credits['crew'];

        $attach = [];

        if (empty($crews))
        {
            return 0;
        }

        foreach ($crews as $crew)
        {
            $crew = $this->movieCrewRepository->updateOrCreate
            (
                movieDbId: $movie['id'],
                data:
                [
                    'name' => $crew['name'],
                    'image_url' =>
                        $crew['profile_path']
                            ? 'https://image.tmdb.org/t/p/w500' . $crew['profile_path']
                            : null
                ]
            );

            $attach[$crew->id] =
                [
                    'job' => $crew['job'],
                    'department' => $crew['department']
                ];
        }

        $this->movieRepository->attachCrews(movie: $movie, attach: $attach);

        return count($attach);
    }
}
