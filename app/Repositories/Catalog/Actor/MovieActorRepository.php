<?php

namespace App\Repositories\Catalog\Actor;

use App\Models\Catalog\Actor\Actor;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieActorRepository
{
    private const string RELATION = 'movies';

    public function __construct(private Actor $actor){}

    public function getAllPagination(): LengthAwarePaginator
    {
        return $this->actor->query()
            ->with(self::RELATION)
            ->orderBy('id', 'desc')
            ->paginate(25);
    }

    public function findIdByMovieDbId(int $movieDbId): int
    {
        return $this->actor->query()
            ->where('movie_db_id', $movieDbId)
            ->value('id');
    }

    public function updateOrCreate(int $movieDbId, array $data): Actor
    {
        return $this->actor->query()->updateOrCreate
        (
            ['movie_db_id' => $movieDbId],
            $data
        );
    }

    public function upsert(array $data): void
    {
        $this->actor->query()->upsert(
            $data,
            ['movie_db_id'],
            ['name', 'image_url', 'updated_at']
        );
    }
}
