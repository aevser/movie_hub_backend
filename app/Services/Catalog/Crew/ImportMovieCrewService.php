<?php

namespace App\Services\Catalog\Crew;

use App\Models\Catalog\Movie\Movie;
use App\Repositories\Catalog\Crew\MovieCrewRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\MovieClientService;

class ImportMovieCrewService
{
    private const string JOB = 'Director';

    public function __construct(
        private MovieClientService $movieClientService,
        private MovieRepository $movieRepository,
        private MovieCrewRepository $movieCrewRepository
    ){}

    public function import(Movie $movie): int
    {
        $credits = $this->movieClientService->credits(movieId: $movie->movie_db_id);

        $crews = $credits['crew'];

        $ids = [];

        if (empty($crews))
        {
            return 0;
        }

        foreach ($crews as $crew)
        {
            if ($crew['job'] === self::JOB)
            {
                $director = $this->movieCrewRepository->updateOrCreate
                (
                    movieDbId: $crew['id'],
                    data:
                    [
                        'name' => $crew['name'],
                        'image_url' =>
                            $crew['profile_path']
                                ? 'https://image.tmdb.org/t/p/w500' . $crew['profile_path']
                                : null
                    ]
                );

                $ids[$director->id] =
                    [
                        'job' => $crew['job'],
                        'department' => $crew['department']
                    ];
            }
        }

        $this->movieRepository->attachCrews(movie: $movie, ids: $ids);

        return count($ids);
    }
}
