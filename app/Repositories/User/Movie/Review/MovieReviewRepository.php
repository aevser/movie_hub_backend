<?php

namespace App\Repositories\User\Movie\Review;

use App\Models\User\MovieReview;
use Illuminate\Database\Eloquent\Collection;

class MovieReviewRepository
{
    private const string RELATIONS = 'movie:id,title,poster_url,release_date';

    public function __construct(private MovieReview $movieReview){}

    public function getAuthReviews(int $userId): Collection
    {
        return $this->movieReview->query()
            ->where('user_id', $userId)
            ->with(self::RELATIONS)
            ->get();
    }

    public function create(int $movieId, array $data): MovieReview
    {
        $data['movie_id'] = $movieId;

        return $this->movieReview->query()->create($data);
    }

    public function delete(int $userId, int $movieId, int $id): bool
    {
        return $this->movieReview->query()
            ->where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->findOrFail($id)
            ->delete();
    }
}
