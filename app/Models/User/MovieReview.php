<?php

namespace App\Models\User;

use App\Models\Catalog\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieReview extends Model
{
    protected $fillable = ['user_id', 'movie_id', 'rating', 'review_text'];

    // Связи

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
