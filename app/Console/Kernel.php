<?php

namespace App\Console;

use App\Console\Commands\CalWTest;
use App\Console\Commands\ClassifyTest;
use App\Console\Commands\CrawlTest;
use App\Console\Commands\RunCrawl;
use App\Console\Commands\RunSummary;
use App\Console\Commands\RunTok;
use App\Console\Commands\TokTest;
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
        CrawlTest::class,
        TokTest::class,
        CalWTest::class,
        ClassifyTest::class,
        RunCrawl::class,
        RunTok::class,
        RunSummary::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
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
