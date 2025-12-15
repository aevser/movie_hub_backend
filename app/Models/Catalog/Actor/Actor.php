<?php

namespace App\Models\Catalog\Actor;

use App\Models\Catalog\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actor extends Model
{
    protected $fillable = ['movie_db_id', 'name', 'image_url'];

    // Связи

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'actor_movie')->withPivot('character');
    }
}
