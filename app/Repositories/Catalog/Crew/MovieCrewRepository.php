<?php

namespace App\Repositories\Catalog\Crew;

use App\Models\Catalog\Crew\Crew;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieCrewRepository
{
    public function __construct(private Crew $crew){}

    public function getAllPagination(array $filters): LengthAwarePaginator
    {
        return $this->crew->query()
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 25);
    }

    public function findIdByMovieDbId(int $movieDbId): int
    {
        return $this->crew->query()
            ->where('movie_db_id', $movieDbId)
            ->value('id');
    }

    public function upsert(array $data): void
    {
        $this->crew->query()->upsert(
            $data,
            ['movie_db_id'],
            ['name', 'image_url', 'updated_at']
        );
    }
}
