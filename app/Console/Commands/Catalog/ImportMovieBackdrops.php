<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\Movie\Backdrop\ImportMovieBackdropImageService;
use Illuminate\Console\Command;

class ImportMovieBackdrops extends Command
{
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
    public function handle(ImportMovieBackdropImageService $backdropImageService): int
    {
        try {

            $result = $backdropImageService->import();

            $this->info('Импорт заднего фона завершен. Импортировано: ' . $result . ' фонов.');

            return self::SUCCESS;

        } catch (\Exception $e) {

            $this->error('Ошибка импорта заднего фона: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
