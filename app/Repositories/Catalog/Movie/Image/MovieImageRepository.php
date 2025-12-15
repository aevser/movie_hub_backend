<?php

namespace App\Repositories\Catalog\Movie\Image;

use App\Models\Catalog\Movie\Image\MovieImage;

class MovieImageRepository
{
    public function __construct(private MovieImage $movieImage){}

    public function firstOrCreate(array $data): MovieImage
    {
        return $this->movieImage->query()->firstOrCreate($data);
    }
}
