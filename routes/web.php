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

