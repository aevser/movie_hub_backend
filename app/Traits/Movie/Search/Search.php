<?php

namespace App\Traits\Movie\Search;

use Illuminate\Database\Eloquent\Builder;

trait Search
{
    public function scopeApplySearch(Builder $query, ?string $seach): Builder
    {
        if (!empty($seach))
        {
            $query->searchByTitle($seach);
        }

        return $query;
    }

    public function scopeSearchByTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }
}
