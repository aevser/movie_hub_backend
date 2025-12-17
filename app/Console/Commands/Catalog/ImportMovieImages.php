<?php

namespace App\Console\Commands\Catalog;

use App\Repositories\Catalog\Movie\MovieRepository;
use App\Services\Catalog\Movie\Image\ImportMovieImageService;
use Illuminate\Console\Command;

class ImportMovieImages extends Command
{
    private const int CHUNK_SIZE = 100;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-movie-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт постеров';

    /**
     * Execute the console command.
     */
    public function handle(MovieRepository $movieRepository, ImportMovieImageService $importMovieImageService): int
    {
        try {
            $startTime = microtime(true);

            $imported = 0;

            $movieRepository->chunkById(self::CHUNK_SIZE, function ($movies) use ($importMovieImageService, &$imported)
            {
                foreach ($movies as $movie)
                {
                    $imported += $importMovieImageService->import(movie: $movie);
                }
            });

            $endTime = microtime(true);

            $this->info('Импорт постеров завершен. Импортировано: ' . $imported . ' постеров. Затрачено время: ' . round($endTime - $startTime) . ' сек.');

            return self::SUCCESS;

        } catch (\Exception $e)
        {
            $this->error('Ошибка импорта постеров: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
