<?php

namespace App\Http\Controllers\User\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Review\CreateMovieReviewRequest;
use App\Models\Catalog\Genre\Genre;
use App\Models\Catalog\Movie\Movie;
use App\Models\User\MovieReview;
use App\Repositories\User\Movie\Review\MovieReviewRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(private MovieReviewRepository $movieReviewRepository){}

    public function index(): View
    {
        return view('user.review.show',
            [
                'reviews' => $this->movieReviewRepository->paginateByUser(user: auth()->user())
            ]
        );
    }

    public function store(CreateMovieReviewRequest $request, Genre $genre, Movie $movie): RedirectResponse
    {
        $this->movieReviewRepository->create(userId: auth()->id(), movieId: $movie->id, data: $request->validated());

        return back();
    }

    public function destroy(MovieReview $review): RedirectResponse
    {
        $this->movieReviewRepository->delete(userId: auth()->id(), reviewId: $review->id);

        return back();
    }
}
