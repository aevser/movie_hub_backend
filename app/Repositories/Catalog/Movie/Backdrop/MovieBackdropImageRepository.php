<?php

namespace App\Repositories\Catalog\Movie\Backdrop;

use App\Models\Catalog\Movie\Backdrop\MovieBackdropImage;

class MovieBackdropImageRepository
{
    public function __construct(private MovieBackdropImage $movieBackdropImage){}

    public function firstOrCreate(array $data): MovieBackdropImage
    {
        return $this->movieBackdropImage->query()->firstOrCreate($data);
    }

    public function updateOrCreate(int $movieId, array $data): MovieBackdropImage
    {
        return $this->movieBackdropImage->query()->updateOrCreate
        (
            ['movie_id' => $movieId],
            $data
        );
    }
}
