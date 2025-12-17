<?php

namespace App\Console\Commands\Catalog;

use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\Movie\Backdrop\ImportMovieBackdropImageService;
use Illuminate\Console\Command;

class ImportMovieBackdrops extends Command
{
    private const int CHUNK_SIZE = 200;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-movie-backdrops';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт заднего фона';

    /**
     * Execute the console command.
     */
    public function handle(MovieRepository $movieRepository, ImportMovieBackdropImageService $backdropImageService): int
    {
        try {
            $startTime = microtime(true);

            $imported = 0;

            $movieRepository->chunkById(self::CHUNK_SIZE, function ($movies) use ($backdropImageService, &$imported)
            {
                foreach ($movies as $movie)
                {
                    $imported += $backdropImageService->import(movie: $movie);
                }
            });

            $endTime = microtime(true);

            $this->info('Импорт заднего фона завершен. Импортировано: ' . $imported . '. Затрачено время: ' . round($endTime - $startTime) . ' сек.');

            return self::SUCCESS;

        } catch (\Exception $e)
        {
            $this->error('Ошибка импорта постеров: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
