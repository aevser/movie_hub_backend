<?php

namespace App\Services\Catalog\Movie\Image;

use App\Repositories\Catalog\Movie\Image\MovieImageRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\MovieClientService;

class ImportMovieImageService
{
    public function __construct(
        private MovieClientService $movieClientService,
        private MovieRepository $movieRepository,
        private MovieImageRepository $movieImageRepository
    ){}

    public function import(): int
    {
        $movies = $this->movieRepository->getAllCollection();
        $saved = 0;

        foreach ($movies as $movie) {
            $images = $this->movieClientService->images(movieId: $movie->movie_db_id);
            $posters = $images['posters'];

            if (empty($posters)) {
                continue;
            }

            foreach ($posters as $poster) {
                $this->saveImage(movieId: $movie->id, image: $poster);
                $saved++;
            }
        }

        return $saved;
    }

    private function saveImage(int $movieId, array $image): void
    {
        $this->movieImageRepository->firstOrCreate([
            'movie_id' => $movieId,
            'image_url' => $image['file_path']
                ? 'https://image.tmdb.org/t/p/w500' . $image['file_path']
                : null,
            'image_width' => $image['width'],
            'image_height' => $image['height'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
