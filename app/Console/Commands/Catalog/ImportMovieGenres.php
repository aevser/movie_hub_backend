<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\Genre\ImportMovieGenreService;
use Illuminate\Console\Command;

class ImportMovieGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-movie-genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт жанров';

    /**
     * Execute the console command.
     */
    public function handle(ImportMovieGenreService $importGenreService): int
    {
        try
        {
            $startTime = microtime(true);

            $imported = $importGenreService->import();

            $endTime = microtime(true);

            $this->info('Импорт жанров завершен. Импортировано: ' . $imported . ' жанров. Затрачено время: ' . round($endTime - $startTime) . ' сек.');

            return self::SUCCESS;

        } catch (\Exception $e)
        {
            $this->error('Ошибка импорта жанров: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
