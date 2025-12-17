<?php

namespace App\Repositories\Catalog\Movie\Image;

use App\Models\Catalog\Movie\Image\MovieImage;
use Illuminate\Database\Eloquent\Collection;

class MovieImageRepository
{
    public function __construct(private MovieImage $movieImage){}

    public function getByMovie(int $movieId): Collection
    {
        return $this->movieImage->query()
            ->where('movie_id', $movieId)
            ->get();
    }

    public function updateOrCreate(int $movieId, array $data): MovieImage
    {
        return $this->movieImage->query()->updateOrCreate
        (
            [
                'movie_id' => $movieId
            ],
            $data
        );
    }
}
