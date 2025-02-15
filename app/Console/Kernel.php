<?php

namespace App\Console;

use App\Console\Commands\AutoCommandCms;
use App\Console\Commands\ChangePriceMassive;
use App\Console\Commands\ClearUserSpam;
use App\Console\Commands\CreateThumb;
use App\Console\Commands\CreateThumbBlock;
use App\Console\Commands\CreateThumbBrands;
use App\Console\Commands\CreateThumbHeaders;
use App\Console\Commands\ImportParkos;
use App\Console\Commands\ImportSaviplast;
use App\Console\Commands\MultiCategoriesSaviplast;
use App\Console\Commands\SendReminderRighetto;
use App\Console\Commands\SendReminderBooking;
use App\Console\Commands\SetProductsLangs;
use App\Models\AdminPlugin;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AutoCommandCms::class,
        ImportSaviplast::class,
        MultiCategoriesSaviplast::class,
        CreateThumb::class,
        CreateThumbBrands::class,
        CreateThumbBlock::class,
        CreateThumbHeaders::class,
        SendReminderRighetto::class,
        ChangePriceMassive::class,
        ClearUserSpam::class,
        SetProductsLangs::class,
        SendReminderBooking::class,
        ImportParkos::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->exec('php artisan migrate')->everyMinute();
        $schedule->exec('php artisan cache:clear')->everyMinute();
        $schedule->exec('composer dump-autoload')->everyMinute();
        $schedule->exec('php artisan db:seed')->everyMinute();*/

        //$schedule->command('auto:command')->everyMinute();
        if(env('APP_NAME') == "Righetto"){
            $schedule->command('send:reminder_righetto')
                ->dailyAt("02:00");
        }

        $schedule->command('send:reminder_booking')
            ->dailyAt("08:00");

        if(env('APP_NAME') == "Gioielleria-Manega"){
           // $schedule->command('clear:user_spam')->dailyAt("03:00");
        }

        $parking = AdminPlugin::where("name", "pluginParking")->where("is_active", 1)->first();
        if($parking){
            $schedule->command('import:parkos')
                ->hourly();
        }

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
