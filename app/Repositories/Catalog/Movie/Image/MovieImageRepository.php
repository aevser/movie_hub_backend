<?php

namespace App\Repositories\Catalog\Movie\Image;

use App\Models\Catalog\Movie\Image\MovieImage;
use App\Models\Catalog\Movie\Movie;
use Illuminate\Database\Eloquent\Collection;

class MovieImageRepository
{
    public function __construct(private MovieImage $movieImage){}

    public function getAllByMovie(int $movieId): Collection
    {
        return $this->movieImage->query()
            ->where('movie_id', $movieId)
            ->get();
    }

    public function firstOrCreate(array $data): MovieImage
    {
        return $this->movieImage->query()->firstOrCreate($data);
    }

    public function updateOrCreate(int $movieId, array $data): MovieImage
    {
        return $this->movieImage->query()->updateOrCreate
        (
            ['movie_id' => $movieId],
            $data
        );
    }
}
