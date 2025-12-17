<?php

namespace App\Repositories\Catalog\Movie;

use App\Constants\Pagination;
use App\Models\Catalog\Genre\Genre;
use App\Models\Catalog\Movie\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieRepository
{
    private const array FULL_RELATIONS = [
        'actors',
        'genres',
        'crews',
        'images',
        'backdrops',
        'reviews'
    ];

    private const array LIST_RELATIONS = ['genres'];

    public function __construct(private Movie $movie){}

    public function paginate(array $filters): LengthAwarePaginator
    {
        return $this->movie->query()
            ->applyFilters($filters)
            ->with(self::LIST_RELATIONS)
            ->orderBy(Pagination::COLUMN_ID, Pagination::SORT_DESC)
            ->paginate($filters['perPage'] ?? Pagination::PER_PAGE);
    }

    public function collection(): Collection
    {
        return $this->movie->query()
            ->with(self::LIST_RELATIONS)
            ->get();
    }

    public function paginateByGenre(Genre $genre, array $filters): LengthAwarePaginator
    {
        return $genre->movies()
            ->with(self::LIST_RELATIONS)
            ->orderBy(Pagination::COLUMN_ID, Pagination::SORT_DESC)
            ->paginate($filters['perPage'] ?? Pagination::PER_PAGE);
    }

    public function chunkById(int $size, callable $callback): void
    {
        $this->movie->query()
            ->select(
                [
                    'id', 'movie_db_id'
                ]
            )
            ->chunkById($size, $callback);
    }

    public function find(int $id): Movie
    {
        return $this->movie->query()
            ->with(self::FULL_RELATIONS)
            ->findOrFail($id);
    }

    public function findByGenre(Genre $genre, int $movieId): Movie
    {
        return $genre->movies()
            ->with(self::FULL_RELATIONS)
            ->findOrFail($movieId);
    }

    public function updateOrCreate(int $movieDbId, array $data): Movie
    {
        return $this->movie->query()->updateOrCreate
        (
            [
                'movie_db_id' => $movieDbId
            ],
            $data
        );
    }

    public function attachActors(Movie $movie, array $ids): void
    {
        $movie->actors()
            ->syncWithoutDetaching($ids);
    }

    public function attachCrews(Movie $movie, array $ids): void
    {
        $movie->crews()
            ->syncWithoutDetaching($ids);
    }
}
