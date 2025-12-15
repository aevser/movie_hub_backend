<?php

namespace App\Services\Catalog\Movie;

use App\Repositories\Catalog\Genre\GenreRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\MovieClientService;

class ImportMovieService
{
    public function __construct(
        private MovieClientService $movieClientService,
        private GenreRepository $genreRepository,
        private MovieRepository $movieRepository
    ){}

    public function import(int $limit): int
    {
        $genres = $this->genreRepository->getAllCollection();
        $saved = 0;

        foreach ($genres as $genre) {
            $page = 1;
            $savedPerGenre = 0;

            while ($savedPerGenre < $limit) {
                $movies = $this->movieClientService->movies(
                    genreMovieDbId: $genre->movie_db_id,
                    page: $page
                );

                if (empty($movies)) {
                    break;
                }

                foreach ($movies as $movie) {
                    if ($savedPerGenre >= $limit) {
                        break;
                    }

                    $movieId = $this->saveMovie(movie: $movie);
                    $this->attachGenres(movieId: $movieId, genresIds: $movie['genre_ids'] ?? []);

                    $savedPerGenre++;
                    $saved++;
                }

                $page++;
            }
        }

        return $saved;
    }

    private function saveMovie(array $movie): int
    {
        $this->movieRepository->upsert([
            'movie_db_id' => $movie['id'],
            'title' => $movie['title'],
            'description' => $movie['overview'],
            'poster_url' => $movie['poster_path']
                ? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path']
                : null,
            'release_date' => $movie['release_date'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $this->movieRepository
            ->findIdsByMovieDbIds([$movie['id']])[$movie['id']];
    }

    private function attachGenres(int $movieId, array $genresIds): void
    {
        if (empty($genresIds)) {
            return;
        }

        $genreIds = $this->genreRepository->findIdsByMovieDbIds(movieDbIds: $genresIds);
        $this->movieRepository->attachGenres(movieId: $movieId, genresIds: $genreIds);
    }
}
