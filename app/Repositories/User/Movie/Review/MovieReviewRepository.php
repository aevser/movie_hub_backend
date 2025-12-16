<?php

namespace App\Repositories\User\Movie\Review;

use App\Models\User\MovieReview;
use Illuminate\Database\Eloquent\Collection;

class MovieReviewRepository
{
    private const string RELATIONS = 'movie:id,title,poster_url,release_date';

    public function __construct(private MovieReview $movieReview){}

    public function getAllReviews(int $movieId): Collection
    {
        return $this->movieReview->query()
            ->with(self::RELATIONS)
            ->where('movie_id', $movieId)
            ->get();
    }

    public function getOneAuthReviews(int $movieId): Collection
    {
        return $this->movieReview->query()
            ->with(self::RELATIONS)
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

    public function delete(int $userId, int $movieId, int $id): bool
    {
        return $this->movieReview->query()
            ->where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->findOrFail($id)
            ->delete();
    }

    public function existsReview(?int $userId, int $movieId): bool
    {
        return $this->movieReview->query()
            ->where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->exists();
    }
}
