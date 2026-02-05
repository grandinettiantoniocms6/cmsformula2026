<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class setShopAreas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-shop-areas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = public_path("sql/shop-areas.sql");

        if (!\File::exists($path)) {
            $this->error("File non trovato: {$path}");
            return Command::FAILURE;
        }

        $sql = \File::get($path);

        try {
            \DB::unprepared($sql);
            $this->info('SQL eseguito con successo ✅');
        } catch (\Throwable $e) {
            $this->error('Errore durante l’esecuzione SQL');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
