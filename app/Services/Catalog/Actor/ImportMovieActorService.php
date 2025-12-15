<?php

namespace App\Services\Catalog\Actor;

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

    public function import(): int
    {
        $movies = $this->movieRepository->getAllCollection();
        $saved = 0;

        foreach ($movies as $movie) {
            $credits = $this->movieClientService->credits(movieId: $movie->movie_db_id);
            $casts = $credits['cast'];

            if (empty($casts)) {
                continue;
            }

            foreach ($casts as $actor) {
                $actorId = $this->saveActor(actor: $actor);
                $this->attachActor(movieId: $movie->id, actorId: $actorId, character: $actor['character']);
                $saved++;
            }
        }

        return $saved;
    }

    private function saveActor(array $actor): int
    {
        $this->movieActorRepository->upsert([
            'movie_db_id' => $actor['id'],
            'name' => $actor['name'],
            'image_url' => $actor['profile_path']
                ? 'https://image.tmdb.org/t/p/w500' . $actor['profile_path']
                : null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $this->movieActorRepository
            ->findIdByMovieDbId(movieDbId: $actor['id']);
    }

    private function attachActor(int $movieId, int $actorId, string $character): void
    {
        $this->movieRepository->attachActors(movieId: $movieId, actorsIds: [
            $actorId => [
                'character' => $character
            ]
        ]);
    }
}
