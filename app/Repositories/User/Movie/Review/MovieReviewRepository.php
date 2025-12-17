<?php

namespace App\Repositories\User\Movie\Review;

use App\Models\Catalog\Movie\Movie;
use App\Models\User\MovieReview;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieReviewRepository
{
    private const array RELATIONS = ['movie:id,title,slug,poster_url,release_date, movie.genres'];

    public function __construct(private MovieReview $movieReview){}

    public function getAllReviews(): LengthAwarePaginator
    {
        return $this->movieReview->query()
            ->with([
                'movie:id,title,poster_url,release_date,slug',
                'movie.genres:id,name,slug'
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
    }

    public function getAllReviewsByMovie(int $movieId): LengthAwarePaginator
    {
        return $this->movieReview->query()
            ->where('movie_id', $movieId)
            ->orderBy('id', 'desc')
            ->paginate(10);
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

    public function delete(int $userId, int $id): bool
    {
        return $this->movieReview->query()
            ->where('user_id', $userId)
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
