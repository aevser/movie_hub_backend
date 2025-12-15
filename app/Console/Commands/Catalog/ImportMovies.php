<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\Movie\ImportMovieService;
use Illuminate\Console\Command;

class ImportMovies extends Command
{
    private const int LIMIT = 5;

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
    public function handle(ImportMovieService $importMovieService): int
    {
        try {

            $result = $importMovieService->import(self::LIMIT);

            $this->info('Импортировано: ' . $result . ' фильмов.');

            return self::SUCCESS;

        } catch (\Exception $e) {

            $this->error('Ошибка импорта: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
