<?php

namespace App\Traits\Movie\Filter;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait Filter
{
    public function scopeApplyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['genres']))
        {
            $query->filterByGenres($filters['genres']);
        }

        if (!empty($filters['directors']))
        {
            $query->filterByCrews($filters['directors']);
        }

        if (!empty($filters['actors']))
        {
            $query->filterByActors($filters['actors']);
        }

        if (isset($filters['date_from']) || isset($filters['date_to']))
        {
            $query->filterByReleaseDate
            (
                $filters['date_from'] ?? null,
                $filters['date_to'] ?? null
            );
        }

        if (isset($filters['rating_from']) || isset($filters['rating_to']))
        {
            $query->filterByRating
            (
                $filters['rating_from'] ?? null,
                $filters['rating_to'] ?? null
            );
        }

        return $query;
    }

    public function scopeFilterByGenres(Builder $query, array|string $genres): Builder
    {
        $genres = is_array($genres) ? $genres : [$genres];

        return $query->whereHas('genres', function (Builder $query) use ($genres)
        {
            $query->whereIn('genre_id', $genres);
        });
    }

    public function scopeFilterByCrews(Builder $query, array|string $directors): Builder
    {
        $directors = is_array($directors) ? $directors : [$directors];

        return $query->whereHas('crews', function (Builder $query) use ($directors)
        {
            $query->where('job', '=', 'director')
                ->whereIn('crew_id', $directors);
        });
    }

    public function scopeFilterByActors(Builder $query, array|string $actors): Builder
    {
        $actors = is_array($actors) ? $actors : [$actors];

        return $query->whereHas('actors', function (Builder $query) use ($actors)
        {
            $query->whereIn('actor_id', $actors);
        });
    }

    public function scopeFilterByRating(Builder $query, ?int $ratingFrom, ?int $ratingTo): Builder
    {
        return $query->whereHas('reviews', function (Builder $query) use ($ratingFrom, $ratingTo)
        {
            if ($ratingFrom !== null)
            {
                $query->where('rating', '>=', $ratingFrom);
            }

            if ($ratingTo !== null)
            {
                $query->where('rating', '<=', $ratingTo);
            }
        });
    }

    public function scopeFilterByReleaseDate(Builder $query, ?string $dateFrom, ?string $dateTo): Builder
    {
        if ($dateFrom)
        {
            $query->where
            (
                'release_date', '>=', Carbon::parse($dateFrom)->startOfDay()
            );
        }

        if ($dateTo)
        {
            $query->where
            (
                'release_date', '<=', Carbon::parse($dateTo)->endOfDay()
            );
        }

        return $query;
    }
}
