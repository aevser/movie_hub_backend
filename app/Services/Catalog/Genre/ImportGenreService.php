<?php

namespace App\Services\Catalog\Genre;

use App\Repositories\Catalog\Genre\GenreRepository;
use App\Services\Catalog\MovieClientService;
use Illuminate\Support\Str;

class ImportGenreService
{
    public function __construct(
        private MovieClientService $movieClientService,
        private GenreRepository $genreRepository
    ){}

    public function import(): int
    {
        $genres = $this->movieClientService->genres();
        $saved = 0;

        foreach ($genres as $genre) {
            $this->saveGenre(genre: $genre);
            $saved++;
        }

        return $saved;
    }

    private function saveGenre(array $genre): void
    {
        $this->genreRepository->upsert([
            'movie_db_id' => $genre['id'],
            'name' => mb_ucfirst($genre['name']),
            'slug' => Str::slug($genre['name'], '-', 'ru'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
