<?php

namespace App\Models\Catalog\Movie\Image;

use App\Models\Catalog\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieImage extends Model
{
    protected $fillable = ['movie_id', 'image_url', 'image_width', 'image_height'];

    // Связи

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
