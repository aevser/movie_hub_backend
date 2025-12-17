<?php

namespace App\Traits\Movie\Filter;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait Filter
{
    public function scopeFilterByCrews(Builder $query, array|string $directors): Builder
    {
        $directors = is_array($directors) ? $directors : [$directors];

        return $query->whereHas('crews', function (Builder $query) use ($directors) {
            $query->where('job', '=', 'director')
                ->whereIn('crew_id', $directors);
        });
    }

    public function scopeFilterByActors(Builder $query, array|string $actors): Builder
    {
        $actors = is_array($actors) ? $actors : [$actors];

        return $query->whereHas('actors', function (Builder $query) use ($actors) {
            $query->whereIn('actor_id', $actors);
        });
    }

    public function scopeFilterByRating(Builder $query, ?int $ratingFrom, ?int $ratingTo): Builder
    {
        return $query->whereHas('reviews', function (Builder $query) use ($ratingFrom, $ratingTo) {
            if ($ratingFrom !== null) {
                $query->where('rating', '>=', $ratingFrom);
            }

            if ($ratingTo !== null) {
                $query->where('rating', '<=', $ratingTo);
            }
        });
    }

    public function scopeFilterByReleaseDate(Builder $query, ?string $dateFrom, ?string $dateTo): Builder
    {
        if ($dateFrom) {
            $query->where('release_date', '>=', Carbon::parse($dateFrom)->startOfDay());
        }

        if ($dateTo) {
            $query->where('release_date', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        return $query;
    }
}
