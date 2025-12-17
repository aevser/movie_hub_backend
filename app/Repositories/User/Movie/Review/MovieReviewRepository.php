<?php

namespace App\Repositories\User\Movie\Review;

use App\Models\User\MovieReview;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieReviewRepository
{
    private const array LIST_RELATIONS =
    [
        'movie:id,title,slug,poster_url,release_date',
        'movie.genres:id,name,slug'
    ];

    public function __construct(private MovieReview $movieReview){}

    public function paginateByUser(User $user): LengthAwarePaginator
    {
        return $this->movieReview->query()
            ->with(self::LIST_RELATIONS)
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function getAllByMovie(int $movieId): Collection
    {
        return $this->movieReview->query()
            ->with(self::LIST_RELATIONS)
            ->where('movie_id', $movieId)
            ->get();
    }

    public function create(int $userId, int $movieId, array $data): MovieReview
    {
        return $this->movieReview->query()->create
        (
            [
                'user_id' => $userId,
                'movie_id' => $movieId,
                'rating' => $data['rating'],
                'review_text' => $data['review_text']
            ]
        );
    }

    public function delete(int $userId, int $reviewId): bool
    {
        return (bool) $this->movieReview->query()
            ->where('user_id', $userId)
            ->findOrFail($reviewId)
            ->delete();
    }

    public function existsByUserAndMovie(?User $user, int $movieId): bool
    {
        if ($user === null)
        {
            return false;
        }

        return $this->movieReview->query()
            ->where('user_id', $user->id)
            ->where('movie_id', $movieId)
            ->exists();
    }
}
