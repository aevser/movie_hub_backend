<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Movie\Movie;
use App\Repositories\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository) {}

    public function show(): View
    {
        $favorites = $this->userRepository->paginate(user: auth()->user());

        return view('user.favorite.show', compact('favorites'));
    }

    public function addFavorite(Movie $movie): RedirectResponse
    {
        $this->userRepository->attachFavoriteMovie(user: auth()->user(), movie: $movie);

        return redirect()->back();
    }

    public function removeFavorite(Movie $movie): RedirectResponse
    {
        $this->userRepository->detachFavoriteMovie(user: auth()->user(), movie: $movie);

        return redirect()->back();
    }
}
