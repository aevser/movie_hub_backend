<?php

namespace App\Repositories\Catalog\Genre;

use App\Models\Catalog\Genre\Genre;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository
{
    public function __construct(private Genre $genre){}

    public function getAllCollection(): Collection
    {
        return $this->genre->query()->get();
    }

    public function findIdsByMovieDbIds(array $movieDbIds): array
    {
        return $this->genre->query()
            ->whereIn('movie_db_id', $movieDbIds)
            ->pluck('id')
            ->toArray();
    }

    public function upsert(array $data): void
    {
        $this->genre->query()->upsert(
            $data,
            ['movie_db_id'],
            ['name', 'updated_at']
        );
    }
}
