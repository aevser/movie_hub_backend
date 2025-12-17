<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('catalog')->group(function () {
    Route::get('/', [Controllers\Catalog\Genre\GenreController::class, 'index'])->name('genres.index');

    Route::get('{genre}/movies', [Controllers\Catalog\Movie\MovieController::class, 'index'])->name('genres.movies.index');

    Route::get('{genre}/{movie}', [Controllers\Catalog\Movie\MovieController::class, 'show'])->name('genres.movies.show');
});

Route::get('registration', [Controllers\User\Registration\RegistrationController::class, 'show'])->name('registration.show');

Route::post('registration', [Controllers\User\Registration\RegistrationController::class, 'store'])->name('registration.store');

Route::get('login', [Controllers\User\Auth\LoginController::class, 'show'])->name('login.show');

Route::post('login', [Controllers\User\Auth\LoginController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('reviews', [Controllers\User\Review\ReviewController::class, 'show'])->name('reviews.index');

    Route::delete('reviews/{id}', [Controllers\User\Review\ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('favorites', [Controllers\User\UserController::class, 'show'])->name('favorites.index');

    Route::post('{genre}/{movie}/reviews', [Controllers\User\Review\ReviewController::class, 'store'])->name('reviews.store');

    Route::delete('{genre}/{movie}/reviews/{id}', [Controllers\User\Review\ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::post('favorites/{movie}', [Controllers\User\UserController::class, 'addFavorite'])->name('favorites.store');

    Route::delete('favorites/{movie}', [Controllers\User\UserController::class, 'removeFavorite'])->name('favorites.destroy');

    Route::post('logout', [Controllers\User\Auth\LogoutController::class, 'logout'])->name('logout');
});

