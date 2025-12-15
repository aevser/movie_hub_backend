<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\Genre\ImportGenreService;
use Illuminate\Console\Command;

class ImportGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт жанров';

    /**
     * Execute the console command.
     */
    public function handle(ImportGenreService $importGenreService): int
    {
        try {

            $result = $importGenreService->import();

            $this->info('Импорт жанров завершен. Импортировано: ' . $result . ' жанров.');

            return self::SUCCESS;

        } catch (\Exception $e) {

            $this->error('Ошибка импорта жанров: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
