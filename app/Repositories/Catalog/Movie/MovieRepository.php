<?php

namespace App\Repositories\Catalog\Movie;

use App\Models\Catalog\Movie\Movie;
use Illuminate\Database\Eloquent\Collection;

class MovieRepository
{
    public function __construct(private Movie $movie){}

    public function getAllCollection(): Collection
    {
        return $this->movie->query()->get();
    }

    public function findIdsByMovieDbIds(array $movieDbIds): array
    {
        return $this->movie->query()
            ->whereIn('movie_db_id', $movieDbIds)
            ->pluck('id', 'movie_db_id')
            ->toArray();
    }

    public function upsert(array $data): void
    {
        $this->movie->query()->upsert(
            $data,
            ['movie_db_id'],
            ['title', 'description', 'poster_url', 'release_date', 'updated_at']
        );
    }

    public function attachGenres(int $movieId, array $genresIds): void
    {
        $this->movie->query()
            ->findOrFail($movieId)
            ->genres()
            ->syncWithoutDetaching($genresIds);
    }

    public function attachActors(int $movieId, array $actorsIds): void
    {
        $this->movie->query()
            ->findOrFail($movieId)
            ->actors()
            ->syncWithoutDetaching($actorsIds);
    }

    public function attachCrews(int $movieId, array $crewIds): void
    {
        $this->movie->query()
            ->findOrFail($movieId)
            ->crews()
            ->syncWithoutDetaching($crewIds);
    }
}

