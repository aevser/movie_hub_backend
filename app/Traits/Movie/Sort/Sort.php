<?php

namespace App\Traits\Movie\Sort;

use App\Constants\Pagination;
use Illuminate\Database\Eloquent\Builder;

trait Sort
{
    public function scopeApplySort(Builder $query, ?string $sort): Builder
    {
        return match($sort)
        {
            'release_date_asc' => $query->sortByReleaseDate(Pagination::SORT_ASC),
            'release_date_desc' => $query->sortByReleaseDate(Pagination::SORT_DESC),
            'rating_asc' => $query->sortByRating(Pagination::SORT_ASC),
            'rating_desc' => $query->sortByRating(Pagination::SORT_DESC),
            default => $query->sortByReleaseDate(Pagination::SORT_DESC)
        };
    }

    public function scopeSortByRating(Builder $query, string $direction = Pagination::SORT_DESC): Builder
    {
        return $query->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', $direction);
    }

    public function scopeSortByReleaseDate(Builder $query, string $direction = Pagination::SORT_DESC): Builder
    {
        return $query->orderBy('release_date', $direction);
    }
}
