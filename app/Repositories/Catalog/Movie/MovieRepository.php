<?php

namespace App\Repositories\Catalog\Movie;

use App\Models\Catalog\Genre\Genre;
use App\Models\Catalog\Movie\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieRepository
{
    private const array RELATIONS = [
        'actors',
        'genres',
        'crews',
        'images',
        'backdrops',
        'reviews'
    ];

    private const string RELATION = 'genres';

    public function __construct(private Movie $movie){}

    public function getAllPagination(array $filters): LengthAwarePaginator
    {
        return $this->movie->query()
            ->with(self::RELATION)
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 25);
    }

    public function chunkById(int $size, callable $callback): void
    {
        $this->movie->query()
            ->select(['id', 'movie_db_id'])
            ->chunkById($size, $callback);
    }

    public function getAllCollection(): Collection
    {
        return $this->movie->query()->get();
    }

    public function getAllByGenre(Genre $genre): LengthAwarePaginator
    {
        return $genre->movies()
            ->with(self::RELATION)
            ->orderBy('id', 'desc')
            ->paginate($genre['perPage'] ?? 5);
    }

    public function getOneByGenre(Genre $genre, int $id): Movie
    {
        return $genre->movies()
            ->with(self::RELATIONS)
            ->findOrFail($id);
    }

    public function findById(int $id): Movie
    {
        return $this->movie->query()->with(self::RELATIONS)->findOrFail($id);
    }

    public function updateOrCreate(int $movieDbId, array $data): Movie
    {
        return $this->movie->query()->updateOrCreate
        (
            ['movie_db_id' => $movieDbId],
            $data
        );
    }

    public function attachActorsBatch(Movie $movie, array $attach): void
    {
        $movie->actors()->syncWithoutDetaching($attach);
    }

    public function attachCrewsBatch(Movie $movie, array $attach): void
    {
        $movie->crews()->syncWithoutDetaching($attach);
    }
}

