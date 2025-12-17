<?php

namespace App\Console\Commands\Catalog;

use App\Repositories\Catalog\Genre\MovieGenreRepository;
use App\Services\Catalog\Movie\ImportMovieService;
use Illuminate\Console\Command;

class ImportMovies extends Command
{
    private const int CHUNK_SIZE = 30;
    private const int LIMIT = 7;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт фильмов';

    /**
     * Execute the console command.
     */
    public function handle(MovieGenreRepository $genreRepository, ImportMovieService $importMovieService): int
    {
        try {
            $startTime = microtime(true);

            $imported = 0;

            $genreRepository->chunkById(self::CHUNK_SIZE, function ($genres) use ($importMovieService, &$imported)
            {
                foreach ($genres as $genre)
                {
                    $imported += $importMovieService->import(genre: $genre, limit: self::LIMIT);
                }
            });

            $endTime = microtime(true);

            $this->info('Импорт фильмов завершен. Импортировано: ' . $imported . ' фильмов. Затрачено время: ' . round($endTime - $startTime) . ' сек.');

            return self::SUCCESS;

        } catch (\Exception $e) {

            $this->error('Ошибка импорта: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
