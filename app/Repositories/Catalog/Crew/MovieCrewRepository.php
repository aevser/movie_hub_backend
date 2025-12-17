<?php

namespace App\Repositories\Catalog\Crew;

use App\Constants\Pagination;
use App\Models\Catalog\Crew\Crew;
use App\Models\Catalog\Movie\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieCrewRepository
{
    private const string DIRECTOR_JOB = 'Director';

    public function __construct(private Crew $crew){}

    public function paginate(array $filters): LengthAwarePaginator
    {
        return $this->crew->query()
            ->orderBy(Pagination::COLUMN_ID, Pagination::SORT_DESC)
            ->paginate($filters['perPage'] ?? Pagination::PER_PAGE);
    }

    public function findDirectorByMovie(Movie $movie): ?Crew
    {
        return $this->crew->query()
            ->whereHas('movies', function ($query) use ($movie) {
                $query->where('movies.id', $movie->id)
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
