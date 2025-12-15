<?php

namespace App\Models\Catalog\Genre;

use App\Models\Catalog\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $fillable = ['movie_db_id', 'name'];

    // Связи
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'genre_movie');
    }
}
