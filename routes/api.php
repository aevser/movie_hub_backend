<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1;

Route::prefix('v1')->group(function () {

    Route::get('genres', [
        V1\Catalog\Genre\GenreController::class,
        'index'
    ])->name('genres.index');

    Route::get('movies', [
        V1\Catalog\Movie\MovieController::class,
        'index'
    ])->name('movies.index');

    Route::get('movies/{movie:id}', [
        V1\Catalog\Movie\MovieController::class,
        'show'
    ])->name('movies.show');

    Route::get('actors', [
        V1\Catalog\Actor\ActorController::class,
            'index'
        ])->name('actors.index');
});

