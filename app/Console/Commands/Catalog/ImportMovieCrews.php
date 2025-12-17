<?php

namespace App\Console\Commands\Catalog;

use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\Crew\ImportMovieCrewService;
use Illuminate\Console\Command;

class ImportMovieCrews extends Command
{
    private const int CHUNK_SIZE = 200;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-movie-crews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт команды';

    /**
     * Execute the console command.
     */
    public function handle(MovieRepository $movieRepository, ImportMovieCrewService $importMovieCrewService): int
    {
        try {
            $startTime = microtime(true);

            $imported = 0;

            $movieRepository->chunkById(self::CHUNK_SIZE, function($movies) use ($importMovieCrewService, &$imported)
            {
                foreach ($movies as $movie)
                {
                    $imported += $importMovieCrewService->import(movie: $movie);
                }
            });

            $endTime = microtime(true);

            $this->info('Импорт завершён. Загружено: ' . $imported .' членов команды. Затрачено время: ' . round($endTime - $startTime) . ' сек.');

            return self::SUCCESS;

        } catch (\Exception $e) {

            $this->error('Ошибка импорта команды: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
