<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\Quote\TweetCommand;
use App\Console\Commands\Quote\ImportRandomCommand;
use App\Console\Commands\Quote\ImportFamousCommand;
use App\Console\Commands\Quote\ImportSumitgohilCommand;
use App\Console\Commands\ImportCountry;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        TweetCommand::class,
        ImportRandomCommand::class,
        ImportFamousCommand::class,
        ImportSumitgohilCommand::class,
        ImportCountry::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
