<?php

namespace App\Repositories\User;

use App\Models\Catalog\Movie\Movie;
use App\Models\User\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function __construct(private User $user){}

    public function getAllFavoriteMovies(User $user): LengthAwarePaginator
    {
        return $user->favoriteMovies()
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function create(array $data): User
    {
        return $this->user->query()->create($data);
    }

    public function addFavoriteMovie(User $user, Movie $movie): void
    {
        $user->favoriteMovies()->attach($movie->id);
    }

    public function removeFavoriteMovie(User $user, Movie $movie): void
    {
        $user->favoriteMovies()->detach($movie->id);
    }

    public function isFavoriteMovie(?User $user, Movie $movie): bool
    {
        if ($user) {
            return $user->favoriteMovies()->where('movie_id', $movie->id)->exists();
        }

        return false;
    }
}
