<?php

namespace App\Services\Catalog\Movie\Backdrop;

use App\Repositories\Catalog\Movie\Backdrop\MovieBackdropImageRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\MovieClientService;

class ImportMovieBackdropImageService
{
    public function __construct(
        private MovieClientService $movieClientService,
        private MovieRepository $movieRepository,
        private MovieBackdropImageRepository $movieBackdropImageRepository
    ){}

    public function import(): int
    {
        $movies = $this->movieRepository->getAllCollection();
        $saved = 0;

        foreach ($movies as $movie) {
            $images = $this->movieClientService->images(movieId: $movie->movie_db_id);
            $backdrops = $images['backdrops'];

            if (empty($backdrops)) {
                continue;
            }

            foreach ($backdrops as $backdrop) {
                $this->saveImage(movieId: $movie->id, backdrop: $backdrop);
                $saved++;
            }
        }

        return $saved;
    }

    private function saveImage(int $movieId, array $backdrop): void
    {
        $this->movieBackdropImageRepository->firstOrCreate([
            'movie_id' => $movieId,
            'image_url' => $backdrop['file_path']
                ? 'https://image.tmdb.org/t/p/w500' . $backdrop['file_path']
                : null,
            'image_width' => $backdrop['width'],
            'image_height' => $backdrop['height'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
