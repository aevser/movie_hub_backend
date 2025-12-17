<?php

namespace App\Repositories\Catalog\Genre;

use App\Models\Catalog\Genre\Genre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GenreRepository
{
    private const string RELATIONS = 'movies:id,title,description,poster_url,release_date';

    public function __construct(private Genre $genre){}

    public function chunkById(int $size, callable $callback): void
    {
        $this->genre->query()
            ->select(['id', 'movie_db_id'])
            ->chunkById($size, $callback);
    }

    public function getAllPagination(array $filters): LengthAwarePaginator
    {
        return $this->genre->query()
            ->with(self::RELATIONS)
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 15);
    }

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

    public function updateOrCreate(int $movieDbId, array $data): Genre
    {
        return $this->genre->query()->updateOrCreate
        (
            ['movie_db_id' => $movieDbId],
            $data
        );
    }

    public function attachMoviesBatch(Genre $genre, array $attach): void
    {
        $genre->movies()->syncWithoutDetaching($attach);
    }
}
