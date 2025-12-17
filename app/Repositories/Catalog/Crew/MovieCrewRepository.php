<?php

namespace App\Repositories\Catalog\Crew;

use App\Constants\Pagination;
use App\Models\Catalog\Crew\Crew;
use Illuminate\Database\Eloquent\Collection;

class MovieCrewRepository
{
    private const string DIRECTOR_JOB = 'Director';

    public function __construct(private Crew $crew){}

    public function collection(): Collection
    {
        return $this->crew->query()
            ->orderBy(Pagination::COLUMN_ID, Pagination::SORT_DESC)
            ->get();
    }

    public function findDirectorByMovie(int $movieId): ?Crew
    {
        return $this->crew->query()
            ->whereHas('movies', function ($query) use ($movieId) {
                $query->where('movies.id', $movieId)
                    ->where('crew_movie.job', self::DIRECTOR_JOB);
            })
            ->first();
    }

    public function updateOrCreate(int $movieDbId, array $data): Crew
    {
        return $this->crew->query()->updateOrCreate
        (
            [
                'movie_db_id' => $movieDbId
            ],
            $data
        );
    }
}
