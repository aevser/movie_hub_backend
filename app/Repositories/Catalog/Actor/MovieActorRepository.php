<?php

namespace App\Repositories\Catalog\Actor;

use App\Models\Catalog\Actor\Actor;

class MovieActorRepository
{
    public function __construct(private Actor $actor){}

    public function findIdByMovieDbId(int $movieDbId): int
    {
        return $this->actor->query()
            ->where('movie_db_id', $movieDbId)
            ->value('id');
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
