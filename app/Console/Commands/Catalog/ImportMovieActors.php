<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\Actor\ImportMovieActorService;
use Illuminate\Console\Command;

class ImportMovieActors extends Command
{
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
    public function handle(ImportMovieActorService $importMovieActorService): int
    {
        try {

            $result = $importMovieActorService->import();

            $this->info('Импорт актеров завершен. Импортировано: ' . $result . ' актеров.');

            return self::SUCCESS;

        } catch (\Exception $e) {

            $this->error('Ошибка импорта актеров: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
