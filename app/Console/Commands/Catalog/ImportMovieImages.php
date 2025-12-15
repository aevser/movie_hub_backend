<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\Movie\Image\ImportMovieImageService;
use Illuminate\Console\Command;

class ImportMovieImages extends Command
{
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
    public function handle(ImportMovieImageService $importMovieImageService): int
    {
        try {

            $result = $importMovieImageService->import();

            $this->info('Импорт постеров завершен. Импортировано: ' . $result . ' постеров.');

            return self::SUCCESS;

        } catch (\Exception $e) {

            $this->error('Ошибка импорта постеров: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
