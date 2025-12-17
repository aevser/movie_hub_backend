<?php

namespace App\Services\Catalog\Movie\Image;

use App\Models\Catalog\Movie\Movie;
use App\Repositories\Catalog\Movie\Image\MovieImageRepository;
use App\Services\Catalog\MovieClientService;

class ImportMovieImageService
{
    public function __construct(
        private MovieClientService $movieClientService,
        private MovieImageRepository $movieImageRepository
    ){}

    public function import(Movie $movie): int
    {
        $images = $this->movieClientService->images(movieId: $movie->movie_db_id);

        $posters = $images['posters'];

        $saved = 0;

        if (empty($posters))
        {
            return 0;
        }

        foreach ($posters as $poster)
        {
            $this->movieImageRepository->updateOrCreate
            (
                movieId: $movie->id,
                data:
                [
                    'image_url' =>
                        $poster['file_path']
                            ? 'https://image.tmdb.org/t/p/w500' . $poster['file_path']
                            : null,
                    'image_width' => $poster['width'],
                    'image_height' => $poster['height']
                ]
            );

            $saved++;
        }

        return $saved;
    }
}
