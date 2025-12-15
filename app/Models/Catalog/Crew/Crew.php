<?php

namespace App\Models\Catalog\Crew;

use App\Models\Catalog\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Crew extends Model
{
    protected $fillable = ['movie_db_id', 'name', 'image_url'];

    // Связи

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class)->withPivot('job', 'department');
    }
}
