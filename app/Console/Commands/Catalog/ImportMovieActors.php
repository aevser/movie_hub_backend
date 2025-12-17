<?php

namespace App\Console\Commands\Catalog;

use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\Actor\ImportMovieActorService;
use Illuminate\Console\Command;

class ImportMovieActors extends Command
{
    private const int CHUNK_SIZE = 200;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-movie-actors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт актеров';

    /**
     * Execute the console command.
     */
    public function handle(MovieRepository $movieRepository, ImportMovieActorService $importMovieActorService): int
    {
        try
        {
            $startTime = microtime(true);

            $imported = 0;

            $movieRepository->chunkById(self::CHUNK_SIZE, function ($movies) use ($importMovieActorService, &$imported)
            {
                foreach ($movies as $movie)
                {
                    $imported += $importMovieActorService->import(movie: $movie);
                }
            });

            $endTime = microtime(true);

            $this->info('Импорт завершён. Импортировано: ' . $imported .'актеров. Затрачено время: ' . round($endTime - $startTime) . ' сек.');

            return self::SUCCESS;

        } catch (\Exception $exception)
        {
            $this->info('Ошибка импорта актеров. ' . $exception->getMessage());

            return self::FAILURE;
        }
    }
}
