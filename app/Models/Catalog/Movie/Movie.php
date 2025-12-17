<?php

namespace App\Models\Catalog\Movie;

use App\Models\Catalog\Actor\Actor;
use App\Models\Catalog\Crew\Crew;
use App\Models\Catalog\Genre\Genre;
use App\Models\Catalog\Movie\Backdrop\MovieBackdropImage;
use App\Models\Catalog\Movie\Image\MovieImage;
use App\Models\User\MovieReview;
use App\Models\User\User;
use App\Traits\Movie\Filter\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use Filter;

    protected $fillable = ['movie_db_id', 'title', 'slug', 'description', 'poster_url', 'release_date'];

    // Вспомогательные методы

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getDirectorAttribute(): string
    {
        return $this->crews->firstWhere('pivot.job', 'Director');
    }

    // Связи

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_movie');
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_movie')->withPivot('character');
    }

    public function crews(): BelongsToMany
    {
        return $this->belongsToMany(Crew::class, 'crew_movie')->withPivot('job', 'department');
    }

    public function images(): HasMany
    {
        return $this->hasMany(MovieImage::class);
    }

    public function backdrops(): HasMany
    {
        return $this->hasMany(MovieBackdropImage::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_favorite');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(MovieReview::class);
    }
}
