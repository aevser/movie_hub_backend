<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\Crew\ImportMovieCrewService;
use Illuminate\Console\Command;

class ImportMovieCrews extends Command
{
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
    public function handle(ImportMovieCrewService $importMovieCrewService): int
    {
        try {

            $result = $importMovieCrewService->import();

            $this->info('Импорт команды завершен. Импортировано: ' . $result . ' членов команды.');

            return self::SUCCESS;

        } catch (\Exception $e) {

            $this->error('Ошибка импорта команды: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
