<?php

namespace App\Services\Catalog\Movie\Backdrop;

use App\Models\Catalog\Movie\Movie;
use App\Repositories\Catalog\Movie\Backdrop\MovieBackdropImageRepository;
use App\Services\Catalog\MovieClientService;

class ImportMovieBackdropImageService
{
    public function __construct(
        private MovieClientService $movieClientService,
        private MovieBackdropImageRepository $movieBackdropImageRepository
    ){}

    public function import(Movie $movie): int
    {
       $images = $this->movieClientService->images
       (
           movieId: $movie->movie_db_id
       );

       $backdrops = $images['backdrops'];

       $saved = 0;

       if (empty($backdrops))
       {
           return 0;
       }

       foreach ($backdrops as $backdrop)
       {
           $this->movieBackdropImageRepository->updateOrCreate
           (
               movieId: $movie->id,
               data:
               [
                   'image_url' =>
                       $backdrop['file_path']
                           ? 'https://image.tmdb.org/t/p/w500' . $backdrop['file_path']
                           : null,
                   'image_width' => $backdrop['width'],
                   'image_height' => $backdrop['height']
               ]
           );

           $saved++;
       }

       return $saved;
    }
}
