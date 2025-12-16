<?php

namespace App\Repositories\Catalog\Genre;

use App\Models\Catalog\Genre\Genre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GenreRepository
{
    private const string RELATIONS = 'movies:id,title,description,poster_url,release_date';

    public function __construct(private Genre $genre){}

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

    public function upsert(array $data): void
    {
        $this->genre->query()->upsert(
            $data,
            ['movie_db_id'],
            ['name', 'updated_at']
        );
    }
}
