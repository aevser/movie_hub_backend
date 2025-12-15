<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1;

Route::prefix('v1')->group(function () {
    Route::get('genres', [V1\Catalog\Genre\GenreController::class, 'index']);

    Route::get('movies', [V1\Catalog\Movie\MovieController::class, 'index']);

    Route::get('movies/{movie}', [V1\Catalog\Movie\MovieController::class, 'show']);

    Route::get('actors', [V1\Catalog\Actor\ActorController::class, 'index']);
});

