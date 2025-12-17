<?php

namespace App\Repositories\User;

use App\Constants\Pagination;
use App\Models\Catalog\Movie\Movie;
use App\Models\User\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function __construct(private User $user){}

    public function paginate(User $user): LengthAwarePaginator
    {
        return $user->favoriteMovies()
            ->orderBy(Pagination::COLUMN_ID, Pagination::SORT_DESC)
            ->paginate(Pagination::PER_PAGE);
    }

    public function create(array $data): User
    {
        return $this->user->query()->create($data);
    }

    public function attachFavoriteMovie(User $user, Movie $movie): void
    {
        $user->favoriteMovies()->syncWithoutDetaching($movie->id);
    }

    public function detachFavoriteMovie(User $user, Movie $movie): void
    {
        $user->favoriteMovies()->detach($movie->id);
    }

    public function existsFavoriteMovie(?User $user, Movie $movie): bool
    {
        if ($user === null)
        {
            return false;
        }

        return $user->favoriteMovies()
            ->where('movie_id', $movie->id)
            ->exists();
    }
}
