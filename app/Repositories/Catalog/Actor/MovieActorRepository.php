<?php

namespace App\Repositories\Catalog\Actor;

use App\Constants\Pagination;
use App\Models\Catalog\Actor\Actor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieActorRepository
{
    private const array LIST_RELATIONS = ['movies'];

    public function __construct(private Actor $actor){}

    public function paginate(array $filters): LengthAwarePaginator
    {
        return $this->actor->query()
            ->orderBy(Pagination::COLUMN_ID, Pagination::SORT_DESC)
            ->paginate($filters['perPage'] ?? Pagination::PER_PAGE);
    }

    public function collection(): Collection
    {
        return $this->actor->query()
            ->with(self::LIST_RELATIONS)
            ->orderBy(Pagination::COLUMN_ID, Pagination::SORT_DESC)
            ->get();
    }

    public function updateOrCreate(int $movieDbId, array $data): Actor
    {
        return $this->actor->query()->updateOrCreate
        (
            [
                'movie_db_id' => $movieDbId
            ],
            $data
        );
    }
}
