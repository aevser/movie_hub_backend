<?php

namespace App\Services\Catalog\Crew;

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

    public function import(): int
    {
        $movies = $this->movieRepository->getAllCollection();
        $saved = 0;

        foreach ($movies as $movie) {
            $credits = $this->movieClientService->credits(movieId: $movie->movie_db_id);
            $crews = $credits['crew'];

            if (empty($crews)) {
                continue;
            }

            foreach ($crews as $crew) {
                $crewId = $this->saveCrew(crew: $crew);
                $this->attachCrew(movieId: $movie->id, crewId: $crewId, job: $crew['job'], department: $crew['department']);
                $saved++;
            }
        }

        return $saved;
    }

    private function saveCrew(array $crew): int
    {
        $this->movieCrewRepository->upsert([
            'movie_db_id' => $crew['id'],
            'name' => $crew['name'],
            'image_url' => $crew['profile_path']
                ? 'https://image.tmdb.org/t/p/w500' . $crew['profile_path']
                : null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $this->movieCrewRepository
            ->findIdByMovieDbId(movieDbId: $crew['id']);
    }

    private function attachCrew(int $movieId, int $crewId, string $job, string $department): void
    {
        $this->movieRepository->attachCrews(movieId: $movieId, crewIds: [
            $crewId => [
                'job' => $job,
                'department' => $department
            ]
        ]);
    }
}
