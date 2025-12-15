<?php

namespace App\Models\Catalog\Movie;

use App\Models\Catalog\Actor\Actor;
use App\Models\Catalog\Crew\Crew;
use App\Models\Catalog\Genre\Genre;
use App\Models\Catalog\Movie\Backdrop\MovieBackdropImage;
use App\Models\Catalog\Movie\Image\MovieImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = ['movie_db_id', 'title', 'description', 'poster_url', 'release_date'];

    // Связи

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class);
    }

    public function crews(): BelongsToMany
    {
        return $this->belongsToMany(Crew::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(MovieImage::class);
    }

    public function backdrops(): HasMany
    {
        return $this->hasMany(MovieBackdropImage::class);
    }
}
