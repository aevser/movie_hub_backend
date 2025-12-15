<?php

namespace App\Services\Catalog;

use Illuminate\Support\Facades\Http;

class MovieClientService
{
    public function images(int $movieId): array
    {
        $response = $this->get('/3/movie/' . $movieId . '/images', []);

        return [
            'backdrops' => $response['backdrops'] ?? [],
            'posters' => $response['posters'] ?? []
        ];
    }

    public function credits(int $movieId): array
    {
        $response = $this->get('/3/movie/' . $movieId . '/credits', []);

        return [
            'cast' => $response['cast'] ?? [],
            'crew' => $response['crew'] ?? []
        ];
    }

    public function movies(int $genreMovieDbId, int $page): array
    {
        return $this->get('/3/discover/movie', ['with_genres' => $genreMovieDbId, 'page' => $page])['results'] ?? [];
    }

    public function genres(): array
    {
        return $this->get('/3/genre/movie/list', [])['genres'] ?? [];
    }

    private function get(string $url, array $params): array
    {
        $response = Http::retry(3, 200)->get(
            config('movie.movie_db_url') . $url,
            $params + ['api_key' => config('movie.movie_db_api_key'), 'language' => 'ru']
        );

        return $response->successful() ? $response->json() : [];
    }

}
