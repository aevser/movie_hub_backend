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

        if (empty($genres))
        {
            return 0;
        }

        foreach ($genres as $genre)
        {

            $this->genreRepository->updateOrCreate
            (
                movieDbId: $genre['id'],
                data:
                [
                    'name' => mb_ucfirst($genre['name']),
                    'slug' => Str::slug($genre['name'], '-', 'ru')
                ]
            );

            $saved++;
        }

        return $saved;
    }
}
