<?php

namespace App\Services\Catalog\Movie;

use App\Models\Catalog\Genre\Genre;
use App\Repositories\Catalog\Genre\GenreRepository;
use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\MovieClientService;
use Illuminate\Support\Str;

class ImportMovieService
{
    public function __construct(
        private MovieClientService $movieClientService,
        private GenreRepository $genreRepository,
        private MovieRepository $movieRepository
    ){}

    public function import(Genre $genre, int $limit): int
    {
        $attach = [];

        $page = 1;

        $imported = 0;

        do
        {
            $movies = $this->movieClientService->movies(genreMovieDbId: $genre->movie_db_id, page: $page);

            if (empty($movies))
            {
                break;
            }

            foreach ($movies as $movie)
            {
                if ($imported >= $limit)
                {
                    break 2;
                }

                $item = $this->movieRepository->updateOrCreate
                (
                    movieDbId: $movie['id'],
                    data:
                    [
                        'title' => $movie['title'],
                        'slug' => Str::slug($movie['title']),
                        'description' => $movie['overview'],
                        'poster_url' => $movie['poster_path']
                            ? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path']
                            : null,
                        'release_date' => $movie['release_date']
                    ]
                );

                $attach[$item->id] = [];

                $imported++;
            }

            $page++;

        } while ($imported < $limit);

        $this->genreRepository->attachMoviesBatch(genre: $genre, attach: $attach);

        return $imported;
    }
}
