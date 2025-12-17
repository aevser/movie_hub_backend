<?php

namespace App\Repositories\Catalog\Genre;

use App\Constants\Pagination;
use App\Models\Catalog\Genre\Genre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieGenreRepository
{
    private const array RELATIONS =
    [
        'movies:id,title,description,poster_url,release_date'
    ];

    public function __construct(private Genre $genre){}

    public function paginate(array $filters): LengthAwarePaginator
    {
        return $this->genre->query()
            ->with(self::RELATIONS)
            ->orderBy(Pagination::COLUMN_ID, Pagination::SORT_DESC)
            ->paginate($filters['perPage'] ?? Pagination::PER_PAGE);
    }

    public function collection(): Collection
    {
        return $this->genre->query()
            ->with(self::RELATIONS)
            ->get();
    }

    public function chunkById(int $size, callable $callback): void
    {
        $this->genre->query()
            ->select(
                [
                    'id', 'movie_db_id'
                ]
            )
            ->chunkById($size, $callback);
    }

    public function updateOrCreate(int $movieDbId, array $data): Genre
    {
        return $this->genre->query()->updateOrCreate
        (
            [
                'movie_db_id' => $movieDbId
            ],
            $data
        );
    }

    public function attachMovies(Genre $genre, array $ids): void
    {
        $genre->movies()->syncWithoutDetaching($ids);
    }
}
