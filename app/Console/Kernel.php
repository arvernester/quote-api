<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ImportCountry;
use App\Console\Commands\BackupDatabase;
use App\Console\Commands\SitemapIndexCommand;
use App\Console\Commands\ImportQuoteCommand;
use App\Console\Commands\Quote\TweetQuoteCommand;
use App\Console\Commands\GenerateQuoteSlugCommand;
use App\Console\Commands\GenerateAuthorSlugCommand;
use App\Console\Commands\GenerateCategorySlugCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        TweetQuoteCommand::class,
        ImportCountry::class,
        BackupDatabase::class,
        SitemapIndexCommand::class,
        ImportQuoteCommand::class,
        GenerateQuoteSlugCommand::class,
        GenerateAuthorSlugCommand::class,
        GenerateCategorySlugCommand::class,
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
